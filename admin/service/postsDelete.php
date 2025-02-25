<?php
include '../database/config.php'; // Include database configuration file
include 'log_actionStore.php';
session_start(); // Ensure the session is started
header('Content-Type: application/json'); // Set JSON header
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if request method is POST
    // Retrieve the post ID from the form data
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if (!$id) {
        $response['success'] = false;
        $response['message'] = 'Invalid ID provided.';
        echo json_encode($response);
        exit;
    }

    try {
        // Retrieve the image file path from the database
        $sql = "SELECT image,title FROM posts WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $response['success'] = false;
            $response['message'] = 'Post not found.';
            echo json_encode($response);
            exit;
        }

        $imagePath = $row['image'];

        // Perform the delete operation in the database
        $sqlDelete = "DELETE FROM posts WHERE id = :id";  // SQL query to delete the post
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmtDelete->execute()) { // Execute the delete query
            $rowCount = $stmtDelete->rowCount(); // Get number of affected rows

            if ($rowCount > 0) { // If deletion was successful
                // Remove the image file if it exists
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file from the server
                }
                $user_id = $_SESSION['user_id'] ?? null;
                if ($user_id) {
                    log_action($user_id, "Deleted Post Name: " . $row['title'] . " from Database");
                }
                $response['success'] = true;
                $response['message'] = 'Post deleted successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to delete the post';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'An error occurred while deleting the post';
        }
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Database error: ' . $e->getMessage();
    }

    echo json_encode($response); // Output the JSON response
}
