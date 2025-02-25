<?php
include '../database/config.php'; // Include your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"]) && isset($_POST["comment_status"])) {
    $post_id = $_POST["post_id"];
    $comment_status = $_POST["comment_status"];

    // Assuming the 'comment_status' column is of type INT in the database
    // and you are using prepared statements to prevent SQL injection
    $sql = "UPDATE posts SET comment_status = :comment_status WHERE id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':comment_status', $comment_status, PDO::PARAM_INT);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Update successful
        echo "Comment status updated successfully.";
    } else {
        // Update failed
        echo "Failed to update comment status.";
    }
} else {
    // Invalid request or missing parameters
    echo "Invalid request or missing parameters.";
}
?>
