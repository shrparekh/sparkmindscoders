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

include '../database/config.php'; // Adjust path as per your file structure

$request = $_REQUEST;

// Define default values for start, length, and draw
$start = isset($request['start']) && is_numeric($request['start']) && intval($request['start']) >= 0 ? intval($request['start']) : 0;
$length = isset($request['length']) && is_numeric($request['length']) && intval($request['length']) > 0 ? intval($request['length']) : 10;
$draw = isset($request['draw']) ? intval($request['draw']) : 0;

$columns = [
    'created_at',
    'name',
    'email',
    'subject',
    'message',
    'phone',
    'user_name',
    'accept_time',
    'status',
    'updated_at'
];

// Base SQL query
$sql = "SELECT lead_contacts.*, users.name AS user_name 
        FROM lead_contacts 
        INNER JOIN users ON lead_contacts.user_id = users.id 
        WHERE 1=1";

// If there is a search parameter, modify the query
if (!empty($request['search']['value'])) {
    $sql .= " AND (lead_contacts.name LIKE :search_value";
    $sql .= " OR lead_contacts.email LIKE :search_value";
    $sql .= " OR lead_contacts.subject LIKE :search_value";
    $sql .= " OR lead_contacts.message LIKE :search_value";
    $sql .= " OR lead_contacts.phone LIKE :search_value)";
}

// Get the total number of records without any filtering
$totalDataQuery = "SELECT COUNT(*) FROM lead_contacts";
$totalData = $conn->query($totalDataQuery)->fetchColumn();
$totalFiltered = $totalData;

// // Get the total number of records with filtering
// $filterQuery = $conn->prepare($sql);
// if (!empty($request['search']['value'])) {
//     $filterQuery->bindValue(':search_value', '%' . $request['search']['value'] . '%', PDO::PARAM_STR);
// }
// $filterQuery->execute();
// $totalFiltered = $filterQuery->rowCount();

// Add order by clause
if (!empty($request['order'])) {
    $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
} else {
    $sql .= " ORDER BY created_at DESC";
}

// Add limit clause for pagination
$sql .= " LIMIT :start, :length";

$query = $conn->prepare($sql);
if (!empty($request['search']['value'])) {
    $query->bindValue(':search_value', '%' . $request['search']['value'] . '%', PDO::PARAM_STR);
}
$query->bindValue(':start', $start, PDO::PARAM_INT);
$query->bindValue(':length', $length, PDO::PARAM_INT);

$query->execute();

$data = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    // Format data as needed for DataTables
    $nestedData = [
        'created_at' => $row['created_at'],
        'name' => $row['name'],
        'email' => $row['email'],
        'subject' => $row['subject'],
        'message' => $row['message'],
        'phone' => $row['phone'],
        'accept_time' => $row['accept_time'],
        'user_name' => $row['user_name'],
        'user_id' => $row['user_id'],
        'status' => $row['status'],
        'updated_at' => $row['updated_at'],
        'id' => $row['id']
    ];

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

// Prepare JSON response for DataTables
$json_data = [
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data,
    "execution_time" => $execution_time, // Include execution time in milliseconds
    "benchmark_status" => $benchmarkStatus // Include benchmark status
];

echo json_encode($json_data);
?>
