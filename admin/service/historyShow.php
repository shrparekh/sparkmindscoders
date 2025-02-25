<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$start_time = microtime(true);

include '../database/config.php';

$request = $_REQUEST;

// Define default values for start, length, and draw
$start = isset($request['start']) && is_numeric($request['start']) && intval($request['start']) >= 0 ? intval($request['start']) : 0;
$length = isset($request['length']) && is_numeric($request['length']) && intval($request['length']) > 0 ? intval($request['length']) : 10;
$draw = isset($request['draw']) ? intval($request['draw']) : 0;

$columns = [
    'action_time',
    'action_description',
    'ip_address',
    'role_name',
    'published',
    'user_name',
];

// Get the total number of records without any filtering
$totalDataQuery = "SELECT COUNT(*) FROM action_logs";
$totalData = $conn->query($totalDataQuery)->fetchColumn();
$totalFiltered = $totalData;

// Start building the base SQL query
$sql = "SELECT action_logs.*, users.name AS user_name, users.published, roles.name as role_name
        FROM action_logs
        INNER JOIN users ON action_logs.user_id = users.id
        LEFT JOIN roles ON users.role_id = roles.id
        WHERE 1=1";

// If there is a search parameter, modify the query
if (!empty($request['search']['value'])) {
    $search_value = '%' . $request['search']['value'] . '%';
    $sql .= " AND (action_logs.action_time LIKE :search_value
                OR action_logs.action_description LIKE :search_value
                OR action_logs.ip_address LIKE :search_value
                OR users.name LIKE :search_value)";
}

// Get the total number of records with filtering
$filterQuery = $conn->prepare($sql);
if (!empty($request['search']['value'])) {
    $filterQuery->bindValue(':search_value', $search_value, PDO::PARAM_STR);
}
$filterQuery->execute();
$totalFiltered = $filterQuery->rowCount();

// Add order by clause
if (!empty($request['order'])) {
    $columnIndex = $request['order'][0]['column'];
    $columnDir = $request['order'][0]['dir'];
    if (isset($columns[$columnIndex])) {
        $sql .= " ORDER BY " . $columns[$columnIndex] . " " . $columnDir;
    }
} else {
    $sql .= " ORDER BY action_logs.action_time DESC";
}

// Add limit clause for pagination
$sql .= " LIMIT :start, :length";


$query = $conn->prepare($sql);
if (!empty($request['search']['value'])) {
    $query->bindValue(':search_value', $search_value, PDO::PARAM_STR);
}
$query->bindValue(':start', $start, PDO::PARAM_INT);
$query->bindValue(':length', $length, PDO::PARAM_INT);

$query->execute();

$data = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData['action_time'] = $row['action_time'];
    $nestedData['action_description'] = $row['action_description'];
    $nestedData['ip_address'] = $row['ip_address'];
    $nestedData['role_name'] = $row['role_name'];
    $nestedData['published'] = $row['published'] == 1 ? "Published" :"Draft";
    $nestedData['user_name'] = $row['user_name'];
    $nestedData['id'] = $row['id'];

    $data[] = $nestedData;
}

$end_time = microtime(true);
$execution_time = ($end_time - $start_time) * 1000; // in milliseconds

// Define benchmarks in milliseconds
$excellentBenchmark = 100; // Less than 100 ms
$goodBenchmark = 300;      // Less than 300 ms
$averageBenchmark = 700;   // Less than 700 ms

// Determine benchmark status
$benchmarkStatus = 'Unknown';
if ($execution_time < $excellentBenchmark) {
    $benchmarkStatus = 'Excellent';
} else if ($execution_time < $goodBenchmark) {
    $benchmarkStatus = 'Good';
} else if ($execution_time < $averageBenchmark) {
    $benchmarkStatus = 'Average';
} else {
    $benchmarkStatus = 'Poor';
}

$json_data = [
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data,
    "execution_time" => $execution_time, // Include execution time in milliseconds
    "benchmark_status" => $benchmarkStatus // Include benchmark status
];

echo json_encode($json_data);
