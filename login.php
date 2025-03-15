<?php
session_start();
if (isset($_SESSION["user_id"])) {

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $redirect = $protocol . $_SERVER['HTTP_HOST'] . "/admin";

    // Redirect to the login page
    header("Location: " . $redirect);
    exit;
}
?>
<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title> SparkMindsCoders || Sign In</title>
    <!-- Favicon-->
    <link rel="icon"
        href="assets/images/spark/sparkmindscoder-mainlogo.png"
        type="image/x-icon">
    <link rel="stylesheet" href="/admin/assets/plugins/bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/c80ce35b53.js" crossorigin="anonymous" defer></script>
    <!-- Custom Css -->
    <link rel="stylesheet" href="/admin/assets/css/main.css">
    <link rel="stylesheet" href="/admin/assets/css/color_skins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="theme-black">
    <div class="authentication">
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="company_detail">
                            <h4 class="logo"><img
                                    src="/assets/images/banner/Screenshot_2024-10-05_113516-removebg-preview.png"
                                    alt="sparkmindscoders"></h4>
                            <h3><strong>SparkMindsCoders:</strong> Elevating Brands, Amplifying Success</h3>
                            <p class="text-justify">Elevate your brand's online presence with our expert digital
                                marketing and web design solutions.Elevate your brand's online presence with our expert
                                digital marketing and web design solutions.</p>
                            <div class="footer">
                                <ul class="social_link list-unstyled">
                                    <li><a href="javascript:void(0)" target="_blank"><i
                                                class="fab fa-facebook"></i></a></li>
                                    
                                    <li><a href="https://www.instagram.com/sparkmindscoders?igsh=Z2JxM2VqaXpka3lp" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                    <li> <a href="www.linkedin.com/in/sparkmindscoders-web-developers-a4a52732b"
                                            target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
                                    <li> <a href="javascript:void(0)" target="_blank"><i
                                                class="fab fa-twitter"></i></a></li>

                                </ul>
                                <hr>
                                <ul>
                                    <li><a href="https://sparkmindscoders.com/contact-us" target="_blank">Contact Us</a>
                                    </li>
                                    <li><a href="https://sparkmindscoders.com/about-us" target="_blank">About Us</a></li>
                                    <li><a href="https://sparkmindscoders.com/portfolio" target="_blank">Portfolio</a></li>
                                    <li><a href="https://sparkmindscoders.com/website-development">Service</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 offset-lg-1">
                        <div class="card-plain">
                            <div class="header">
                                <h5>Log in</h5>
                            </div>
                            <form class="form" id="login_dashboard">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Email Id" name="email">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="password" id="password" class="form-control" placeholder="Password"
                                        name="password">
                                    <div class="input-group-append togglePassword">
                                        <span class="input-group-text" id="togglePassword"><i
                                                class="zmdi zmdi-lock"></i></span>
                                    </div>
                                </div>
                                <div class="footer">
                                    <button class="btn btn-primary btn-round btn-block">SIGN IN</button>
                                </div>
                            </form>
                            <!-- <a href="forgot-password.html" class="link">Forgot Password?</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery Core Js -->
    <script src="/admin/assets/bundles/libscripts.bundle.js"></script>
    <script src="/admin/assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/admin/assets/js/ajax/jquery.validate.min.js"></script>
    <!-- <script src="assets/js/ogency.js"></script> -->
    <script>
        document.getElementById("togglePassword").addEventListener('click', function (e) {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : "password";
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('zmdi-lock-open');
            icon.classList.toggle('zmdi-lock');
        });
        $("#login_dashboard").validate({
            // Specify validation rules for each input field
            rules: {
                email: {
                    required: true,
                    email: true // Add email validation
                },
                password: {
                    required: true,
                    minlength: 12 // Example: Minimum length for password
                },
            },
            // Specify error messages for each rule
            messages: {
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                password: {
                    required: "Please enter your password.",
                    minlength: "Your password must be at least {0} characters long." // Example: Customize minlength message
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                // Create FormData object
                var formData = new FormData($(form)[0]);
                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/login.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            window.location.href = response.message; // Redirect to success URL
                        } else {
                            toastr.error(response.message, 'Error'); // Show error message using Toastr
                        }
                    },
                    error: function (xhr, status, error) {
                        // Display error message if Ajax request fails
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    </script>
</body>

</html>