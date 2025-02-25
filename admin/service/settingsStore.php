<?php
// settingsStore.php
include '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database configuration file

    // Retrieve the data sent via POST
    $site_name = $_POST['site_name'];
    $contact_email = $_POST['contact_email'];
    $description = $_POST['description'];
    $about = $_POST['about'];
    $copy_rights = $_POST['copy_rights'];
    $url_fb = $_POST['url_fb'];
    $url_insta = $_POST['url_insta'];
    $url_twitter = $_POST['url_twitter'];
    $url_linkedin = $_POST['url_linkedin'];

    // Prepare the INSERT query
    $insertSql = "INSERT INTO settings (site_name, contact_email, description, about, copy_rights, url_fb, url_insta, url_twitter, url_linkedin, created_at, updated_at)
                  VALUES (:site_name, :contact_email, :description, :about, :copy_rights, :url_fb, :url_insta, :url_twitter, :url_linkedin, NOW(), NOW())";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bindParam(':site_name', $site_name);
    $insertStmt->bindParam(':contact_email', $contact_email);
    $insertStmt->bindParam(':description', $description);
    $insertStmt->bindParam(':about', $about);
    $insertStmt->bindParam(':copy_rights', $copy_rights);
    $insertStmt->bindParam(':url_fb', $url_fb);
    $insertStmt->bindParam(':url_insta', $url_insta);
    $insertStmt->bindParam(':url_twitter', $url_twitter);
    $insertStmt->bindParam(':url_linkedin', $url_linkedin);

    // Execute the query
    if ($insertStmt->execute()) {
        // Get the ID of the inserted post
         $_id = $conn->lastInsertId();

        header('Location: /admin/settings.php?successfully=' . urlencode($_id) . '&message=Settings added successfully.');
        exit;
    } else {
        header('Location: /admin/settings.php?error=1&message=Failed to add settings.');
        exit;
    }
}
