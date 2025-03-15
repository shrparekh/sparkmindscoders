<?php
include 'admin/database/config.php';

function postsPaginations($page = 1, $perPage = 10)
{
  global $conn;

  // Calculate the offset based on the page number and number of posts per page
  $offset = ($page - 1) * $perPage;

  // Updated SQL query to fetch the total count of posts
  $countSql = "SELECT COUNT(*) AS total FROM posts WHERE published = 1";
  $totalResult = $conn->query($countSql);
  $totalRows = $totalResult->fetch(PDO::FETCH_ASSOC)['total'];

  $sql = "SELECT 
        posts.id, posts.title, posts.slug, posts.content, posts.image,  posts.comment_status, posts.views, 
        posts.category_id, categories.name AS category_name, categories.slug AS category_slug, posts.user_id, 
        posts.created_at, posts.updated_at
    FROM 
        posts
    JOIN 
        categories ON posts.category_id = categories.id
    WHERE 
        posts.published = 1
    ORDER BY 
        posts.created_at DESC
    LIMIT :offset, :perPage";

  try {
    // Prepare and execute the SQL query with the given post ID and pagination parameters
    $rs_result = $conn->prepare($sql);
    $rs_result->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $rs_result->bindValue(':offset', $offset, PDO::PARAM_INT);
    $rs_result->execute();
    $rows = $rs_result->fetchAll(PDO::FETCH_ASSOC);

    // Return both the posts and the total number of pages
    return ['posts' => $rows, 'totalPages' => ceil($totalRows / $perPage)];
  } catch (Exception $e) {
    // In case of an exception or error, return null
    return null;
  }
}

function postsPaginationsCategories($page = 1, $perPage = 10, $categorySlug = '')
{
  global $conn;

  // Calculate the offset based on the page number and number of posts per page
  $offset = ($page - 1) * $perPage;

  // Construct the SQL query
  $sql = "SELECT 
        posts.id, posts.title, posts.slug, posts.content, posts.image,  posts.comment_status, posts.views, 
        posts.category_id, categories.name AS category_name, categories.slug AS category_slug, posts.user_id, 
        posts.created_at, posts.updated_at
    FROM 
        posts
    JOIN 
        categories ON posts.category_id = categories.id
    WHERE 
        posts.published = 1";

  // Add WHERE clause only if categorySlug is provided
  if (!empty($categorySlug)) {
    $sql .= " AND categories.slug = :categorySlug";
  }

  // Order by created_at in descending order
  $sql .= " ORDER BY posts.created_at DESC
    LIMIT :offset, :perPage";

  try {
    // Prepare and execute the SQL query with the given post ID and pagination parameters
    $rs_result = $conn->prepare($sql);
    $rs_result->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $rs_result->bindValue(':offset', $offset, PDO::PARAM_INT);

    // Bind categorySlug as string
    if (!empty($categorySlug)) {
      $rs_result->bindValue(':categorySlug', $categorySlug, PDO::PARAM_STR);
    }

    $rs_result->execute();
    $rows = $rs_result->fetchAll(PDO::FETCH_ASSOC);

    // Updated SQL query to fetch the total count of posts
    $countSql = "SELECT COUNT(*) AS total FROM posts WHERE published = 1";

    // Add WHERE clause only if categorySlug is provided
    if (!empty($categorySlug)) {
      $countSql .= " AND category_id = (SELECT id FROM categories WHERE slug = :categorySlug)";
    }

    $totalResult = $conn->prepare($countSql);

    // Bind categorySlug as string
    if (!empty($categorySlug)) {
      $totalResult->bindValue(':categorySlug', $categorySlug, PDO::PARAM_STR);
    }

    $totalResult->execute();
    $totalRows = $totalResult->fetch(PDO::FETCH_ASSOC)['total'];

    // Return both the posts and the total number of pages
    return ['posts' => $rows, 'totalPages' => ceil($totalRows / $perPage)];
  } catch (Exception $e) {
    // In case of an exception or error, return null
    return null;
  }
}

