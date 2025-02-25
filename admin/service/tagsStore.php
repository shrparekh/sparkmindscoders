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
    $user = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($slug)) $errors[] = "Slug is required.";
    if (empty($published)) $errors[] = "Published status is required.";

    if (!empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Convert the page_url array to JSON
    $page_url_json = json_encode($page_url);

    // Check if the name already exists
    try {
        $checkSlugSql = "SELECT COUNT(*) FROM tags WHERE name = :name";
        $checkSlugStmt = $conn->prepare($checkSlugSql);
        $checkSlugStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $checkSlugStmt->execute();
        $slugCount = $checkSlugStmt->fetchColumn();

        if ($slugCount > 0) {
            // Name already exists, return error
            echo json_encode(['success' => false, 'message' => 'Name already exists']);
            exit;
        }

        // Perform database insertion
        $insertSql = "INSERT INTO tags (name, slug, published, user_id) VALUES (:name, :slug, :published, :user_id)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $insertStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $insertStmt->bindParam(':published', $published, PDO::PARAM_INT);
        $insertStmt->bindParam(':user_id', $user, PDO::PARAM_INT);
        $insertStmt->execute();

        // Get the ID of the inserted tag
        $tag_id = $conn->lastInsertId();

        // Check if the insertion was successful
        if ($insertStmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Add Tag Name " . $name . " In Database");
            // Success, respond with success message
            echo json_encode(['success' => true, 'message' => '/admin/post/tags?success=Successfully created the tag']);
            exit;
        } else {
            // Insertion failed, return error
            echo json_encode(['success' => false, 'message' => 'Failed to create tag.']);
            exit;
        }
    } catch (PDOException $e) {
        // Database error, return error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>
