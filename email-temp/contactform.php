<?php
require 'vendor/autoload.php'; // Autoload Composer's dependencies

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


if(isset($_POST['firstname']) && isset($_POST['email'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $body = $_POST['message'];
    $selectservice = $_POST['services'];
    

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
    $mail->addAddress('staff.ierix@gmail.com', 'Ierix Infotech');

    //Content
    $mail->isHTML(true);
	$mail->Subject = "connect with us";
    $mail->Body = $body . "<br><br>firstname: " . $firstname .  "<br>lastname: " . $lastname. "<br>Email: " . $email."<br>phone: " . $phone ."<br>selectservice: " . implode(', ', $selectservice);
    $mail->send();
    echo 'Mail has been sent successfully!';
    // sleep(10); // Delay for 10 seconds
    // header("Location: index.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}else{
    echo 'Fill the all Details';
}
