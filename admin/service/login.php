<?php
include '../database/config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user input
    if (empty($email) || empty($password)) {
        // Display error message for empty fields
        echo json_encode(['success' => false, 'message' => 'Please fill in both email and password fields.']);
        exit;
    }

    // Query to check user credentials and ensure published status
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user is published
    if ($user['published'] != 1) {
        // User exists but is not published
        echo json_encode(['success' => false, 'message' => 'Access blocked.']);
        exit;
    }

    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $user_id = $user['id'];
        $login_time = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Insert login record
        $stmt = $conn->prepare("INSERT INTO login_history (user_id, login_time, ip_address) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $login_time, $ip_address]);

        // Store user data in session
        $_SESSION["name"] = $user["name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role_id"] = $user["role_id"];

        // Send success response
        echo json_encode(['success' => true, 'message' => '/admin/']);
        exit;
    } else {
        // Invalid password
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        exit;
    }
}
?>
