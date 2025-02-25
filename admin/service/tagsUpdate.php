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
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $slug = $_POST['slug'] ?? null;
    $published = $_POST['published'] ?? null;
    $user = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($id)) $errors[] = "ID is required.";
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($slug)) $errors[] = "Slug is required.";
    if (!empty($published)) $errors[] = "Published status is required.";

    if (empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }


    // Check if the slug is already used by another tag
    try {
        $checkSlugSql = "SELECT id FROM tags WHERE slug = :slug AND id != :id";
        $checkSlugStmt = $conn->prepare($checkSlugSql);
        $checkSlugStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $checkSlugStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkSlugStmt->execute();
        $existingTag = $checkSlugStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingTag) {
            // Slug is already in use by another tag
            echo json_encode(['success' => false, 'message' => 'Slug is already in use by another tag.']);
            exit;
        }

        // Perform database update
        $updateSql = "UPDATE tags SET name = :name, slug = :slug, published = :published, user_id = :user_id WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $updateStmt->bindParam(':published', $published, PDO::PARAM_INT);
        $updateStmt->bindParam(':user_id', $user, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Check if the update was successful
        if ($updateStmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Tag Name " . $name . " In Database");
            // Success, respond with success message
            echo json_encode(['success' => true, 'message' => '/admin/post/tags?success=Successfully updated the tag']);
            exit;
        } else {
            // No rows affected, update failed
            echo json_encode(['success' => false, 'message' => 'No changes made to the tag.']);
            exit;
        }
    } catch (PDOException $e) {
        // Database error, return error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>
