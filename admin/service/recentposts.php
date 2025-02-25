<?php
include '../database/config.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
header('Content-Type: application/json');

try {
    $sql = "SELECT posts.title, posts.slug, posts.image,posts.image_alt,categories.name AS category_name, users.name AS user_name, 
        posts.created_at, posts.updated_at
        FROM posts
        JOIN categories ON posts.category_id = categories.id
        JOIN users ON posts.user_id = users.id 
        WHERE 1=1 ORDER BY created_at DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $recent_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'recent_posts' => $recent_posts]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
