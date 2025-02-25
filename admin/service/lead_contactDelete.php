<?php
include '../database/config.php';
include 'log_actionStore.php';

session_start(); // Ensure the session is started

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data sent via POST
    $id = $_POST['id'] ?? null;

    // Perform manual validation
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID is required.']);
        exit;
    }

    try {
        // Fetch the lead contact before deleting
        $fetchSql = "SELECT name FROM lead_contacts WHERE id = :id";
        $fetchStmt = $conn->prepare($fetchSql);
        $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $fetchStmt->execute();
        $row = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Proceed with deletion
            $query = "DELETE FROM lead_contacts WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user_id = $_SESSION['user_id'] ?? null;
                if ($user_id) {
                    log_action($user_id, "Deleted Lead Contact Name: " . $row['name'] . " from Database");
                }
                echo json_encode(['success' => true, 'message' => 'Lead contact deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete lead contact']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Lead contact not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
