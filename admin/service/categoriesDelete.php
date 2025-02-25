<?php
session_start();
include '../database/config.php';
include 'log_actionStore.php';

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the ID sent via AJAX
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Validate the ID
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
        exit;
    }

    try {
        // Check for dependent posts
        $checkSql = "SELECT COUNT(*) as count FROM posts WHERE category_id = :id";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        $countResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($countResult['count'] > 0) {
            echo json_encode(['success' => false, 'message' => 'Category cannot be deleted because there are posts associated with it.', 'type' => 'warning']);
            exit;
        }

        // Fetch the category name before deletion
        $nameSql = "SELECT name FROM categories WHERE id = :id";
        $nameStmt = $conn->prepare($nameSql);
        $nameStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $nameStmt->execute();
        $nameResult = $nameStmt->fetch(PDO::FETCH_ASSOC);
        $categoryName = $nameResult ? $nameResult['name'] : '';

        // Perform the delete operation in the database
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (delete was successful)
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            // Assuming you have the user_id stored in the session or you can adjust this as needed
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Delete Deleted Category Name " . $categoryName . " In Database");
            echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to delete the category.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
