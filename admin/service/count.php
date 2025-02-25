<?php
include '../database/config.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Set content type header
header('Content-Type: application/json');

try {
    // Initialize an array to store counts
    $counts = [];

    // Query for counts using UNION ALL for optimization
    $sql = "SELECT 
                (SELECT COUNT(*) FROM posts) as posts_count,
                (SELECT COUNT(*) FROM clients) as clients_count,
                (SELECT COUNT(*) FROM testimonial) as testimonial_count,
                (SELECT COUNT(*) FROM users) as users_count";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if counts are fetched successfully
    if ($result) {
        $counts['posts_count'] = $result['posts_count'];
        $counts['clients_count'] = $result['clients_count'];
        $counts['testimonial_count'] = $result['testimonial_count'];
        $counts['users_count'] = $result['users_count'];

        // Return success response with counts
        echo json_encode(['success' => true, 'counts' => $counts]);
    } else {
        // Handle case where counts could not be fetched
        echo json_encode(['success' => false, 'message' => 'Failed to fetch counts']);
    }
} catch (PDOException $e) {
    // Handle database error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
