<?php
// Include database configuration file (adjust path as needed)
include '../database/config.php';
include("log_actionStore.php");
session_start();
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}
// Ensure response type is JSON
header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize response array and errors array
    $response = [];
    $errors = [];

    // Sanitize and retrieve POST data
    $post_data = [
        'id' => $_POST['id'] ?? null,
        'title' => $_POST['title'] ?? '',
        'slug' => $_POST['slug'] ?? '',
        'content' => $_POST['content'] ?? '',
        'meta_title' => $_POST['meta_title'] ?? '',
        'meta_descriptions' => $_POST['meta_descriptions'] ?? '',
        'meta_keyword' => $_POST['meta_keyword'] ?? '',
        'featured_image_alt' => $_POST['featured_image_alt'] ?? '',
        'image_alt' => $_POST['image_alt'] ?? '',
        'category_id' => $_POST['category_id'] ?? null,
        'published' => $_POST['published'] ?? 0, // Assuming default is unpublished
        'user_id' => $_POST['user_id'] ?? null
    ];

    // Validate required fields
    $required_fields = ['id', 'title', 'slug', 'content', 'meta_title', 'meta_descriptions', 'meta_keyword', 'featured_image_alt','image_alt', 'category_id', 'published', 'user_id'];
    foreach ($required_fields as $field) {
        if (empty($post_data[$field])) {
            $errors[] = "The $field field is required.";
        }
    }

    // Validate and process image uploads
    foreach (['image', 'featured_image'] as $file_key) {
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES[$file_key]['tmp_name'];
            $file_type = $_FILES[$file_key]['type'];

            if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
                $errors[] = "Invalid $file_key type. Only JPG, PNG, and GIF are allowed.";
            } else {
                $upload_directory = '../images/posts/';
                if (!file_exists($upload_directory) && !mkdir($upload_directory, 0755, true)) {
                    $errors[] = "Failed to create upload directory.";
                } else {
                    $filename = uniqid() . '_' . str_replace(' ', '_', $_FILES[$file_key]['name']);
                    $target_file = $upload_directory . $filename;

                    if (!move_uploaded_file($file_tmp, $target_file)) {
                        $errors[] = "Failed to upload the $file_key.";
                    } else {
                        $post_data[$file_key] = "/admin/images/posts/$filename";
                    }
                }
            }
        }
    }

    // Validate tags
    $tag_ids = [];
    if (isset($_POST['tag_id']) && is_array($_POST['tag_id'])) {
        foreach ($_POST['tag_id'] as $tag_id) {
            // Sanitize tag_id to prevent SQL injection
            $tag_id = filter_var($tag_id, FILTER_SANITIZE_NUMBER_INT);

            // Check if tag_id exists in the 'tags' table
            $query = "SELECT id FROM tags WHERE id = :tag_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                $errors[] = "Invalid tag selected.";
            } else {
                $tag_ids[] = $tag_id;
            }
        }
    } else {
        $errors[] = "Please select at least one tag.";
    }

    // If there are no errors, proceed with the database operations
    if (empty($errors)) {
        try {
            // Update the post in the 'posts' table
            $query = "UPDATE posts SET 
                      title = :title,
                      slug = :slug,
                      content = :content,
                      meta_title = :meta_title,
                      meta_descriptions = :meta_descriptions,
                      meta_keyword = :meta_keyword,
                      featured_image_alt = :featured_image_alt,
                      image_alt = :image_alt,
                      category_id = :category_id,
                      published = :published,
                      user_id = :user_id,
                      updated_at = NOW()";

            // Add image fields to the query if uploaded
            if (!empty($post_data['image'])) {
                $query .= ", image = :image";
            }
            if (!empty($post_data['featured_image'])) {
                $query .= ", featured_image = :featured_image";
            }

            $query .= " WHERE id = :id";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':title', $post_data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':slug', $post_data['slug'], PDO::PARAM_STR);
            $stmt->bindParam(':content', $post_data['content'], PDO::PARAM_STR);
            $stmt->bindParam(':meta_title', $post_data['meta_title'], PDO::PARAM_STR);
            $stmt->bindParam(':meta_descriptions', $post_data['meta_descriptions'], PDO::PARAM_STR);
            $stmt->bindParam(':meta_keyword', $post_data['meta_keyword'], PDO::PARAM_STR);
            $stmt->bindParam(':featured_image_alt', $post_data['featured_image_alt'], PDO::PARAM_STR);
            $stmt->bindParam(':image_alt', $post_data['image_alt'], PDO::PARAM_STR);
            $stmt->bindParam(':category_id', $post_data['category_id'], PDO::PARAM_INT);
            $stmt->bindParam(':published', $post_data['published'], PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $post_data['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $post_data['id'], PDO::PARAM_INT);

            // Bind image fields if provided
            if (!empty($post_data['image'])) {
                $stmt->bindParam(':image', $post_data['image'], PDO::PARAM_STR);
            }
            if (!empty($post_data['featured_image'])) {
                $stmt->bindParam(':featured_image', $post_data['featured_image'], PDO::PARAM_STR);
            }

            $stmt->execute();

            // Delete existing tags for the post
            $delete_query = "DELETE FROM post_tag WHERE post_id = :post_id";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bindParam(':post_id', $post_data['id'], PDO::PARAM_INT);
            $delete_stmt->execute();

            // Insert new tags associated with the post into the 'post_tag' table
            if (!empty($tag_ids)) {
                $insert_query = "INSERT INTO post_tag (post_id, tag_id) VALUES (:post_id, :tag_id)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bindParam(':post_id', $post_data['id'], PDO::PARAM_INT);
                $insert_stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
                foreach ($tag_ids as $tag_id) {
                    $insert_stmt->execute();
                }
            }
            $user_id = $_SESSION['user_id'];
            log_action($user_id, "Update Posts Name " . $post_data['title'] . " In Database");
            // Set success response
            $response['success'] = true;
            $response['message'] = "/admin/posts?success=Post updated successfully";
        } catch (PDOException $e) {
            // Handle database errors
            $errors[] = "Failed to update the post: " . $e->getMessage();
        }
    }

    // If there are errors, set error response
    if (!empty($errors)) {
        $response['success'] = false;
        $response['message'] = implode(', ', $errors);
    }

    // Output JSON response
    echo json_encode($response);
} else {
    // Handle case where it's not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
