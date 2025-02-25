<?php
session_start();
include '../database/config.php'; // Database connection
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
function log_action($user_id, $action_description) {
    include '../database/config.php'; // Database connection

    $action_time = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Insert action log
    $stmt = $conn->prepare("INSERT INTO action_logs (user_id, action_time, action_description, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $action_time, $action_description, $ip_address]);
}

$response = [
    'success' => false,
    'message' => 'Logout failed'
];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logout_time = date('Y-m-d H:i:s');

    try {
        // Update logout time in login_history
        $stmt = $conn->prepare("UPDATE login_history SET logout_time = ? WHERE user_id = ? AND logout_time IS NULL");
        $stmt->execute([$logout_time, $user_id]);

        // Log logout action
        log_action($user_id, "User logged out");

        // Destroy the session and unset session variables
        session_unset();
        session_destroy();

        // Prepare the redirect URL
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $redirect = $protocol . $_SERVER['HTTP_HOST'] . "/login";

        // Set response success to true
        $response['success'] = true;
        $response['message'] = $redirect;
    } catch (Exception $e) {
        // Handle exception
        $response['message'] = 'Logout failed: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'No user session found';
}

// Return JSON response
echo json_encode($response);
exit;
?>
