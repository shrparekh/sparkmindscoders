<?php
$CURRENT_URL = $_SERVER['REQUEST_URI'];

if ($CURRENT_URL == '/admin/' || $CURRENT_URL == '/admin' || $CURRENT_URL == '/admin/index.php') {
    include('home.php');
} else if ($CURRENT_URL == '/admin/post/categories') {
    include('blogs/categories/index.php');
} else if (preg_match('/admin\/post\/categories\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('blogs/categories/index.php');
} else if ($CURRENT_URL == '/admin/post/categories/add') {
    include('blogs/categories/add.php');
} else if (preg_match('/admin\/post\/categories\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('blogs/categories/edit.php');
} else if ($CURRENT_URL == '/admin/post/tags') {
    include('blogs/tags/index.php');
} else if (preg_match('/admin\/post\/tags\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('blogs/tags/index.php');
} else if ($CURRENT_URL == '/admin/post/tags/add') {
    include('blogs/tags/add.php');
} else if (preg_match('/admin\/post\/tags\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('blogs/tags/edit.php');
} else if ($CURRENT_URL == '/admin/posts') {
    include('blogs/index.php');
} else if (preg_match('/admin\/posts\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('blogs/index.php');
} else if ($CURRENT_URL == '/admin/post/add') {
    include('blogs/add.php');
} else if (preg_match('/admin\/post\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('blogs/edit.php');
    // Seo pages
} else if ($CURRENT_URL == '/admin/seo/pages') {
    include('seo_optimiztions/seo_pages/index.php');
} else if (preg_match('/admin\/seo\/pages\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('seo_optimiztions/seo_pages/index.php');
} else if ($CURRENT_URL == '/admin/seo/pages/add') {
    include('seo_optimiztions/seo_pages/add.php');
} else if (preg_match('/admin\/seo\/pages\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('seo_optimiztions/seo_pages/edit.php');
    // seo technical
} else if ($CURRENT_URL == '/admin/seo/technical') {
    include('seo_optimiztions/seo_technical/index.php');
} else if (preg_match('/admin\/seo\/technical\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('seo_optimiztions/seo_technical/index.php');
} else if ($CURRENT_URL == '/admin/seo/test') {
    include('seo_optimiztions/seo_test/index.php');
} else if ($CURRENT_URL == '/admin/seo/technical/add') {
    include('seo_optimiztions/seo_technical/add.php');
} else if (preg_match('/admin\/seo\/technical\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('seo_optimiztions/seo_technical/edit.php');
    // Contact
} else if ($CURRENT_URL == '/admin/leads/contact') {
    include('leads_generation/index.php');
    // User
} else if ($CURRENT_URL == '/admin/users/history') {
    include('user_list/history_list/index.php');
} else if ($CURRENT_URL == '/admin/users/profile') {
    include('profile.php');
} else if ($CURRENT_URL == '/admin/users') {
    include('user_list/index.php');
} else if (preg_match('/admin\/users\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('user_list/index.php');
} else if ($CURRENT_URL == '/admin/users/add') {
    include('user_list/add.php');
} else if (preg_match('/admin\/users\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('user_list/edit.php');
    // login
} else if ($CURRENT_URL == '/admin/login') {
    include('login.php');
    // /website Req
} else if ($CURRENT_URL == '/admin/website/clients') {
    include('website_req/client/index.php');
} else if (preg_match('/admin\/website\/clients\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('website_req/client/index.php');
} else if ($CURRENT_URL == '/admin/website/clients/add') {
    include('website_req/client/add.php');
} else if (preg_match('/admin\/website\/clients\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('website_req/client/edit.php');
    
} else if ($CURRENT_URL == '/admin/website/portfolio') {
    include('website_req/portfolio/index.php');
} else if (preg_match('/admin\/website\/portfolio\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('website_req/portfolio/index.php');
} else if ($CURRENT_URL == '/admin/website/portfolio/add') {
    include('website_req/portfolio/add.php');
} else if (preg_match('/admin\/website\/portfolio\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('website_req/portfolio/edit.php');

} else if ($CURRENT_URL == '/admin/website/testimonial') {
    include('website_req/testimonial/index.php');
} else if (preg_match('/admin\/website\/testimonial\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('website_req/testimonial/index.php');
} else if ($CURRENT_URL == '/admin/website/testimonial/add') {
    include('website_req/testimonial/add.php');
} else if (preg_match('/admin\/website\/testimonial\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('website_req/testimonial/edit.php');
    // marketing
} else if ($CURRENT_URL == '/admin/website/companies') {
    include('website_req/marketing/index.php');
} else if (preg_match('/admin\/website\/companies\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('website_req/marketing/index.php');
} else if ($CURRENT_URL == '/admin/website/companies/add') {
    include('website_req/marketing/add.php');
} else if (preg_match('/admin\/website\/companies\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('website_req/marketing/edit.php');
    // /admin/website/related-searches/add
} else if ($CURRENT_URL == '/admin/website/related-searches') {
    include('website_req/related_searches/index.php');
} else if (preg_match('/admin\/website\/related-searches\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('website_req/related_searches/index.php');
} else if ($CURRENT_URL == '/admin/website/related-searches/add') {
    include('website_req/related_searches/add.php');
} else if (preg_match('/admin\/website\/related-searches\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('website_req/related_searches/edit.php');
    // faq
} else if ($CURRENT_URL == '/admin/website/faq') {
    include('website_req/faq/index.php');
} else if (preg_match('/admin\/website\/faq\?success=([^&]+)/', $CURRENT_URL, $matches)) {
    include('website_req/faq/index.php');
} else if ($CURRENT_URL == '/admin/website/faq/add') {
    include('website_req/faq/add.php');
} else if (preg_match('/admin\/website\/faq\/edit\?id=(\d+)/', $CURRENT_URL, $matches)) {
    include('website_req/faq/edit.php');
} else {
    echo $CURRENT_URL;
}
