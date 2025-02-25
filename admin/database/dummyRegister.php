<?php
include '../database/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the data sent via POST
    $name = "Spark Minds Coders";
    $assign_roles_name = "Spark Minds Coders";
    $email = "enquiry@sparkmindscoders.com";
    $role_id = '1';
    $password = '!wO"43jm|&57';
    $published = "1";

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
            header('/login');
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
