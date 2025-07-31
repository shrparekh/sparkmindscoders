<?php
include 'admin/database/config.php';
function findPostBySlug($slug)
{
    global $conn;
    $sql = "SELECT posts.id, posts.title, posts.slug, posts.content, posts.image, posts.comment_status, posts.views, 
            posts.category_id, categories.name AS category_name,categories.slug AS category_slug, posts.user_id, users.name AS user_name, 
            posts.created_at, posts.updated_at
            FROM posts
            JOIN categories ON posts.category_id = categories.id
            JOIN users ON posts.user_id = users.id
            WHERE posts.slug = :post_slug";

    try {
        // Prepare and execute the SQL query with the given post ID as a parameter
        $rs_result = $conn->prepare($sql);
        $rs_result->execute(['post_slug' => $slug]);
        $row = $rs_result->fetch(PDO::FETCH_ASSOC);

        // If a post is found with the given ID, return it as an associative array
        if ($row) {
            return $row;
        } else {
            // If no post is found, return null
            return null;
        }
    } catch (Exception $e) {
        // In case of an exception or error, return null
        return null;
    }
}
function postsPaginations($page = 1, $perPage = 10)
{
    global $conn;

    // Calculate the offset based on the page number and number of posts per page
    $offset = ($page - 1) * $perPage;


    $sql = "SELECT 
        posts.id, posts.title, posts.slug, posts.content, posts.image, posts.comment_status, posts.views, 
        posts.category_id, categories.name AS category_name,categories.slug AS category_slug, posts.user_id, 
        posts.created_at, posts.updated_at
    FROM 
        posts
    JOIN 
        categories ON posts.category_id = categories.id
    LIMIT 
        :offset, :perPage";

    try {
        // Prepare and execute the SQL query with the given post ID and pagination parameters
        $rs_result = $conn->prepare($sql);
        $rs_result->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $rs_result->bindValue(':offset', $offset, PDO::PARAM_INT);
        $rs_result->execute();
        $rows = $rs_result->fetchAll(PDO::FETCH_ASSOC);

        // Return both the posts and the total number of pages
        return $rows;
    } catch (Exception $e) {
        // In case of an exception or error, return null
        return null;
    }
}
function Getcategories()
{
    global $conn;
    $sql = "SELECT * FROM categories";

    try {
        // Prepare and execute the SQL query with the given post ID as a parameter
        $rs_result = $conn->prepare($sql);
        $rs_result->execute();
        $row = $rs_result->fetchAll(PDO::FETCH_ASSOC);

        // If a post is found with the given ID, return it as an associative array
        if ($row) {
            return $row;
        } else {
            // If no post is found, return null
            return null;
        }
    } catch (Exception $e) {
        // In case of an exception or error, return null
        return null;
    }
}
function Gettags()
{
    global $conn;
    $sql = "SELECT * FROM tags";

    try {
        // Prepare and execute the SQL query with the given post ID as a parameter
        $rs_result = $conn->prepare($sql);
        $rs_result->execute();
        $row = $rs_result->fetchAll(PDO::FETCH_ASSOC);

        // If a post is found with the given ID, return it as an associative array
        if ($row) {
            return $row;
        } else {
            // If no post is found, return null
            return null;
        }
    } catch (Exception $e) {
        // In case of an exception or error, return null
        return null;
    }
}
function Getpost_tag($conn, $id)
{
    global $conn;
    $sql = "SELECT post_tag.*, posts.*, tags.*
            FROM post_tag
            JOIN posts ON post_tag.post_id = posts.id
            JOIN tags ON post_tag.tag_id = tags.id
            WHERE post_tag.post_id = :post_id";

    try {
        // Prepare and execute the SQL query with the given post ID as a parameter
        $stmt = $conn->prepare($sql);
        $stmt->execute(['post_id' => $id]);

        // Fetch the result one row at a time
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }

        // If results are found, return them
        if ($results) {
            return $results;
        } else {
            // If no results are found, return null
            return null;
        }
    } catch (Exception $e) {
        // In case of an exception or error, return null
        return null;
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


$url = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url);
$lastSegment = end($parts);

$postData = findPostBySlug($lastSegment, $conn);
$posts = postsPaginations(1, 5);

if (is_null($postData)) {
    $postData = [];
}



$categories = Getcategories($conn);
$tags = Gettags($conn);
$post_tag = Getpost_tag($conn, $postData['id']);



if (is_null($posts)) {
    $posts = [];
}

if (is_null($categories)) {
    $categories = [];
}

if (is_null($tags)) {
    $tags = [];
}
if (is_null($post_tag)) {
    $post_tag = [];
}


