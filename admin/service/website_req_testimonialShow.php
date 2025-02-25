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

include '../database/config.php'; // Adjust the path as per your file structure

$request = $_REQUEST;

// Define default values for start, length, and draw
$start = isset($request['start']) && is_numeric($request['start']) && intval($request['start']) >= 0 ? intval($request['start']) : 0;
$length = isset($request['length']) && is_numeric($request['length']) && intval($request['length']) > 0 ? intval($request['length']) : 10;
$draw = isset($request['draw']) ? intval($request['draw']) : 0;

$columns = [
    'created_at',
    'name',
    'comment',
    'image',
    'image_alt',
    'published',
    'user_name'
];

// Get the total number of records without any filtering
$totalDataQuery = "SELECT COUNT(*) FROM testimonial";
$totalData = $conn->query($totalDataQuery)->fetchColumn();
$totalFiltered = $totalData;

// If there is a search parameter, modify the query
$sql = "SELECT testimonial.*, users.name AS user_name FROM testimonial INNER JOIN users ON testimonial.user_id = users.id WHERE 1=1";

if (!empty($request['search']['value'])) {
    $sql .= " AND (testimonial.name LIKE :search_value";
    $sql .= " OR testimonial.image LIKE :search_value";
    $sql .= " OR testimonial.comment LIKE :search_value";
    $sql .= " OR testimonial.image_alt LIKE :search_value";
    $sql .= " OR users.name LIKE :search_value";
    $sql .= " OR testimonial.created_at LIKE :search_value)";
}

// Get the total number of records with filtering
$filterQuery = $conn->prepare($sql);
if (!empty($request['search']['value'])) {
    $filterQuery->bindValue(':search_value', '%' . $request['search']['value'] . '%', PDO::PARAM_STR);
}
$filterQuery->execute();
$totalFiltered = $filterQuery->rowCount();

// Add order by clause
if (!empty($request['order'])) {
    $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
} else {
    $sql .= " ORDER BY testimonial.created_at DESC";
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
    $nestedData = [];
    $nestedData['created_at'] = $row['created_at'];
    $nestedData['name'] = $row['name'];
    $nestedData['comment'] = $row['comment'];
    $nestedData['image'] = $row['image'];
    $nestedData['image_alt'] = $row['image_alt'];
    $nestedData['published'] = $row['published'] == 1 ? "Published" :"Draft";
    $nestedData['user_name'] = $row['user_name'];
    $nestedData['updated_at'] = $row['updated_at'];
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
?>
