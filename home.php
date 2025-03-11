<?php
include 'admin/database/config.php';

function getPosts($conn)
{
    $query = "SELECT 
    posts.id, posts.title, posts.slug, posts.content, posts.image, posts.comment_status, posts.views, 
    posts.category_id, categories.name AS category_name, categories.slug AS category_slug, posts.user_id, 
    posts.created_at, posts.updated_at
FROM 
    posts
JOIN 
    categories ON posts.category_id = categories.id
ORDER BY
    posts.created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$posts = getPosts($conn);
?>
<!doctype html>
<html class="no-js" lang="en">



<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Site Title -->
  <title>SparkMindsCoders | From Web Development to SEO – We’ve Got You Covered</title>
  <meta name="description"
    content="SparkMindCoder specializes in website development, including e-commerce, CMS, CRM, static, and dynamic websites. We also offer professional graphic design and SEO services to elevate your business.">
  <meta name="keywords"
    content="website development, e-commerce websites, CMS development, CRM solutions, graphic design, SEO services, dynamic websites, static websites, digital marketing solutions">
  <meta name="author" content="SparkMindsCoders">
  <!-- Place favicon.ico in the root directory -->
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/spark/sparkmindscoder-mainlogo.png">

  <!-- CSS here -->
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome-pro.min.css">
  <link rel="stylesheet" href="assets/css/flaticon_garvina.css">
  <link rel="stylesheet" href="assets/css/icomoon.css">
  <link rel="stylesheet" href="assets/css/meanmenu.css">
  <link rel="stylesheet" href="assets/css/odometer.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css" />
  <!-- slick css -->
  <link rel="stylesheet" href="assets/css/slick.css">
  <!-- slick-theme css -->
  <link rel="stylesheet" href="assets/css/slick-theme.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-1BBPSMRJ80"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-1BBPSMRJ80');
  </script>
</head>

<body>

  <!-- Preloader Area Start -->
  <!-- <div class="preloader">
    <svg viewBox="0 0 1000 1000" preserveAspectRatio="none">
      <path id="preloaderSvg" d="M0,1005S175,995,500,995s500,5,500,5V0H0Z"></path>
    </svg>

    <div class="preloader-heading">
      <div class="load-text">
        <span>S</span>
        <span>P</span>
        <span>A</span>
        <span>R</span>
        <span>K</span>
        <span>M</span>
        <span>I</span>
        <span>N</span>
        <span>D</span>
        <span>S</span>
      </div>
    </div>
  </div> -->
  <div class="preloader">
    <img src="assets/images/spark/sparkmindscoder-logo.png" alt="sparkmindscoders" class="preloader-logo" />
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
          <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
        </ul>
      </div>
      <div class="contact-map">
        <iframe src="https://maps.google.com/maps?q=manhatan&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
          style="border: 0" allowfullscreen=""></iframe>
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

        <div class="banner-area banner-area-3" id="hero">
          <div class="container-fluid">
            <div class="row align-items-center justify-content-end">
              <div class="col-xl-12">
                <div class="banner-img">
                  <img src="assets/images/spark/banner-3.webp" alt="sparkmindscoders">
                </div>
                <div class="banner-3-text">
                  <h6 class="banner-title" id="bannerTitle">Innovative Solutions</h6>
                  <h2 class="banner-sub-title" id="bannerSubtitle">Creative <span>Ideas</span></h2>
                  <div class="banner-paragraph">
                    <div class="banner-paragraph-border-top">
                      <img src="assets/images/banner/horizontal-line-3.svg" alt="sparkmindscoders">
                    </div>
                    <p id="bannerParagraph">We craft unique and creative solutions for every challenge. </br> Explore
                      our innovative approaches to modern design.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--banner-area-3-->


        <!--about-area-start-->
        <div class="about-area about-area-2" id="about">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="about-top-2">
                  <div class="horizontal-space-text-heading marquee">
                    <h6 class="horizontal-space-title">Smart &</h6>
                    <h6 class="horizontal-space-title"><span>flexible</span></h6>
                    <h6 class="horizontal-space-title">Smart &</h6>
                    <h6 class="horizontal-space-title"><span>flexible</span></h6>
                    <h6 class="horizontal-space-title">Smart & </h6>
                    <h6 class="horizontal-space-title"><span>flexible</span></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container pb-120">
            <div class="row">
              <div class="col-12">
                <div class="about-bottom about-bottom-2">
                  <div class="about-left-block">
                    <div class="about-balloon-img">
                      <img src="assets/images/web/about uss.jpeg" alt="sparkmindscoders">
                    </div>
                  </div>
                  <div class="about-text-block-2">
                    <div class="section-title section-title-about-2">
                      <h5 class="section-subtitle"><span>About Company</span> <img
                          src="assets/images/about/subtitle-line.svg" alt="sparkmindscoders"></h5>
                      <h1 class="section-heading">Welcome! We are <br /> <span>sparkmindscoders</span></h1>
                      <div class="section-title-text">
                        <h4 class="secondery-heading">From Vision to Reality</h4>
                        <p>Spark Minds Coders specializes in website development, graphic design, SEO, and digital
                          marketing to help businesses succeed online. We create responsive websites, eye-catching
                          designs, and data-driven strategies that enhance visibility and engagement. With a
                          client-focused approach, we deliver tailored solutions that drive traffic, boost conversions,
                          and empower your digital growth.</p>
                      </div>
                      <div class="achievement-section">

                        <a href="about-us" class="vw-btn-primary about-text-block-btn"><i
                            class="icon-arrow-right"></i>Discover More</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--about-area-end-->






        <!--service-area start-->
        <div class="service-area pb-90" id="service">
          <div class="container pb-90">
            <div class="row">
              <div class="col-12">
                <div class="about-titles service-section-title">
                  <h5 class="about-subtitle"><span>Services</span> <img src="assets/images/about/subtitle-line.svg"
                      alt="sparkmindscoders"></h5>
                  <h3 class="about-title">Let’s Check <span>Our <br /> Services</span></h3>
                  <span class="shadow-title">Services</span>
                </div>
                <div class="service-list">
                  <ul>
                    <li>
                      <a href="#"><span>01.</span>Website Development</a>
                      <div class="services-reel-image">
                        <img src="assets/images/web/web.jpeg" alt="sparkmindscoders">
                      </div>
                    </li>
                    <li>
                      <a href="#"><span>02.</span>Grapihc Designing </a>
                      <div class="services-reel-image">
                        <img src="assets/images/web/grahpic 1 resize.png" alt="sparkmindscoders">
                      </div>
                    </li>
                    <li>
                      <a href="#"><span>03.</span>Seo</a>
                      <div class="services-reel-image">
                        <img src="assets/images/web/seo.jpg" alt="sparkmindscoders">
                      </div>
                    </li>
                    <li>
                      <a href="#"><span>04.</span>Ui/ux DESIGN</a>
                      <div class="services-reel-image">
                        <img src="assets/images/web/uiux.jpg" alt="sparkmindscoders">
                      </div>
                    </li>
                  </ul>
                </div>

              </div>
            </div>

          </div>
        </div>
        <!--service-area end-->


        <!--big-heading start-->
        <div class="big-heading-area pb-55">
          <div class="big-heading-list">
            <h6 class="big-heading-stroke"><span class="stroke-heading">WHY</span> <img
                src="assets/images/web/Untitled_design__7_-removebg-preview.png" alt="sparkmindscoders"></h6>

            <h6 class="big-heading-stroke">DO<span class="stroke-heading">WE NEED</span> <img
                src="assets/images/web/Untitled_design__8_-removebg-preview.png" alt="sparkmindscoders"></h6>

            <h6 class="big-heading-stroke">WEBSITE <span class="thin-heading"> </span></h6>
          </div>
        </div>
        <!--big-heading end-->


        <!--clients-area start-->
        <div class="clients-area " id="choose">
          <div class="container p_relative pb-55 pt-20">
            <div class="row">
              <div class="col-12">
                <div class="clients-inner">
                  <div class="section-title section-title-client">
                    <h5 class="section-subtitle"><span>What Makes Us Your Perfect Partner</span> <img
                        src="assets/images/about/subtitle-line.svg" alt="sparkmindscoders"></h5>
                    <h3 class="section-heading">Seamless Solutions for Lasting Impact </h3>
                    <span class="shadow-title">Technologies</span>
                    <div class="section-title-para">
                      <p>Spark Minds Coders offers expert services in SEO, graphic design, CRM, CMS, and web
                        development. We deliver customized solutions that enhance your online presence, improve user
                        engagement, streamline business processes, and drive growth with proven, results-oriented
                        strategies.</p>
                    </div>
                    <a href="contact-us" class="vw-btn-primary section-title-btn"><i class="icon-arrow-right"></i>
                      Contact Us</a>
                  </div>
                  <div class="clients-list">
                    <div class="single-client">
                      <div class="single-client-inner">
                        <div class="single-client-block">
                          <div class="single-client-img">
                            <img src="assets/images/web/Expertise.png" alt="sparkmindscoders">
                          </div>
                          <div class="single-client-number">
                            <span>Expertise</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="single-client">
                      <div class="single-client-inner">
                        <div class="single-client-block">
                          <div class="single-client-img">
                            <img src="assets/images/web/innovation.png" alt="sparkmindscoders"
                              style="width: 50% !important; align-items: center !important;">
                          </div>
                          <div class="single-client-number">
                            <span>Innovation</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="single-client">
                      <div class="single-client-inner">
                        <div class="single-client-block">
                          <div class="single-client-img">
                            <img src="assets/images/web/growth.png" alt="sparkmindscoders">
                          </div>
                          <div class="single-client-number">
                            <span>Growth</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="single-client">
                      <div class="single-client-inner">
                        <div class="single-client-block">
                          <div class="single-client-img">
                            <img src="assets/images/web/Creativity.png" alt="sparkmindscoders">
                          </div>
                          <div class="single-client-number">
                            <span>Creativity</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="single-client">
                      <div class="single-client-inner">
                        <div class="single-client-block">
                          <div class="single-client-img">
                            <img src="assets/images/web/Performance.png" alt="sparkmindscoders">
                          </div>
                          <div class="single-client-number" style="left: 23% !important;">
                            <span>Performance</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--clients-area end-->



        <!--portfolios-area start-->
        <div class="portfolios-area portfolios-area-3 pt-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="section-title blog-section-title">
                  <h5 class="section-subtitle"><span>OUR WORKS</span> <img src="assets/images/about/subtitle-line.svg"
                      alt="sparkmindscoders"></h5>
                  <h3 class="section-heading">Our latest , <br /> <span>Website</span></h3>
                  <span class="shadow-title">Portfolio</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="single-portfolio">
                  <div class="single-portoflio-thumb imageParallax2">
                    <a href="https://emperia.co.in/">
                      <div class="overlay-container">
                        <img src="assets/images/spark/emperia-portfolio.png" alt="sparkmindscoders">
                        <div class="overlay"></div>
                      </div>
                    </a>
                  </div>

                  <div class="single-portfolio-desc">
                    <ul class="list-none portfolio-categories">
                      <li><a href="https://emperia.co.in/">Website</a></li>

                    </ul>
                    <h6 class="single-portfolio-title"><a href="https://emperia.co.in/">EMPERIA </a></h6>
                  </div>
                  <span class="portfolio-number">01</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="single-portfolio">




                  <div class="single-portoflio-thumb imageParallax2">
                    <a href="http://nmmg.in/">
                      <div class="overlay-container">
                        <img src="assets/images/spark/nmmg-portfolio.png" alt="sparkmindscoders">
                        <div class="overlay"></div>
                      </div>
                    </a>
                  </div>

                  <div class="single-portfolio-desc">
                    <ul class="list-none portfolio-categories">
                      <li><a href="http://nmmg.in/">website</a></li>

                    </ul>
                    <h6 class="single-portfolio-title"><a href="http://nmmg.in/">NAVI MUMBAI <br /> <span
                          class="thin-text">MERCHANT'S GYMKHANA</span></a></h6>
                  </div>
                  <span class="portfolio-number">03</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="single-portfolio">



                  <div class="single-portoflio-thumb imageParallax2">
                    <a href="https://emperiac2.co.in/">
                      <div class="overlay-container">
                        <img src="assets/images/spark/emperiac2-portfolio.png" alt="sparkmindscoders">
                        <div class="overlay"></div>
                      </div>
                    </a>
                  </div>
                  <div class="single-portfolio-desc">
                    <ul class="list-none portfolio-categories">
                      <li><a href="https://emperiac2.co.in/">Website</a></li>
                    </ul>
                    <h6 class="single-portfolio-title"><a href="https://emperiac2.co.in/">EMPERIA C2 <br /></a></h6>
                  </div>
                  <span class="portfolio-number">02</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="single-portfolio">



                  <div class="single-portoflio-thumb imageParallax2">
                    <a href="https://kcresst.com/">
                      <div class="overlay-container">
                        <img src="assets/images/spark/kcresst-portfolio.png" alt="sparkmindscoders">
                        <div class="overlay"></div>
                      </div>
                    </a>
                  </div>
                  <div class="single-portfolio-desc">
                    <ul class="list-none portfolio-categories">
                      <li><a href="https://kcresst.com/">Website</a></li>

                    </ul>
                    <h6 class="single-portfolio-title"><a href="https://kcresst.com/">KCRESST COMMUNICATION</a></h6>
                  </div>
                  <span class="portfolio-number">04</span>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-12">
              <div class="portfolio-more-btn">
                <a href="portfolio"><i class="icon-arrow-tera"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!--portfolios-area end-->






        <!--clients-area start-->
        <div class="clients-area client-area-2">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="section-title">
                  <h5 class="section-subtitle"><span>Our Clients</span> <img src="assets/images/about/subtitle-line.svg"
                      alt="sparkmindscoders"></h5>
                  <h4 class="section-heading">Collaboration With<br /> <span> Kcresst Communication</span></h4>
                  <span class="shadow-title">Partner</span>
                </div>
              </div>
            </div>
            <div class="row d-flex justify-content-between kcresst-content mt-5">
              <div class="col-lg-6">
                <p>With over 25 years of expertise in marketing and communication, we specialize in transforming ideas
                  into powerful brands. Our journey includes working with global giants like Siemens, Wokhardt, Signia,
                  Phonak, Cipla, and real estate leaders. We've crafted stories that resonate across industries, making
                  us a trusted partner for over 200+ projects in real estate in Residential, Commercial , Warhousing
                  and second homes.</p>

              </div>
              <div class="col-lg-6 kcresst-logo-container">
                <img src="assets/images/spark/kccrest-logo.png" alt="sparkmindscoders" class="kcresst-logo">
              </div>
            </div>
          </div>
        </div>
        <!--clients-area end-->
        <!--blog-area start-->
        <div class="blog-area">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-9">
                <div class="section-title blog-section-title">
                  <h6 class="section-subtitle"><span>Latest News</span> <img src="assets/images/about/subtitle-line.svg"
                      alt="sparkmindscoders"></h6>
                  <h6 class="section-heading">LATEST AND, <br /> <span>GREATEST POSTs</span></h6>
                  <span class="shadow-title">Latest News</span>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="blog-section-top-right">
                  <a href="/blog" class="vw-btn-primary"><i class="icon-arrow-right"></i> View All News</a>
                </div>
              </div>
            </div>
            <div class="row">
            <?php

$limitedPosts = array_slice($posts, 0, 3);
?>
<?php foreach ($limitedPosts as $item) : ?>
              <div class="col-lg-4">
                <div class="blog-card" data-bg-image="assets/images/blog/blog-thumb-1.jpg">
                  <div class="blog-card-inner">
                  <?php

$timestamp = strtotime($item['created_at']);


$dynamic_format = date("d M, Y", $timestamp);
?>
                    <!-- <span class="blog-card-date">January - 06th 2024</span> -->
                    <span class="blog-card-date"><?= $dynamic_format ?></span>
                    <h6 class="blog-card-title"><a href="/blog/details/<?= $item['slug'] ?>"><?= $item['title'] ?></a></h6>
                    <!-- <div class="blog-card-paragraph">
                      <p>I have been a loyal customer of this auto parts company for years and I cannot recommend .</p>
                    </div> -->
                    <a href="/blog/details/<?= $item['slug'] ?>" class="blog-card-readmore">Learn More</a>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <!--blog-area end-->


        <!--contact-area start-->
        <div class="contact-area imageParallax" data-bg-image="assets/images/contact/contact-bg.jpg">
          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <div class="contact-headings">
                  <h2 class="heading-contact">Ready To Get</h2>
                  <h6 class="subheading-contact">Focused In touch</h6>
                </div>
              </div>
              <div class="col-md-4">
                <div class="portfolio-more-btn contact-arrow-btn">
                  <a href="#"><i class="icon-arrow-tera"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--contact--area end-->

      </main>

      <!--footer start-->
      <?php include("footer.php") ?>
      <!--footer-end-->
    </div>
  </div>




  <!-- start: Scroll Area -->
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="
                      transition: stroke-dashoffset 10ms linear 0s;
                      stroke-dasharray: 307.919px, 307.919px;
                      stroke-dashoffset: 71.1186px;
                  "></path>
    </svg>
    <div class="scroll-top-icon">
      <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 24 24"
        data-icon="mdi:arrow-up" class="iconify iconify--mdi">
        <path fill="currentColor" d="M13 20h-2V8l-5.5 5.5l-1.42-1.42L12 4.16l7.92 7.92l-1.42 1.42L13 8v12Z">
        </path>
      </svg>
    </div>
  </div>
  <!-- end: Scroll Area -->

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
  <script src="assets/js/jquery-3.7.1.min.js"></script>
  <script src="assets/js/jquery-migrate-3.5.0.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/appear.min.js"></script>
  <script src="assets/js/wow.min.js"></script>
  <script src="assets/js/meanmenu.js"></script>
  <script src="assets/js/lenis.min.js"></script>

  <script src="assets/js/odometer.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <!---slick-js-->
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/main.js"></script>


  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const banners = [

        {
          title: "Innovative Solutions",
          subtitle: "Creative <span>Ideas</span>",
          paragraph: "We craft unique and creative solutions for every challenge. </br> Explore our innovative approaches to modern design.",
        },
        {
          title: "Your Trusted Partner",
          subtitle: "Building <span>Dreams</span>",
          paragraph: "With years of experience, we bring your dreams to life with precision and passion. </br> Trust us for excellence.",
        },
      ];

      let currentBannerIndex = 0;

      function updateBanner() {
        const bannerTitle = document.getElementById("bannerTitle");
        const bannerSubtitle = document.getElementById("bannerSubtitle");
        const bannerParagraph = document.getElementById("bannerParagraph");

        const { title, subtitle, paragraph } = banners[currentBannerIndex];

        bannerTitle.textContent = title;
        bannerSubtitle.innerHTML = subtitle;
        bannerParagraph.innerHTML = paragraph;

        currentBannerIndex = (currentBannerIndex + 1) % banners.length;
      }

      // Change text every 0.3 seconds
      setInterval(updateBanner, 2000);
    });

  </script>


</body>



</html>