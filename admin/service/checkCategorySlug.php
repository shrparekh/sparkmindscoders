<?php
include '../database/config.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = $_POST['slug'] ?? null;
    $response = [];

    if ($slug) {
        try {
            $checkSlugSql = "SELECT COUNT(*) FROM categories WHERE slug = :slug";
            $checkSlugStmt = $conn->prepare($checkSlugSql);
            $checkSlugStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $checkSlugStmt->execute();
            $slugCount = $checkSlugStmt->fetchColumn();

            if ($slugCount > 0) {
                $response['success'] = false;
                $response['message'] = "Slug already exists";
            } else {
                $response['success'] = true;
                $response['message'] = "Slug is available";
            }
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = "Database error: " . $e->getMessage();
        }
    } else {
        $response['success'] = false;
        $response['message'] = "No slug provided";
    }

    echo json_encode($response);
}
?>
