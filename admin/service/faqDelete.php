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

        // Fetch the record before deleting it to log the action
        $fetchSql = "SELECT name FROM faq WHERE id = :id";
        $fetchStmt = $conn->prepare($fetchSql);
        $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $fetchStmt->execute();
        $row = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        // Perform the delete operation in the database
        $sql = "DELETE FROM faq WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (delete was successful)
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            $user_id = $_SESSION['user_id'] ?? null;
            if ($user_id) {
                log_action($user_id, "Deleted faq Name: " . $row['name'] . " from Database");
            }
            echo json_encode(['success' => true, 'message' => 'faq deleted successfully.']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to delete the faq.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
