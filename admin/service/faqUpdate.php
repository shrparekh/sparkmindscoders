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
    $faq_content = $_POST['faq_content'] ?? null;
    $page_url = $_POST['page_url'] ?? null;
    $published = $_POST['published'] ?? null;
    $user = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($id)) $errors[] = "ID is required.";
    if (!empty($name)) $errors[] = "Faq Question is required.";
    if (!empty($faq_content)) $errors[] = "Content is required.";
    if (!empty($page_url)) $errors[] = "Faq Tags is required.";
    if (!empty($published)) $errors[] = "Published status is required.";

    if (empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }


    // Check if the slug is already used by another faq
    try {
        $checkNameSql = "SELECT id FROM faq WHERE name = :name AND id != :id";
        $checkNameStmt = $conn->prepare($checkNameSql);
        $checkNameStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $checkNameStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkNameStmt->execute();
        $existingfaq = $checkNameStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingfaq) {
            // Slug is already in use by another faq
            echo json_encode(['success' => false, 'message' => 'Question is already in use by another Faq.']);
            exit;
        }

        // Perform database update
        $updateSql = "UPDATE faq SET name = :name, faq_content = :faq_content, page_url = :page_url, published = :published, user_id = :user_id WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':faq_content', $faq_content, PDO::PARAM_STR);
        $updateStmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
        $updateStmt->bindParam(':published', $published, PDO::PARAM_INT);
        $updateStmt->bindParam(':user_id', $user, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Check if the update was successful
        if ($updateStmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Faq Name " . $name . " In Database");
            // Success, respond with success message
            echo json_encode(['success' => true, 'message' => '/admin/website/faq?success=Successfully updated the Faq']);
            exit;
        } else {
            // No rows affected, update failed
            echo json_encode(['success' => false, 'message' => 'No changes made to the Faq.']);
            exit;
        }
    } catch (PDOException $e) {
        // Database error, return error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>
