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
    $meta_data = $_POST;

    // Validate required fields
    $required_fields = ['page', 'title', 'descriptions', 'keywords', 'published'];
    foreach ($required_fields as $field) {
        if (empty($meta_data[$field])) {
            $errors[] = "The $field field is required.";
        }
    }

    // Check if a file was uploaded
    if (!isset($_FILES['featured_image_url']) || $_FILES['featured_image_url']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "The featured image field is required and must be a valid image.";
    } else {
        // Get the temporary file path
        $featured_image_url = $_FILES['featured_image_url']['tmp_name'];

        // Validate image type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['featured_image_url']['type'], $allowed_types)) {
            $errors[] = "Invalid image type. Only JPG, PNG, and GIF are allowed.";
        }

        // If no errors, convert and upload the image
        if (empty($errors)) {
            $uploadResult = convertAndUploadToCloudinary($featured_image_url);
            if (isset($uploadResult['success']) && $uploadResult['success'] === false) {
                $errors[] = $uploadResult['message'];
            } else {
                $meta_data['featured_image_url'] = $uploadResult;
            }
        }
    }

    // If there are errors, send a JSON response with errors
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        exit;
    }

    try {
        // Parse the URL
        $parsedUrl = parse_url($meta_data['page']);
        $path = $parsedUrl['path'];
        $user = $_SESSION['user_id'];

        // Insert the form data into the 'seo_metas' table
        $sql = "INSERT INTO seo_metas (page, title, descriptions, keywords, featured_image_url, published,user_id) 
                VALUES (:page, :title, :descriptions, :keywords, :featured_image_url, :published,:user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':page', $path, PDO::PARAM_STR);
        $stmt->bindParam(':title', $meta_data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':descriptions', $meta_data['descriptions'], PDO::PARAM_STR);
        $stmt->bindParam(':keywords', $meta_data['keywords'], PDO::PARAM_STR);
        $stmt->bindParam(':featured_image_url', $meta_data['featured_image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':published', $meta_data['published'], PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user, PDO::PARAM_INT);
        $stmt->execute();

        // Get the ID of the inserted meta
        $meta_id = $conn->lastInsertId();

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Add ON Pages Name " . $meta_data['title'] . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/seo/pages?success=Successfully created the SEO']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    }
}
