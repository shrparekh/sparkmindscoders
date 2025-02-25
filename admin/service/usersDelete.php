<?php
session_start();
include '../database/config.php';
include 'log_actionStore.php';
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
header('Content-Type: application/json'); // Set JSON header

$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if request method is POST
    // Retrieve the ID sent via POST
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Validate the ID
    if ($id <= 0) {
        $response['success'] = false;
        $response['message'] = 'Invalid ID provided.';
        echo json_encode($response);
        exit;
    }

    try {
        // Fetch the user record before deleting it to log the action
        $fetchSql = "SELECT name FROM users WHERE id = :id";
        $fetchStmt = $conn->prepare($fetchSql);
        $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $fetchStmt->execute();
        $row = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user record exists
        if (!$row) {
            $response['success'] = false;
            $response['message'] = 'User not found.';
            echo json_encode($response);
            exit;
        }

        // Perform the delete operation in the database
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (delete was successful)
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            // Log the action
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Deleted user with ID $id (Name: " . $row['name'] . ")");

            $response['success'] = true;
            $response['message'] = 'User deleted successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to delete the user.';
        }
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Database error: ' . $e->getMessage();
    }

    echo json_encode($response); // Output the JSON response
}
?>
