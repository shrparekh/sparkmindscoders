<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../database/config.php'; // Adjust path as per your file structure
include("log_actionStore.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data sent via POST
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

    // Perform manual validation
    $errors = [];
    if (empty($id)) $errors[] = "ID is required.";
    if (empty($user_id)) $errors[] = "User ID is required.";

    if (!empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    try {
        // Prepare SQL statement
        $query = "UPDATE lead_contacts SET user_id = :user_id, status = :status, accept_time = NOW() WHERE id = :id";
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);

        // Execute the update
        $stmt->execute();

        // Check if update was successful
        if ($stmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Lead contact status " . $status == 1 ? "Yes":"No" . " In Database");
            echo json_encode(['success' => true, 'message' => 'Lead contact updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update lead contact']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
