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
    // Retrieve the data sent via AJAX
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $slug = $_POST['slug'] ?? null;
    $published = $_POST['published'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($id)) $errors[] = "ID is required.";
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($slug)) $errors[] = "Slug is required.";
    if (!empty($published)) $errors[] = "Published is required.";
    if (!empty($user_id)) $errors[] = "User ID is required.";

    if (empty($errors)) {
        // Return error messages as JSON response
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Check if the new slug is already used by another category
    try {
        $checkSlugQuery = "SELECT id FROM categories WHERE slug = :slug AND id != :id";
        $checkSlugStmt = $conn->prepare($checkSlugQuery);
        $checkSlugStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $checkSlugStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkSlugStmt->execute();
        $existingCategory = $checkSlugStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingCategory) {
            echo json_encode(['success' => false, 'message' => 'Slug is already in use by another category.']);
            exit;
        }

        // Update the category in the database
        $updateQuery = "UPDATE categories SET name = :name, slug = :slug,published=:published, user_id = :user_id WHERE id = :id";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $updateStmt->bindParam(':published', $published, PDO::PARAM_STR);
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Check if any row was affected (update was successful)
        if ($updateStmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Category Name " . $name . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/post/categories?success=Category updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to update the category or no changes made.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