?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <!-- Site Title -->
    <title>sparkmindscoders: Expert Freelance Web Developer & Designer in Mumbai | CMS & CRM | Dynamic & E-commerce Solutions</title>

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/spark/sparkmindscoder-logo.png" style="width: 100px;">

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
                <div class="page-banner-area" data-bg-image="/assets/images/page-title/page-title-03.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-banner-title">
                                    <ul class="breadcrumbs">
                                        <li><a href="/">Home</a></li>
                                        <li>Blog Details</li>
                                    </ul>
                                    <h2 class="page-banner-heading">Blog Details</h2>
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
                                    <div class="blog-item">
                                        <div class="blog-img">
                                            <img class="imageParallax" src="<?= $postData['image'] ?>" alt="">
                                        </div>
                                        <div class="blog-content">
                                            <ul>
                                                <?php
                                                // Convert the given date to a timestamp
                                                $timestamp = strtotime($postData['created_at']);

                                                // Format the timestamp in a dynamic format
                                                $dynamic_format = date("M d, Y", $timestamp);
                                                ?>
                                                <!-- <li> January - 06th 2024</li> -->
                                                <li><?= $dynamic_format ?></li>
                                            </ul>
                                            <h2><a href="blog-single.html"><?php echo $postData['title'] ?></a></h2>
                                            <p><?php echo htmlspecialchars_decode($postData['content'], ENT_QUOTES | ENT_HTML5) ?>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="blog-tags">
                                        <ul class="tag__list">
                                            <?php foreach ($post_tag as $item): ?>
                                                <li><a href="#"><?= $item['name'] ?></a></li>
                                            <?php endforeach; ?>

                                        </ul>
                                        <ul class="share__list">
                                            <li>Share</li>
                                            <li><i class="fa fa-share-alt" aria-hidden="true"></i></li>
                                        </ul>
                                    </div>
                                    <!-- <div class="comments-area">
                                        <h4 class="title-1">2 Comments</h4>
                                        <div class="author-comments">
                                            <img src="/assets/images/blog/blog-author-4.png" alt="author">
                                            <div class="content">
                                                <div class="top">
                                                    <h5>Cameron Williamson</h5>
                                                    <a class="primary-btn-1 btn-hover" href="#">
                                                        Reply
                                                    </a>
                                                </div>
                                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui
                                                    blanditiis praesentium voluptatum deleniti atque corrupti quos
                                                    dolores et quas molestias excepturi sint occaecati cupiditate non
                                                    provident, similique sunt in culpa qui officia deserunt mollitia
                                                    animi.</p>
                                            </div>
                                        </div>
                                        <div class="author-comments">
                                            <img src="/assets/images/blog/blog-author-5.png" alt="author">
                                            <div class="content">
                                                <div class="top">
                                                    <h5>Cameron Williamson</h5>
                                                    <a class="primary-btn-1 btn-hover" href="#">
                                                        Reply
                                                    </a>
                                                </div>
                                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui
                                                    blanditiis praesentium voluptatum deleniti atque corrupti quos
                                                    dolores et quas molestias excepturi sint occaecati cupiditate non
                                                    provident, similique sunt in culpa qui officia deserunt mollitia
                                                    animi.</p>
                                            </div>
                                        </div>
                                        <h4 class="title-2">Leave a Comment</h4>
                                        <div class="commtent-form">
                                            <form>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="submit-form-input">
                                                            <input type="text" placeholder="Enter Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="submit-form-input">
                                                            <input type="email" placeholder="Enter Email*" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="submit-form-input">
                                                            <textarea name="message"
                                                                placeholder="Enter Message"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="btn-area pt-50 pl-10">
                                                            <button type="submit" class="vw-btn-primary"><i
                                                                    class="icon-arrow-right"></i>
                                                                Submit Comment
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-8 col-12">
                                <div class="blog-sidebar">
                                    <div class="search-widget widget">
                                        <h3>Search</h3>
                                        <form>
                                            <div>
                                                <input type="text" class="form-control" placeholder="Keyword...">
                                                <button type="submit"><i class="far fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="recent-post widget">
                                        <h3>Latest News</h3>


                                        <div class="post">

                                            <?php $limitedPosts = array_slice($lates_posts, 0, 3); ?>
                                            <?php foreach ($limitedPosts as $item): ?>
                                                <div class="post">
                                                    <div class="post-img">
                                                        <img src="<?= $item['image'] ?>" alt="sparkmindscoders">
                                                    </div>
                                                    <div class="post-content">
                                                        <h4><a
                                                                href="/blog/details/<?= $item['slug'] ?>"><?= $item['title'] ?></a>
                                                        </h4>
                                                        <ul>
                                                            <?php
                                                            // Convert the given date to a timestamp
                                                            $timestamp = strtotime($item['created_at']);

                                                            // Format the timestamp in a dynamic format
                                                            $dynamic_format = date("M d, Y", $timestamp);
                                                            ?>
                                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                <?= $dynamic_format ?></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                        </div>

                                    </div>
                                    <div class="category-widget widget">
                                        <h3>Category</h3>
                                        <ul>
                                            <?php foreach ($categories as $item): ?>
                                                <li><a href="/blog/categories/<?= $item['slug'] ?>"><i
                                                            class="fal fa-arrow-right"></i>
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