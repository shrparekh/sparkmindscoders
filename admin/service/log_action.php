<?php
session_start();
include '../database/config.php';
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
// Function to log actions
function log_action($user_id, $action_description) {
    global $conn; // Use the global $conn variable for the database connection

    $action_time = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Insert action log
    $stmt = $conn->prepare("INSERT INTO action_logs (user_id, action_time, action_description, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $action_time, $action_description, $ip_address]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $input = json_decode(file_get_contents('php://input'), true);
    $user_id = $_SESSION['user_id'];
    $action_description = $input['description'];

    log_action($user_id, $action_description);

    echo json_encode(['success' => true, 'message' => 'Action logged successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to log action']);
}
?>
