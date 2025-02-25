<?php
include '../database/config.php';
include("log_actionStore.php");
session_start();;
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
class Code
{
    public function update($data, $id)
    {
        global $conn;
        try {
            $query = "UPDATE codes SET name = :name, type = :type, message = :message,published =:published, user_id = :user_id WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
            $stmt->bindParam(':message', $data['message'], PDO::PARAM_STR);
            $stmt->bindParam(':published', $data['published'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data

    $name = $_POST['name'] ?? null;
    $type = $_POST['type'] ?? null;
    $message = $_POST['message'] ?? null;
    $published = $_POST['published'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $id = $_POST['id'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($type)) $errors[] = "Type is required.";
    if (!empty($message)) $errors[] = "Message is required.";
    if (!empty($published)) $errors[] = "Published is required.";
    if (!empty($user_id)) $errors[] = "User ID is required.";
    if (!empty($id)) $errors[] = "ID is required.";

    if (empty($errors)) {
        // Send error response
        echo json_encode([
            'success' => false,
            'message' => implode(' ', $errors)
        ]);
        exit;
    }


    try {
        // Update the code in the database
        $code = new Code();
        $rowCount = $code->update([
            'name' => $name,
            'type' => $type,
            'message' => $message,
            'published' => $published,
            'user_id' => $user_id,
        ], $id);

        if ($rowCount > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Category Name " . $name . " In Database");
            echo json_encode(['success' => true, 'message' => "/admin/seo/technical?success=Code updated successfully."]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to update the code. It may not exist or no changes were made.']);
        }
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
