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
    'id',
    'title',
    'slug',
    'content',
    'image',
    'meta_title',
    'meta_descriptions',
    'meta_keyword',
    'featured_image',
    'published',
    'status',
    'comment_status',
    'views',
    'category_id',
    'user_id',
    'created_at',
    'updated_at'
];

// Get the total number of records without any filtering
$totalDataQuery = "SELECT COUNT(*) FROM posts";
$totalData = $conn->query($totalDataQuery)->fetchColumn();
$totalFiltered = $totalData;

// If there is a search parameter, modify the query
$sql = "SELECT posts.id, posts.title, posts.slug, posts.content, posts.image,posts.image_alt,posts.published, posts.meta_title, posts.meta_descriptions, posts.meta_keyword, posts.featured_image,posts.featured_image_alt, posts.comment_status, posts.views, 
        posts.category_id, categories.name AS category_name, posts.user_id, users.name AS user_name, 
        posts.created_at, posts.updated_at
        FROM posts
        JOIN categories ON posts.category_id = categories.id
        JOIN users ON posts.user_id = users.id 
        WHERE 1=1";

$params = [];
if (!empty($request['search']['value'])) {
    $sql .= " AND (posts.title LIKE :search_value";
    $sql .= " OR posts.slug LIKE :search_value";
    $sql .= " OR posts.content LIKE :search_value";
    $sql .= " OR posts.meta_title LIKE :search_value";
    $sql .= " OR posts.meta_descriptions LIKE :search_value";
    $sql .= " OR posts.meta_keyword LIKE :search_value";
    $sql .= " OR categories.name LIKE :search_value";
    $sql .= " OR posts.created_at LIKE :search_value";
    $sql .= " OR posts.updated_at LIKE :search_value)";
    $params['search_value'] = '%' . $request['search']['value'] . '%';
}

// // Get the total number of records with filtering
// $filterQuery = $conn->prepare($sql);
// if (!empty($params)) {
//     foreach ($params as $key => $value) {
//         $filterQuery->bindValue(':' . $key, $value, PDO::PARAM_STR);
//     }
// }
// $filterQuery->execute();
// $totalFiltered = $filterQuery->rowCount();

// Add order by clause
if (!empty($request['order'])) {
    $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
} else {
    $sql .= " ORDER BY posts.created_at DESC";
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
    $nestedData['title'] = $row['title'];
    $nestedData['slug'] = $row['slug'];
    $nestedData['content'] = $row['content'];
    $nestedData['image'] = $row['image'];
    $nestedData['image_alt'] = $row['image_alt'];
    $nestedData['meta_title'] = $row['meta_title'];
    $nestedData['meta_descriptions'] = htmlspecialchars($row['meta_descriptions']);
    $nestedData['meta_keyword'] = $row['meta_keyword'];
    $nestedData['featured_image'] = $row['featured_image'];
    $nestedData['featured_image_alt'] = $row['featured_image_alt'];
    $nestedData['comment_status'] = $row['comment_status'];
    $nestedData['views'] = $row['views'];
    $nestedData['category_id'] = $row['category_id'];
    $nestedData['user_id'] = $row['user_id'];
    $nestedData['created_at'] = $row['created_at'];
    $nestedData['updated_at'] = $row['updated_at'];
    $nestedData['user_name'] = $row['user_name'];
    $nestedData['published'] =  $row['published'] == 1 ? "Published" :"Draft";
    $nestedData['category_name'] = $row['category_name'];

    $data[] = $nestedData;
}

// Fetch associated tags for the posts
$sqlTags = "SELECT pt.post_id, t.name AS tag_name
            FROM post_tag AS pt
            INNER JOIN tags AS t ON pt.tag_id = t.id";

$rs_tags = $conn->prepare($sqlTags);
$rs_tags->execute();
$tagsArray = $rs_tags->fetchAll(PDO::FETCH_ASSOC);

// Merge tags with each post
foreach ($data as &$post) {
    $post['tags'] = [];
    foreach ($tagsArray as $tag) {
        if ($tag['post_id'] == $post['id']) {
            $post['tags'][] = $tag['tag_name'];
        }
    }
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
