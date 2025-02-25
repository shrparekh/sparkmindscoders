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
    $meta_data = $_POST;
    $id = $meta_data['id']; // Assuming you have an 'id' field in your form for the record to update
    $user = $_SESSION['user_id'];
    // Validate the ID
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
        exit;
    }

    try {
        $sql = "UPDATE seo_metas SET
            page = :page,
            title = :title,
            descriptions = :descriptions,
            keywords = :keywords,
            featured_image_url = :featured_image_url,
            published = :published,
            user_id = :user_id
            WHERE id = :id";

        // Check if a file was uploaded for the 'featured_image_url' field and update it
        if (isset($_FILES['featured_image_url']) && $_FILES['featured_image_url']['tmp_name']) {
            if (is_array($meta_data['Thumbnail_Image_available'])) {
                echo json_encode(['success' => false, 'message' => 'Thumbnail_Image_available should be a string.']);
                exit;
            }
            
            // Delete the previous image from Cloudinary
            deleteImage($meta_data['Thumbnail_Image_available']);

            // Convert and upload the new image to Cloudinary
            $meta_data['featured_image_url'] = convertAndUploadToCloudinary($_FILES['featured_image_url']['tmp_name']);
        } else {
            $meta_data['featured_image_url'] = $meta_data['Thumbnail_Image_available'];
        }

        // Parse the URL
        $parsedUrl = parse_url($meta_data['page']);
        $path = $parsedUrl['path'];

        $stmt = $conn->prepare($sql);

        // Bind values to placeholders
        $stmt->bindParam(':page', $path, PDO::PARAM_STR);
        $stmt->bindParam(':title', $meta_data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':descriptions', $meta_data['descriptions'], PDO::PARAM_STR);
        $stmt->bindParam(':keywords', $meta_data['keywords'], PDO::PARAM_STR);
        $stmt->bindParam(':featured_image_url', $meta_data['featured_image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':published', $meta_data['published'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user, PDO::PARAM_INT);

        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update ON Pages Name " . $meta_data['title'] . " In Database");
            echo json_encode(['success' => true, 'message' => '/admin/seo/pages?success=SEO meta updated successfully']);
            
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
?>