function postsPaginationsSearch($page = 1, $perPage = 10, $keyword = '')
{
  global $conn;

  // Calculate the offset based on the page number and number of posts per page
  $offset = ($page - 1) * $perPage;

  // Construct the SQL query
  $sql = "SELECT 
        posts.id, posts.title, posts.slug, posts.content, posts.image,  posts.comment_status, posts.views, 
        posts.category_id, categories.name AS category_name, categories.slug AS category_slug, posts.user_id, 
        posts.created_at, posts.updated_at
    FROM 
        posts
    JOIN 
        categories ON posts.category_id = categories.id
    WHERE 
        posts.published = 1";

  // Add keyword search condition
  if (!empty($keyword)) {
    $sql .= " AND (posts.title LIKE :keyword OR posts.content LIKE :keyword)";
  }

  // Order by created_at in descending order
  $sql .= " ORDER BY posts.created_at DESC
    LIMIT :offset, :perPage";

  try {
    // Prepare and execute the SQL query with the given pagination parameters
    $rs_result = $conn->prepare($sql);
    $rs_result->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $rs_result->bindValue(':offset', $offset, PDO::PARAM_INT);

    // Bind keyword if provided
    if (!empty($keyword)) {
      $rs_result->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
    }

    $rs_result->execute();
    $rows = $rs_result->fetchAll(PDO::FETCH_ASSOC);

    // Updated SQL query to fetch the total count of posts
    $countSql = "SELECT COUNT(*) AS total FROM posts WHERE published = 1";

    // Add keyword condition if provided
    if (!empty($keyword)) {
      $countSql .= " AND (posts.title LIKE :keyword OR posts.content LIKE :keyword)";
    }

    // Prepare and execute the total count query
    $totalResult = $conn->prepare($countSql);
    if (!empty($keyword)) {
      $totalResult->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
    }
    $totalResult->execute();
    $totalRows = $totalResult->fetch(PDO::FETCH_ASSOC)['total'];

    // Return both the posts and the total number of pages
    return ['posts' => $rows, 'totalPages' => ceil($totalRows / $perPage)];
  } catch (Exception $e) {
    // In case of an exception or error, return null
    return null;
  }
}

function Getcategories()
{
  global $conn;
  $sql = "SELECT * FROM categories WHERE published = 1";

  try {
    // Prepare and execute the SQL query
    $rs_result = $conn->prepare($sql);
    $rs_result->execute();
    $row = $rs_result->fetchAll(PDO::FETCH_ASSOC);

    return $row ?: [];
  } catch (Exception $e) {
    // In case of an exception or error, return null
    return [];
  }
}

function Gettags()
{
  global $conn;
  $sql = "SELECT * FROM tags WHERE published = 1";

  try {
    // Prepare and execute the SQL query
    $rs_result = $conn->prepare($sql);
    $rs_result->execute();
    $row = $rs_result->fetchAll(PDO::FETCH_ASSOC);

    return $row ?: [];
  } catch (Exception $e) {
    // In case of an exception or error, return null
    return [];
  }
}

function Getlates_posts()
{
  global $conn;
  $sql = "SELECT 
        posts.id, posts.title, posts.slug, posts.content, posts.image,  posts.comment_status, posts.views, 
        posts.category_id, categories.name AS category_name, categories.slug AS category_slug, posts.user_id, 
        posts.created_at, posts.updated_at
    FROM 
        posts
    JOIN 
        categories ON posts.category_id = categories.id
    WHERE 
        posts.published = 1
    ORDER BY 
        posts.created_at DESC
    LIMIT 10";

  try {
    // Prepare and execute the SQL query
    $rs_result = $conn->prepare($sql);
    $rs_result->execute();
    $row = $rs_result->fetchAll(PDO::FETCH_ASSOC);

    return $row ?: [];
  } catch (Exception $e) {
    // In case of an exception or error, return null
    return [];
  }
}

// Fetch the latest posts
$lates_posts = Getlates_posts();

// Get the current page number from the URL
$uri_parts = explode('/', $_SERVER['REQUEST_URI']);
$results_per_page = 9;

$postData = null;

