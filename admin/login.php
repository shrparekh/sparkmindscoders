<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title> IERIX INFOTECH || Sign In</title>
    <!-- Favicon-->
    <link rel="icon" href="assets/images/ierix-infotech-digitalmarketing-company-and-agency-in-thane-mumbai-navi-mumbai.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/c80ce35b53.js" crossorigin="anonymous" defer></script>
    <!-- Custom Css -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/color_skins.css">
</head>

<body class="theme-black">
    <div class="authentication">
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="company_detail">
                            <h4 class="logo"><img src="assets/images/LOGO/ierix-infotech-digitalmarketing-company-and-agency-in-thane-mumbai-navi-mumbai.png" alt="ierix-infotech"></h4>
                            <h3>The ultimate <strong>Bootstrap 4</strong> Admin Dashboard</h3>
                            <p>Alpino is fully based on HTML5 + CSS3 Standards. Is fully responsive and clean on every device and every browser</p>
                            <div class="footer">
                                <ul class="social_link list-unstyled">
                                    <li><a href="https://www.facebook.com/ierixxinfotech" target="_blank"><i class="fab fa-facebook"></i></a></li>
                                    <li><a href="https://youtube.com/@ierixinfotech?si=N49a4U21hkHfynAj" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="https://www.instagram.com/ierix_infotech_/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    <li> <a href="https://www.linkedin.com/company/ierix-infotech-pvt-ltd/" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
                                    <li> <a href="https://twitter.com/ierix_infotech" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                
                                </ul>
                                <hr>
                                <ul>
                                    <li><a href="https://ierixinfotech.com/contact-us" target="_blank">Contact Us</a></li>
                                    <li><a href="https://ierixinfotech.com/about-us" target="_blank">About Us</a></li>
                                    <li><a href="https://ierixinfotech.com/services" target="_blank">Services</a></li>
                                    <li><a href="https://ierixinfotech.com/faq">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 offset-lg-1">
                        <div class="card-plain">
                            <div class="header">
                                <h5>Log in</h5>
                            </div>
                            <form class="form" action="service/login.php" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Email Id" name="email">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="password" id="password" class="form-control" placeholder="Password" name="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword"><i class="zmdi zmdi-eye-off"></i></span>
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
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
    <script>
        document.getElementById("togglePassword").addEventListener('click',function(e){
            const password =document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : "password";
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
        icon.classList.toggle('zmdi-eye-off');
        icon.classList.toggle('zmdi-eye');
        })
    </script>
</body>


</html>