<?php
// Include database configuration file
include '../database/config.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
// Check if id parameter exists in GET request
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // SQL query to fetch a specific record by id
    $sql = "SELECT posts.*, users.name AS user_name
            FROM posts
            INNER JOIN users ON posts.user_id = users.id
            WHERE posts.id = :id";

    try {
        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the record
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Fetch all tags
            $stmtTags = $conn->query("SELECT id, name FROM tags");
            $allTags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);

            // Fetch post tags for the specific post
            $stmtPostTags = $conn->prepare("SELECT tag_id FROM post_tag WHERE post_id = :post_id"); // Changed parameter name to 'post_id'
            $stmtPostTags->bindParam(':post_id', $id, PDO::PARAM_INT); // Bind 'post_id' parameter correctly
            $stmtPostTags->execute();
            $postTags = $stmtPostTags->fetchAll(PDO::FETCH_COLUMN, 0);

            // Prepare tags with selected status
            $selectedTags = [];
            foreach ($allTags as $tag) {
                $tagDetails = [
                    'id' => $tag['id'],
                    'name' => $tag['name'],
                    'selected' => in_array($tag['id'], $postTags) ? 'selected' : ''
                ];
                $selectedTags[] = $tagDetails;
            }

            // Add selected tags to the result
            $result['tags'] = $selectedTags;

            // Return the record as JSON
            echo json_encode($result);
        } else {
            // Return an empty object if no record found
            echo json_encode(['success' => false, 'message' => 'No record found']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Handle case where id parameter is missing
    echo json_encode(['success' => false, 'message' => 'No id parameter provided']);
}
?>
