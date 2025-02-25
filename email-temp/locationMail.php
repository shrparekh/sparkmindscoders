<?php
require 'vendor/autoload.php'; // Autoload Composer's dependencies

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


if (isset($_POST['name']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $project = $_POST['project'];
    $mobile = $_POST['mobile'];
    $body = $_POST['message'];
    $location = $_POST['location'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port       = $_ENV['MAIL_PORT'];

        //Recipients
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress('wd.nileshh@gmail.com', 'Ierix Infotech');

        //Content
        $mail->isHTML(true);
        $mail->Subject = "Marketing of" ." ". $location;
        $mail->Body = $body . "<br><br>Full Name: " . $name .  "<br>Email: " . $email . "<br>phone: " . $mobile . "<br>project: " . $project;
        $mail->send();
        echo 'Mail has been sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Fill the all Details';
}
