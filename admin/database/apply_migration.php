<?php

include("migration_script.php");
// apply migration
$role->up();
$assign_role->up();
$users->up();
$categories->up();
$tag->up();
$post->up();
$post_tag->up();
$seo->up();
$code->up();
$lead_contacts->up();
$clients->up();
$portfolio->up();
$testimonial->up();
$login_history->up();
$action_logs->up();
$companies->up();
$related_searches->up();
$faq->up();

// Call the importSQL method with the filename of the SQL file
// $importSQL->importSQL("lexleaglexportfile.sql");

?>
