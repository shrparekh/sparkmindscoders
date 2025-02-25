<?php
// settingsUpdate.php
include '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database configuration file

    // Retrieve the data sent via POST
    $id = $_POST['id'];
    $site_name = $_POST['site_name'];
    $contact_email = $_POST['contact_email'];
    $description = $_POST['description'];
    $about = $_POST['about'];
    $copy_rights = $_POST['copy_rights'];
    $url_fb = $_POST['url_fb'];
    $url_insta = $_POST['url_insta'];
    $url_twitter = $_POST['url_twitter'];
    $url_linkedin = $_POST['url_linkedin'];

    // Prepare the UPDATE query
    $updateSql = "UPDATE settings SET
                  site_name = :site_name,
                  contact_email = :contact_email,
                  description = :description,
                  about = :about,
                  copy_rights = :copy_rights,
                  url_fb = :url_fb,
                  url_insta = :url_insta,
                  url_twitter = :url_twitter,
                  url_linkedin = :url_linkedin,
                  updated_at = NOW()
                  WHERE id = :id";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':site_name', $site_name);
    $updateStmt->bindParam(':contact_email', $contact_email);
    $updateStmt->bindParam(':description', $description);
    $updateStmt->bindParam(':about', $about);
    $updateStmt->bindParam(':copy_rights', $copy_rights);
    $updateStmt->bindParam(':url_fb', $url_fb);
    $updateStmt->bindParam(':url_insta', $url_insta);
    $updateStmt->bindParam(':url_twitter', $url_twitter);
    $updateStmt->bindParam(':url_linkedin', $url_linkedin);
    $updateStmt->bindParam(':id', $id);

    // Execute the query
    if ($updateStmt->execute()) {
        header('Location: /admin/settings.php?successfully=' . urlencode($tag_id) . '&message=Settings updated successfully.');
        exit;
    } else {
        header('Location: /admin/settings.php?error=1&message=Failed to update settings.');
        exit;
    }
}
