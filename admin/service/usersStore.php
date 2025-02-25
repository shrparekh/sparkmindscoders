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
    // Retrieve the data sent via POST
    $name = $_POST['name'] ?? null;
    $assign_roles_name = $_POST['assign_roles_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $role_id = $_POST['role_id'] ?? null;
    $password = $_POST['password'] ?? null;
    $published = $_POST['published'] ?? null;
    $password_confirmation = $_POST['password_confirmation'] ?? null;

    // Perform manual validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($role_id)) $errors[] = "Role is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if (empty($published)) $errors[] = "Published is required.";
    if ($password !== $password_confirmation) $errors[] = "Passwords do not match.";

    if (!empty($errors)) {
        // Respond with error messages
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Check if the email already exists in the database
        $queryCheckEmail = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
        $stmtCheckEmail = $conn->prepare($queryCheckEmail);
        $stmtCheckEmail->bindParam(':email', $email, PDO::PARAM_STR);
        $stmtCheckEmail->execute();
        $count = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC)['count'];

        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already exists. Please choose a different email.']);
            $conn->rollBack();
            exit;
        }

        // Insert into assign_roles table
        $assignRoleQuery = "INSERT INTO assign_roles (name) VALUES (:name)";
        $assignRoleStmt = $conn->prepare($assignRoleQuery);
        $assignRoleStmt->bindParam(':name', $assign_roles_name, PDO::PARAM_STR);
        $assignRoleStmt->execute();

        // Get the ID of the newly inserted role
        $assignRoleId = $conn->lastInsertId();

        // Proceed with inserting the new user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (name, email, role_id, assign_role_id, password, published) VALUES (:name, :email, :role_id, :assign_role_id, :password, :published)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':assign_role_id', $assignRoleId, PDO::PARAM_INT); // Corrected here
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':published', $published, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $conn->commit();
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Add User Name " . $name . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/users?success=User created successfully']);
            exit;
        } else {
            $conn->rollBack();
            echo json_encode(['success' => false, 'message' => 'User created, but failed to assign role.']);
            exit;
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>
