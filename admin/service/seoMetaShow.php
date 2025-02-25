<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$fullUrl = $protocol . $domainName;

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
    'id',
    'page',
    'title',
    'descriptions',
    'keywords',
    'published',
    'featured_image_url',
    'user_id',
    'created_at',
    'updated_at'
];

// Get the total number of records without any filtering
$totalDataQuery = "SELECT COUNT(*) FROM seo_metas";
$totalData = $conn->query($totalDataQuery)->fetchColumn();
$totalFiltered = $totalData;

// If there is a search parameter, modify the query
$sql = "SELECT seo_metas.id, seo_metas.page, seo_metas.title, seo_metas.published, seo_metas.descriptions, seo_metas.keywords, seo_metas.featured_image_url, seo_metas.user_id, seo_metas.created_at, seo_metas.updated_at, users.name AS user_name 
        FROM seo_metas
        JOIN users ON seo_metas.user_id = users.id 
        WHERE 1=1";

$params = [];
if (!empty($request['search']['value'])) {
    $sql .= " AND (seo_metas.page LIKE :search_value";
    $sql .= " OR seo_metas.title LIKE :search_value";
    $sql .= " OR seo_metas.descriptions LIKE :search_value";
    $sql .= " OR seo_metas.keywords LIKE :search_value";
    $sql .= " OR users.name LIKE :search_value";
    $sql .= " OR seo_metas.published LIKE :search_value";
    $sql .= " OR seo_metas.created_at LIKE :search_value";
    $sql .= " OR seo_metas.updated_at LIKE :search_value)";
    $params['search_value'] = '%' . $request['search']['value'] . '%';
}

// Get the total number of records with filtering
$filterQuery = $conn->prepare($sql);
if (!empty($params)) {
    foreach ($params as $key => $value) {
        $filterQuery->bindValue(':' . $key, $value, PDO::PARAM_STR);
    }
}
$filterQuery->execute();
$totalFiltered = $filterQuery->rowCount();

// Add order by clause
if (!empty($request['order'])) {
    $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
} else {
    $sql .= " ORDER BY seo_metas.created_at DESC";
}

// Add limit clause for pagination
$sql .= " LIMIT :start, :length";

$query = $conn->prepare($sql);
if (!empty($params)) {
    foreach ($params as $key => $value) {
        $query->bindValue(':' . $key, $value, PDO::PARAM_STR);
    }
}
$query->bindValue(':start', $start, PDO::PARAM_INT);
$query->bindValue(':length', $length, PDO::PARAM_INT);

$query->execute();

$data = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData['id'] = $row['id'];
    $nestedData['page'] = $fullUrl.$row['page'];
    $nestedData['title'] = $row['title'];
    $nestedData['descriptions'] = htmlspecialchars($row['descriptions']);
    $nestedData['keywords'] = $row['keywords'];
    $nestedData['featured_image_url'] = $row['featured_image_url'];
    $nestedData['published'] = $row['published'] == 1 ? "Published" :"Draft";
    $nestedData['user_id'] = $row['user_id'];
    $nestedData['created_at'] = $row['created_at'];
    $nestedData['updated_at'] = $row['updated_at'];
    $nestedData['user_name'] = $row['user_name'];

    $data[] = $nestedData;
}

$end_time = microtime(true);
$execution_time = ($end_time - $start_time) * 1000; // in milliseconds

// Define benchmarks in milliseconds
$excellentBenchmark = 1000; // Less than 1000 ms for "Excellent"

// Determine benchmark status
$benchmarkStatus = ($execution_time < $excellentBenchmark) ? 'Excellent' : 'Good'; // Adjust as needed

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
