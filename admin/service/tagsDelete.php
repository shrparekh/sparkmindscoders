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

    // Validate the ID (optional but recommended)
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
        exit;
    }

    try {
        // Check for dependent post_tag
        $checkSql = "SELECT COUNT(*) as count FROM post_tag WHERE tag_id = :id";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        $countResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($countResult['count'] > 0) {
            echo json_encode(['success' => false, 'message' => 'Tag cannot be deleted because there are posts associated with it.', 'type' => 'warning']);
            exit;
        }

        // Fetch the record before deleting it to log the action
        $fetchSql = "SELECT name FROM tags WHERE id = :id";
        $fetchStmt = $conn->prepare($fetchSql);
        $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $fetchStmt->execute();
        $row = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        // Perform the delete operation in the database
        $sql = "DELETE FROM tags WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (delete was successful)
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            $user_id = $_SESSION['user_id'] ?? null;
            if ($user_id) {
                log_action($user_id, "Deleted Tag Name: " . $row['name'] . " from Database");
            }
            echo json_encode(['success' => true, 'message' => 'Tag deleted successfully.']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to delete the Tag.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
