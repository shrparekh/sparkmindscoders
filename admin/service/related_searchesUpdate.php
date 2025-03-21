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
    $tag_content = $_POST['tag_content'] ?? null;
    $page_url = $_POST['page_url'] ?? null;
    $published = $_POST['published'] ?? null;
    $user = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($id)) $errors[] = "ID is required.";
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($tag_content)) $errors[] = "Content is required.";
    if (!empty($page_url)) $errors[] = "Page URL is required.";
    if (!empty($published)) $errors[] = "Published status is required.";

    if (empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Convert the page_url array to JSON
    $page_url_json = json_encode($page_url);

    // Check if the slug is already used by another tag
    try {
        $checkNameSql = "SELECT id FROM related_searches WHERE name = :name AND id != :id";
        $checkNameStmt = $conn->prepare($checkNameSql);
        $checkNameStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $checkNameStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkNameStmt->execute();
        $existingTag = $checkNameStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingTag) {
            // Slug is already in use by another tag
            echo json_encode(['success' => false, 'message' => 'Name is already in use by another Related Searches.']);
            exit;
        }

        // Perform database update
        $updateSql = "UPDATE related_searches SET name = :name, tag_content = :tag_content, page_url = :page_url, published = :published, user_id = :user_id WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':tag_content', $tag_content, PDO::PARAM_STR);
        $updateStmt->bindParam(':page_url', $page_url_json, PDO::PARAM_STR);
        $updateStmt->bindParam(':published', $published, PDO::PARAM_INT);
        $updateStmt->bindParam(':user_id', $user, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Check if the update was successful
        if ($updateStmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Related Searches Name " . $name . " In Database");
            // Success, respond with success message
            echo json_encode(['success' => true, 'message' => '/admin/website/related-searches?success=Successfully updated the Related Searches']);
            exit;
        } else {
            // No rows affected, update failed
            echo json_encode(['success' => false, 'message' => 'No changes made to the Related Searches.']);
            exit;
        }
    } catch (PDOException $e) {
        // Database error, return error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>
