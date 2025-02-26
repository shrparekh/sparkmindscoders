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
}   else if ($CURRENT_URL == '/blog') {
    include ('blog.php');
} else if ($CURRENT_URL == '/contact-us') {
    include ('contact.php');
}   else if ($CURRENT_URL == '/portfolio') {
    include ('portfolio.php');
} else if ($CURRENT_URL == '/sitemap') {
    include ('sitemap.xml');
} else {
    // header('Location: /404');
    include ('404.php');
    // echo $CURRENT_URL;
}