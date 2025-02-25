<?php
// Include your database configuration and connect to the database
include '../database/config.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
// Query to retrieve tags from your database
$query = "SELECT id, name FROM tags WHERE published = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return tags data as JSON
header('Content-Type: application/json');
echo json_encode($tags);
?>
