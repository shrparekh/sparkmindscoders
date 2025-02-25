<?php
$CURRENT_URL = $_SERVER['REQUEST_URI'];



if ($CURRENT_URL == '/' || $CURRENT_URL == '/home.php' || $CURRENT_URL == '/index.php') {
    include ('home.php');
} else if ($CURRENT_URL == '/about-us') {
    include ('about.php');
}  else if ($CURRENT_URL == '/website-development') {
    include ('website-development.php');
}  else if ($CURRENT_URL == '/seo') {
    include ('seo.php');
}   else if ($CURRENT_URL == '/graphic-design') {
    include ('graphic-design.php');
} else if (preg_match('/\/blog\/page\/(\d+)/', $CURRENT_URL, $matches) || $CURRENT_URL == '/blog' || preg_match('/\/blog\/categories\/(\w+)/', $CURRENT_URL, $matches) || preg_match('/\/blog\/categories\/page\/(\d+)/', $CURRENT_URL, $matches) || preg_match('/\/blog\/search\/(\w+)/', $CURRENT_URL, $matches)) {
    $page = isset($matches[1]) ? $matches[1] : null;  // Use isset to avoid undefined index warning
    include 'blog.php';
} else if (preg_match('/\/blog\/details\/(.+)/', $CURRENT_URL, $matches) || preg_match('~^/preview/blog/details/[\w-]+$~', $CURRENT_URL, $matches)) {
    $category = $matches[1];
    include 'blog_details.php';
} else if ($CURRENT_URL == '/contact-us') {
    include ('contact.php');
}   else if ($CURRENT_URL == '/portfolio') {
    include ('portfolio.php');
} else if ($CURRENT_URL == '/sitemap') {
    include ('sitemap.xml');
} else if ($CURRENT_URL == '/login') {
    include ('login.php');
} else{
    // header('Location: /404');
    include ('404.php');
    // echo $CURRENT_URL;
}