if (isset($uri_parts[2]) && $uri_parts[2] == 'categories' && count($uri_parts) == 4) {
  $getpage = isset($uri_parts[3]) && is_numeric($uri_parts[3]) ? $uri_parts[3] : 1;
  $postData = postsPaginationsCategories($getpage, $results_per_page, $uri_parts[3]);
}
if (isset($uri_parts[4]) && $uri_parts[4] == 'page' && count($uri_parts) == 6) {
  $getpage = isset($uri_parts[5]) && is_numeric($uri_parts[5]) ? $uri_parts[5] : 1;
  $postData = postsPaginationsCategories($getpage, $results_per_page, $uri_parts[3]);
}
if (isset($uri_parts[1]) && $uri_parts[1] == 'blog' && count($uri_parts) == 2) {
  $getpage = isset($uri_parts[3]) && is_numeric($uri_parts[3]) ? $uri_parts[3] : 1;
  $postData = postsPaginations($getpage, $results_per_page);
}
if (isset($uri_parts[2]) && $uri_parts[2] == 'page' && count($uri_parts) == 4) {
  $getpage = isset($uri_parts[3]) && is_numeric($uri_parts[3]) ? $uri_parts[3] : 1;
  $postData = postsPaginations($getpage, $results_per_page);
}
if (isset($uri_parts[2]) && $uri_parts[2] == 'search' && count($uri_parts) == 4) {
  $getpage = isset($uri_parts[3]) && is_numeric($uri_parts[3]) ? $uri_parts[3] : 1;
  $postData = postsPaginationsSearch($getpage, $results_per_page, $uri_parts[3]);
}

$posts = $postData['posts'] ?? [];
$number_of_pages = $postData['totalPages'] ?? 1;

$categories = Getcategories();
$tags = Gettags();
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">

  <!-- Site Title -->
  <title>SparkMindsCoders | From Web Development to SEO – We’ve Got You Covered</title>

  <!-- Place favicon.ico in the root directory -->
  <link rel="shortcut icon" type="image/x-icon" href="/assets/images/fav-icon.png">

  <!-- CSS here -->
  <link rel="stylesheet" href="/assets/css/animate.min.css">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/font-awesome-pro.min.css">
  <link rel="stylesheet" href="/assets/css/flaticon_garvina.css">
  <link rel="stylesheet" href="/assets/css/icomoon.css">
  <link rel="stylesheet" href="/assets/css/meanmenu.css">
  <link rel="stylesheet" href="/assets/css/odometer.min.css">
  <link rel="stylesheet" href="/assets/css/magnific-popup.css">
  <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css" />
  <!-- slick css -->
  <link rel="stylesheet" href="/assets/css/slick.css">
  <!-- slick-theme css -->
  <link rel="stylesheet" href="/assets/css/slick-theme.css">
  <link rel="stylesheet" href="/assets/css/main.css">

</head>

