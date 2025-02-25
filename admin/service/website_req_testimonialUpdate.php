<?php
// Include the database connection and other necessary files
include '../database/config.php';
include("log_actionStore.php");
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
require 'vendor/autoload.php'; // Include the Composer autoloader

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Intervention\Image\ImageManagerStatic as Image;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize Cloudinary with environment variables
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

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testimonial_data = $_POST;
    $id = $testimonial_data['id']; // Assuming you have an 'id' field in your form for the testimonial record to update

    // Validate the ID
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
        exit;
    }

    // Validate required fields for testimonial data
    $required_fields = ['name', 'comment', 'image_alt', 'user_id'];
    foreach ($required_fields as $field) {
        if (empty($testimonial_data[$field])) {
            echo json_encode(['success' => false, 'message' => "The $field field is required."]);
            exit;
        }
    }

    try {
        $sql = "UPDATE testimonial SET
            name = :name,
            comment = :comment,
            image = :image,
            image_alt = :image_alt,
            published = :published,
            user_id = :user_id
            WHERE id = :id";

        // Check if a file was uploaded for the 'image' field and update it
        if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
            // Validate image type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                echo json_encode(['success' => false, 'message' => 'Invalid image type. Only JPG, PNG, and GIF are allowed.']);
                exit;
            }

            // Delete the previous image from Cloudinary if exists
            if (!empty($testimonial_data['image'])) {
                deleteImage($testimonial_data['image']);
            }

            // Convert and upload the new image to Cloudinary
            $testimonial_data['image'] = convertAndUploadToCloudinary($_FILES['image']['tmp_name']);
        } else {
            $testimonial_data['image'] = $testimonial_data['Thumbnail_Image_available'];
        }

        $stmt = $conn->prepare($sql);

        // Bind values to placeholders
        $stmt->bindParam(':name', $testimonial_data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':comment', $testimonial_data['comment'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $testimonial_data['image'], PDO::PARAM_STR);
        $stmt->bindParam(':image_alt', $testimonial_data['image_alt'], PDO::PARAM_STR);
        $stmt->bindParam(':published', $testimonial_data['published'], PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $testimonial_data['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Testimonial Name " . $testimonial_data['name'] . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/website/testimonial?success=testimonial updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No changes made']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    }
}

function deleteImage($imageUrl)
{
    $pattern = "/\/v\d+\/([a-zA-Z0-9]+)\.\w+/";
    if (preg_match($pattern, $imageUrl, $matches)) {
        $publicId = $matches[1];
        $uploadApi = new UploadApi();
        $result = $uploadApi->destroy($publicId);
        return $result;
    } else {
        return ['result' => 'error', 'message' => 'ID not found in URL'];
    }
}

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
