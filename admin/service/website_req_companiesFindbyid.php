<?php
// Include database configuration file
include '../database/config.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
// Check if id parameter exists in GET request
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // SQL query to fetch a specific record by id
    $sql = "SELECT companies.*, users.name AS user_name
            FROM companies
            INNER JOIN users ON companies.user_id = users.id
            WHERE companies.id = :id";

    try {
        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the record
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Return the record as JSON
            echo json_encode($result);
        } else {
            // Return an empty object if no record found
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        // Handle database errors

        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    }
} else {
    // Handle case where id parameter is missing
    echo json_encode(['error' => 'No id parameter provided']);
}
