<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
include '../database/config.php';

try {
    // Initialize variables from request parameters
    $request = $_REQUEST;

    // Default values for pagination
    $start = isset($request['start']) && is_numeric($request['start']) && intval($request['start']) >= 0 ? intval($request['start']) : 0;
    $length = isset($request['length']) && is_numeric($request['length']) && intval($request['length']) > 0 ? intval($request['length']) : 10;
    $draw = isset($request['draw']) ? intval($request['draw']) : 0;

    // Columns that can be ordered
    $columns = [
        'tags.created_at',
        'tags.name',
        'tags.slug',
        'tags.published',
        'user_name',
        'tags.updated_at'
    ];

    // Base SQL query to fetch tags with associated user and post count
    $sql = "SELECT tags.*, users.name AS user_name, COUNT(post_tag.post_id) AS post_count
            FROM tags 
            INNER JOIN users ON tags.user_id = users.id 
            LEFT JOIN post_tag ON tags.id = post_tag.tag_id";

    // If search parameter is provided, add search conditions
    if (!empty($request['search']['value'])) {
        $searchValue = '%' . $request['search']['value'] . '%';
        $sql .= " WHERE tags.name LIKE :search_value 
                      OR tags.slug LIKE :search_value 
                      OR users.name LIKE :search_value 
                      OR tags.created_at LIKE :search_value 
                      OR tags.updated_at LIKE :search_value";
    }

    // Group by all non-aggregated columns
    $sql .= " GROUP BY tags.id, tags.name, tags.slug, tags.published, users.name, tags.created_at, tags.updated_at";

    // Get total number of records without filtering
    $totalDataQuery = "SELECT COUNT(*) FROM tags";
    $totalData = $conn->query($totalDataQuery)->fetchColumn();
    $totalFiltered = $totalData;

    // Add ordering
    if (!empty($request['order'])) {
        $orderColumn = $columns[$request['order'][0]['column']];
        $orderDirection = $request['order'][0]['dir'];
        $sql .= " ORDER BY $orderColumn $orderDirection";
    } else {
        $sql .= " ORDER BY tags.created_at DESC";
    }

    // Add pagination
    $sql .= " LIMIT :start, :length";

    // Prepare and execute final query
    $query = $conn->prepare($sql);
    $query->bindValue(':start', $start, PDO::PARAM_INT);
    $query->bindValue(':length', $length, PDO::PARAM_INT);

    if (!empty($request['search']['value'])) {
        $query->bindValue(':search_value', $searchValue, PDO::PARAM_STR);
    }

    $query->execute();

    // Fetch data and prepare JSON response
    $data = [];
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $nestedData = [
            'created_at' => $row['created_at'],
            'name' => $row['name'],
            'slug' => $row['slug'],
            'published' => $row['published'] == 1 ? "Published" : "Draft",
            'user_name' => $row['user_name'],
            'updated_at' => $row['updated_at'],
            'post_count' => $row['post_count'],
            'id' => $row['id'] // Assuming 'id' is the primary key of 'tags' table
        ];
        $data[] = $nestedData;
    }

    // Prepare JSON response for DataTables
    $response = [
        'draw' => $draw,
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered,
        'data' => $data
    ];

    // Output JSON response
    echo json_encode($response);

} catch (PDOException $e) {
    // Log database errors
    error_log("Database error: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database error occurred']);
    exit;
} catch (Exception $e) {
    // Log other errors
    error_log("Error: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'An error occurred']);
    exit;
}
?>
