
<?php
include './database/config.php';


function findPostById($postId) {
    global $conn;
    $sql = "SELECT posts.id, posts.title, posts.slug, posts.content, posts.image, posts.status, posts.comment_status, posts.views, 
            posts.category_id, categories.name AS category_name, posts.user_id, users.name AS user_name, 
            posts.created_at, posts.updated_at
            FROM posts
            JOIN categories ON posts.category_id = categories.id
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = :post_id";

    try {
        // Prepare and execute the SQL query with the given post ID as a parameter
        $rs_result = $conn->prepare($sql);
        $rs_result->execute(['post_id' => $postId]);
        $row = $rs_result->fetch(PDO::FETCH_ASSOC);

        // If a post is found with the given ID, return it as an associative array
        if ($row) {
            return $row;
        } else {
            // If no post is found, return null
            return null;
        }
    } catch (Exception $e) {
        // In case of an exception or error, return null
        return null;
    }
}

// Example usage:
$postId = $_GET['id']; // Replace 1 with the desired post ID you want to find
$postData = findPostById($postId);
if ($postData) {
    return $postData;
} else {
    echo "Post not found.";
}
?>