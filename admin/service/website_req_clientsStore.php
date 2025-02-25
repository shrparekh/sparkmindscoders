<?php
// Include the database connection 
include '../database/config.php';
include("log_actionStore.php");
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Include Cloudinary and Intervention Image
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Intervention\Image\ImageManagerStatic as Image;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Configuration::instance([
    'cloud' => [
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key' => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
    ],
    'url' => [
        'secure' => true
    ]
]);

// Function to convert and upload images to Cloudinary
function convertAndUploadToCloudinary($imagePath)
{
    try {
        // Open the original image
        $image = Image::make($imagePath);

        // Create a temporary file to store the webp image
        $tempwebpPath = tempnam(sys_get_temp_dir(), 'webp_') . '.webp';

        // Convert the image to webp format with a specific quality level (e.g., 70)
        $image->encode('webp', 70)->save($tempwebpPath);

        // Upload the webp image to Cloudinary
        $uploadApi = new UploadApi();
        $result = $uploadApi->upload($tempwebpPath, ['resource_type' => 'auto']);

        // Get the URL of the uploaded image from Cloudinary
        $imageUrl = $result['secure_url'];

        // Clean up the temporary webp file
        unlink($tempwebpPath);
        return $imageUrl;
    } catch (\Exception $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $client_data = $_POST;

    // Validate required fields
    $required_fields = ['name', 'image_alt', 'published', 'user_id'];
    foreach ($required_fields as $field) {
        if (empty($client_data[$field])) {
            $errors[] = "The $field field is required.";
        }
    }

    // Check if a file was uploaded for image
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "The image field is required and must be a valid image file.";
    } else {
        // Get the temporary file path
        $image_path = $_FILES['image']['tmp_name'];

        // Validate image type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $errors[] = "Invalid image type. Only JPG, PNG, and GIF are allowed.";
        }

        // If no errors, convert and upload the image to Cloudinary
        if (empty($errors)) {
            $uploadResult = convertAndUploadToCloudinary($image_path);
            if (isset($uploadResult['success']) && $uploadResult['success'] === false) {
                $errors[] = $uploadResult['message'];
            } else {
                $client_data['image'] = $uploadResult;
            }
        }
    }

    // If there are errors, send a JSON response with errors
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    try {
        // Insert client data into the 'clients' table
        $sql = "INSERT INTO clients (name, image, image_alt, published, user_id) 
                VALUES (:name, :image, :image_alt, :published, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $client_data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $client_data['image'], PDO::PARAM_STR);
        $stmt->bindParam(':image_alt', $client_data['image_alt'], PDO::PARAM_STR);
        $stmt->bindParam(':published', $client_data['published'], PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $client_data['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Add Client Name " . $client_data['name'] . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/website/clients?success=Client added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add client']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
