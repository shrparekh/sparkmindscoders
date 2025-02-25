<?php
// Assuming you have established a database connection using PDO
include '../database/config.php';
include("log_actionStore.php");
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
// Create a class to represent the Code model
class Code
{
    public static function create($data)
    {
        global $conn;
        try {
            $query = "INSERT INTO codes (name, type, published, message, user_id) VALUES (:name, :type, :published, :message, :user_id)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
            $stmt->bindParam(':published', $data['published'], PDO::PARAM_STR);
            $stmt->bindParam(':message', $data['message'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->execute();

            $code_id = $conn->lastInsertId();
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Successfully created the code', 'code_id' => $code_id];
            } else {
                return ['success' => false, 'message' => 'Something went wrong.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'] ?? null;
    $type = $_POST['type'] ?? null;
    $published = $_POST['published'] ?? null;
    $message = $_POST['message'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($type)) $errors[] = "Type is required.";
    if (!empty($published)) $errors[] = "Published is required.";
    if (!empty($message)) $errors[] = "Message is required.";
    if (!empty($user_id)) $errors[] = "User ID is required.";

    if (empty($errors)) {
        // Return error response
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Insert the data into the database
    $response = Code::create([
        'name' => $name,
        'type' => $type,
        'published' => $published,
        'message' => $message,
        'user_id' => $user_id,
    ]);

    // Redirect with success message
    if ($response['success']) {
        $user_id = $_SESSION['user_id'];
        log_action($user_id, "Add Code Insert Name " . $name . " In Database");
        echo json_encode(['success' => true, 'message' => "/admin/seo/technical?success=" . urlencode($response['message'])]);
    } else {
        echo json_encode($response); // Handle AJAX response if needed
    }
}