<body>

  <!-- Preloader Area Start -->
  <!-- <div class="preloader">
    <svg viewBox="0 0 1000 1000" preserveAspectRatio="none">
        <path id="preloaderSvg" d="M0,1005S175,995,500,995s500,5,500,5V0H0Z"></path>
    </svg>

    <div class="preloader-heading">
        <div class="load-text">
          <span>L</span>
          <span>o</span>
          <span>a</span>
          <span>d</span>
          <span>i</span>
          <span>n</span>
          <span>g</span>
        </div>
    </div>
  </div> -->
  <div class="preloader">
    <img src="/assets/images/spark/sparkmindscoder-logo.png" alt="Spark Minds Logo" class="preloader-logo" />
  </div>
  <!-- Preloader Area End -->

  <!-- start: Offcanvas Area -->
  <div id="vw-overlay-bg" class="vw-overlay-canvas"></div>
  <div class="vw-offcanvas-area">
    <div class="vw-offcanvas-header d-flex align-items-center justify-content-between">
      <div class="offcanvas-icon">
        <a id="canva_close" href="#">
          <i class="fa-light fa-xmark"></i>
        </a>
      </div>
    </div>
    <!-- Canvas Mobile Menu start -->
    <nav class="right_menu_togle mobile-navbar-menu" id="mobile-navbar-menu"></nav>

    <div class="canvas-content-area d-none d-lg-block">
      <div class="contact-info-list">
        <p class="des">
          We take a bottom-line approach to each project. Our clients consistently, enhanced brand loyalty
          and new leads thanks to our work.
        </p>
        <div class="canvas-title">
          <h4 class="title">Contact info</h4>
        </div>
        <div class="footer-contact">
          <ul>
            <li><i class="flaticon-location"></i> 1/3A-62 Parekh Niwas, Gazdar Street ,<br> Chira Bazar, Kalbadevi ,
              Mumbai - 400002</li>


            <li><a href="tel:+91 79777 91583">+91 79777 91583</a></li>
            <li><a href="tel:+91 87792 39431">+91 87792 39431</a></li>
            <li><a href="mailto:sparkmindscoders@gmail.com">sparkmindscoders@gmail.com</a></li>

          </ul>
        </div>
      </div>
      <div class="offcanvas-share">
        <div class="canvas-title">
          <h4 class="title">Social Icons</h4>
        </div>
        <ul>
              <li><a href="www.linkedin.com/in/sparkmindscoders-web-developers-a4a52732b" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
              <li><a href="https://wa.me/917977791583" target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
              <li><a href="https://www.instagram.com/sparkmindscoders?igsh=Z2JxM2VqaXpka3lp" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
              <li><a href="javascript:void(0)" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
            </ul>
      </div>
      <div class="contact-map">
        
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3773.603485809877!2d72.82055496975708!3d18.948937216700553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7ce18d924e25d%3A0x7c946d7f2d03b15c!2sParekh%20Niwas%2C%20Jagannath%20Shankar%20Seth%20Rd%2C%20Tad%20Wadi%2C%20Marine%20Lines%2C%20Mumbai%2C%20Maharashtra%20400002!5e0!3m2!1sen!2sin!4v1739242570167!5m2!1sen!2sin"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                            </div>

      </div>
    </div>
  </div>
  <!-- end: Offcanvas Area -->

  <div class="mainmenu d-none">
  <nav id="main-menu">
      <ul class="list-none">


        <li><a href="/">Home</a></li>
        <li><a href="about-us">About</a></li>
        <li class="has-dropdown current-menu-item">
          <a href="/">Services</a>
          <ul class="sub-menu">
            <li class="current-menu-item">
              <a href="website-development">Website Development</a>
            </li>
            <li><a href="graphic-design.html">Graphic Designs</a></li>
            <!-- <li><a href="digital-marketing.html">Digital Marketing</a></li> -->
            <li><a href="seo">Seo</a></li>
          </ul>
        </li>
        <li><a href="portfolio">Portfolio</a></li>
        <li><a href="blog">Blog</a></li>
        <li><a href="contact-us">Contact</a></li>
      </ul>
    </nav>
  </div>

  <div class="smooth-scrool-animate" id="smooth-animate"></div>
  <div id="smooth-page-wrapper">
    <div id="smooth-page-content">
      <main id="primary" class="site-main">

        <!--header-area-start-->
        <?php include("navbar.php") ?>
        <!--header-area-end-->

        <!--page-banner-area start-->
        <div class="page-banner-area" data-bg-image="assets/images/banner/blog.jpg">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="page-banner-title">
                  <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li>Blog </li>
                  </ul>
                  <h2 class="page-banner-heading">Blog </h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--page-banner-area end-->
        <!--blog-area start-->
        <section class="blog-page-area see__pad">
          <div class="container">
            <div class="row">
              <div class="col col-lg-8 col-md-12 col-12">
                <div class="blog-page-left">
                  <?php foreach ($posts as $item): ?>
                    <div class="blog-item">
                      <div class="blog-img">
                        <img class="imageParallax" src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>">
                      </div>
                      <div class="blog-content">
                        <ul>
                          <?php
                          // Convert the given date to a timestamp
                          $timestamp = strtotime($item['created_at']);

                          // Format the timestamp in a dynamic format
                          $dynamic_format = date("M d, Y", $timestamp);
                          ?>
                          <!-- <li> January - 06th 2024</li> -->
                          <li> <?= $dynamic_format ?></li>
                        </ul>
                        <h2><a href="/blog/details/<?= $item['slug'] ?>"><?= $item['title'] ?></a></h2>
                        <p>I have been a loyal customer of this auto parts company for years and I cannot recommend .</p>
                        <a href="/blog/details/<?= $item['slug'] ?>" class="vw-btn-primary"><i
                            class="icon-arrow-right"></i> Learn More</a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <nav aria-label="Page navigation" class="project-pagination d-block">
                    <ul class="text-center bloga">
                      <!-- Determine the base URL for pagination links -->
                      <?php
                      // blogs
                      if (isset($uri_parts[1]) && $uri_parts[1] == 'blog' && count($uri_parts) == 2) {
                        $baseUrl = "blog/page";
                      }
                      if (isset($uri_parts[2]) && $uri_parts[2] == 'page' && count($uri_parts) == 4) {
                        $baseUrl = "blog/page";
                      }

                      // categories
                      if (isset($uri_parts[2]) && $uri_parts[2] == 'categories' && count($uri_parts) == 4) {
                        $baseUrl = "blog/categories/" . $uri_parts[3] . "/page";
                      }

                      if (isset($uri_parts[4]) && $uri_parts[4] == 'page' && count($uri_parts) == 6) {
                        $baseUrl = "blog/categories/" . $uri_parts[3] . "/page";
                      }

                      if (isset($uri_parts[2]) && $uri_parts[2] == 'search' && count($uri_parts) == 4) {
                        $baseUrl = "blog/search";
                      }
                      ?>

                      <!-- Previous page link -->
                      <?php if ($getpage > 1): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?= $baseUrl ?>/<?= $getpage - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                      <?php else: ?>
                        <li class="page-item disabled">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>

                      <!-- Page numbers -->
                      <?php
                      $adjacents = 2; // Number of adjacent pages to show around the current page
                      
                      if ($number_of_pages <= 1) {
                        // Do nothing, no pagination needed
                      } elseif ($number_of_pages <= 7) {
                        // Less than 7 total pages so show all pages
                        for ($page = 1; $page <= $number_of_pages; $page++) {
                          echo '<li class="page-item ' . ($page == $getpage ? 'active' : '') . '">';
                          echo '<a class="page-link" href="' . $baseUrl . '/' . $page . '">' . $page . '</a>';
                          echo '</li>';
                        }
                      } else {
                        // More than 7 total pages, show some pages
                        if ($getpage <= 4) {
                          // Close to the beginning; only hide later pages
                          for ($page = 1; $page < 5 + $adjacents; $page++) {
                            echo '<li class="page-item ' . ($page == $getpage ? 'active' : '') . '">';
                            echo '<a class="page-link" href="' . $baseUrl . '/' . $page . '">' . $page . '</a>';
                            echo '</li>';
                          }
                          echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
                          echo '<li class="page-item"><a class="page-link" href="' . $baseUrl . '/' . $number_of_pages . '">' . $number_of_pages . '</a></li>';
                        } elseif ($getpage > $number_of_pages - 4) {
                          // Close to the end; only hide early pages
                          echo '<li class="page-item"><a class="page-link" href="' . $baseUrl . '/1">1</a></li>';
                          echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
                          for ($page = $number_of_pages - (4 + $adjacents); $page <= $number_of_pages; $page++) {
                            echo '<li class="page-item ' . ($page == $getpage ? 'active' : '') . '">';
                            echo '<a class="page-link" href="' . $baseUrl . '/' . $page . '">' . $page . '</a>';
                            echo '</li>';
                          }
                        } else {
                          // In the middle; hide some front and some back
                          echo '<li class="page-item"><a class="page-link" href="' . $baseUrl . '/1">1</a></li>';
                          echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
                          for ($page = $getpage - $adjacents; $page <= $getpage + $adjacents; $page++) {
                            echo '<li class="page-item ' . ($page == $getpage ? 'active' : '') . '">';
                            echo '<a class="page-link" href="' . $baseUrl . '/' . $page . '">' . $page . '</a>';
                            echo '</li>';
                          }
                          echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
                          echo '<li class="page-item"><a class="page-link" href="' . $baseUrl . '/' . $number_of_pages . '">' . $number_of_pages . '</a></li>';
                        }
                      }
                      ?>

                      <!-- Next page link -->
                      <?php if ($getpage < $number_of_pages): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?= $baseUrl ?>/<?= $getpage + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      <?php else: ?>
                        <li class="page-item disabled">
                          <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
              </div>
              <div class="col-lg-4 col-md-8 col-12">
                <div class="blog-sidebar">
                  <div class="search-widget widget">
                    <h3>Search</h3>
                    <form id="blogs_search_submit">
                      <div>
                        <input type="text" id="blogs_search" class="form-control" placeholder="Keyword...">
                        <button type="submit"><i class="far fa-search"></i></button>
                      </div>
                    </form>
                  </div>
                  <div class="recent-post widget">
                    <h3>Latest News</h3>
                    <?php $limitedPosts = array_slice($lates_posts, 0, 3); ?>
                    <?php foreach ($limitedPosts as $item): ?>
                      <div class="post">
                        <div class="post-img">
                          <img src="<?= $item['image'] ?>" alt="sparkmindscoders">
                        </div>
                        <div class="post-content">
                          <h4><a href="/blog/details/<?= $item['slug'] ?>"><?= $item['title'] ?></a></h4>
                          <ul>
                            <?php
                            // Convert the given date to a timestamp
                            $timestamp = strtotime($item['created_at']);

                            // Format the timestamp in a dynamic format
                            $dynamic_format = date("M d, Y", $timestamp);
                            ?>
                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $dynamic_format ?></li>
                          </ul>
                        </div>
                      </div>

                    <?php endforeach; ?>
                  </div>
                  <div class="category-widget widget">
                    <h3>Category</h3>
                    <ul>
                      <?php foreach ($categories as $item): ?>
                        <li><a href="/blog/categories/<?= $item['slug'] ?>"><i class="fal fa-arrow-right"></i>
                            <span><?= $item['name'] ?></span> </a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                  <div class="tag-widget widget">
                    <h3>Tags</h3>
                    <ul>
                      <?php $uniqueTags = array_unique(array_column($tags, 'name')); ?>
                      <?php $limitedTags = array_slice($uniqueTags, 0, 3); ?>
                      <?php foreach ($limitedTags as $item): ?>
                        <li><a href="javascript:void(0)"><?= $item ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--blog-area end-->




      </main>
      <!--footer start-->
      <?php include("footer.php") ?>
      <!--footer-end-->
    </div>
  </div>
  <?php include("stickybtn.php") ?>

  <!--================================
      CURSOR START
  =================================-->
  <div id="magic-cursor">
    <div id="ball"></div>
  </div>
  <!--================================
      CURSOR END
  =================================-->

  <!-- JS here -->
  <script src="/assets/js/jquery-3.7.1.min.js"></script>
  <script src="/assets/js/jquery-migrate-3.5.0.min.js"></script>
  <script src="/assets/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/appear.min.js"></script>
  <script src="/assets/js/wow.min.js"></script>
  <script src="/assets/js/meanmenu.js"></script>
  <script src="/assets/js/lenis.min.js"></script>

  <script src="/assets/js/odometer.min.js"></script>
  <script src="/assets/js/jquery.magnific-popup.min.js"></script>
  <!---slick-js-->
  <script src="/assets/js/slick.min.js"></script>
  <script src="/assets/js/swiper-bundle.min.js"></script>
  <script src="/assets/js/plugins.js"></script>
  <script src="/assets/js/main.js"></script>
  <script>
      $(document).ready(function () {
    var e;
    $("#blogs_search_submit").on("submit", function (t) {
      t.preventDefault(), clearTimeout(e);
      var a = $("#blogs_search").val().toLowerCase();
      e = setTimeout(function () {
        $.ajax({
          url: "blog/search",
          type: "GET",
          data: { search: a },
          success: function () {
            window.location.href = "blog/search/" + a;
          },
          error: function (e, t, a) {
            console.error(e.responseText);
          },
        });
      }, 2e3);
    });
  });
  </script>
</body>


</html>