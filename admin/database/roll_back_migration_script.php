<?php

include("migration_script.php");
// Rolling back migration
$faq->down();
$related_searches->down();
$companies->down();
$login_history->down();
$action_logs->down();
$testimonial->down();
$portfolio->down();
$clients->down();
$lead_contacts->down();
$post_tag->down();
$post->down();
$categories->down();
$tag->down();
$seo->down();
$code->down();
$users->down();
$assign_role->down();
$role->down();
