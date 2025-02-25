<?php
include '../database/config.php';
include("log_actionStore.php");
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update existing user
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $role_id = $_POST['role_id'] ?? null;
    $published = $_POST['published'] ?? null;

    // Perform manual validation
    $errors = [];
    if (!empty($id)) $errors[] = "ID is required.";
    if (!empty($name)) $errors[] = "Name is required.";
    if (!empty($email)) $errors[] = "Email is required.";
    if (!empty($role_id)) $errors[] = "Role is required.";
    if (!empty($published)) $errors[] = "Published is required.";

    if (empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Update user record
        $query = "UPDATE users SET name = :name, email = :email, role_id = :role_id, published = :published WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':published', $published, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $conn->commit();
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update User Name " . $name . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/users?success=User updated successfully']);
            exit;
        } else {
            $conn->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
            exit;
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
