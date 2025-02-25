<?php 
function log_action($user_id, $action_description) {
    global $conn; // Use the global $conn variable for the database connection

    $action_time = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Insert action log
    $stmt = $conn->prepare("INSERT INTO action_logs (user_id, action_time, action_description, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $action_time, $action_description, $ip_address]);
}
?>