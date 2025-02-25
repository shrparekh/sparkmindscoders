<?php
include '../database/config.php';
include 'log_actionStore.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
require 'vendor/autoload.php'; // Include the Composer autoloader

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the ID sent via AJAX
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Validate the ID
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
        exit;
    }

    try {
        // Fetch the featured image URL
        $sql = "SELECT featured_image_url,page FROM seo_metas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $featured_image_url = $row['featured_image_url'];

            // Function to extract public ID from Cloudinary URL
            function findPublicId($url)
            {
                $pattern = "/\/v\d+\/([a-zA-Z0-9_]+)\.\w+$/";
                if (preg_match($pattern, $url, $matches)) {
                    return $matches[1];
                }
                return false;
            }

            $publicId = findPublicId($featured_image_url);
            if ($publicId) {
                $uploadApi = new UploadApi();
                $result = $uploadApi->destroy($publicId);

                if ($result['result'] !== 'ok') {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete image from Cloudinary.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid Cloudinary image URL.']);
                exit;
            }

            // Delete the record from the database
            $sqlDelete = "DELETE FROM seo_metas WHERE id = :id";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmtDelete->execute()) {
                $rowCount = $stmtDelete->rowCount();
                if ($rowCount > 0) {
                    $user_id = $_SESSION['user_id'] ?? null;
                    if ($user_id) {
                        log_action($user_id, "Deleted Seo ON Page Name: " . $row['page'] . " from Database");
                    }
                    echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Unable to delete the record.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'An error occurred while deleting the record.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Record not found.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit;
    }
}
