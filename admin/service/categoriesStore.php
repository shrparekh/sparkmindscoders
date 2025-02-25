<?php
include '../database/config.php';
include("log_actionStore.php");
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data sent via POST
    $name = $_POST['name'] ?? null;
    $slug = $_POST['slug'] ?? null;
    $published = $_POST['published'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($slug)) $errors[] = "Slug is required.";
    if (!empty($published)) $errors[] = "Published is required.";
    if (!empty($user_id)) $errors[] = "User ID is required.";

    if (empty($errors)) {
        // Return error messages as JSON response
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Check if the slug already exists
    try {
        $checkSlugSql = "SELECT COUNT(*) FROM categories WHERE slug = :slug";
        $checkSlugStmt = $conn->prepare($checkSlugSql);
        $checkSlugStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $checkSlugStmt->execute();
        $slugCount = $checkSlugStmt->fetchColumn();

        if ($slugCount > 0) {
            // Slug already exists, return error
            echo json_encode(['success' => false, 'message' => 'Slug already exists']);
            exit;
        }

        // Perform database insertion
        $insertSql = "INSERT INTO categories (name, slug, published,user_id) VALUES (:name, :slug,:published, :user_id)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $insertStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $insertStmt->bindParam(':published', $published, PDO::PARAM_STR);
        $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $insertStmt->execute();

        // Get the ID of the inserted category
        $categories_id = $conn->lastInsertId();

        // Check if the insertion was successful
        if ($insertStmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Add Category Name " . $name . " In Database");
            // Success, return success message
            echo json_encode(['success' => true, 'message' => '/admin/post/categories?success=Successfully created the Category']);
        } else {
            // Insertion failed, return error
            echo json_encode(['success' => false, 'message' => 'Something went wrong during insertion.']);
        }
    } catch (PDOException $e) {
        // Database error, return error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
