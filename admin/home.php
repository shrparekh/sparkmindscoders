<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <!-- <h2>Blog Dashboard</h2> -->
                    <ul class="breadcrumb p-l-0 p-b-0">
                        <li class="breadcrumb-item"><a href="/admin"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/admin/posts">Blog</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <p class="m-b-20"><img src="/admin/assets\images\blog\blog.png" alt="" class="img-icon"></p>
                        <span>Total Blog</span>
                        <h3 class="m-b-10">+<span class="number count-to" data-speed="2000" data-fresh-interval="700"></span></h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <p class="m-b-20"><img src="/admin/assets\images\blog\client.png" alt="" class="img-icon"></p>
                        <span>Total Clients</span>
                        <h3 class="m-b-10">+<span class="number count-to" data-speed="2000" data-fresh-interval="700"></span></h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <p class="m-b-20"><img src="/admin/assets\images\blog\testimony.png" alt="" class="img-icon"></p>
                        <span>Total Testimonial</span>
                        <h3 class="m-b-10">+<span class="number count-to" data-speed="2000" data-fresh-interval="700"></span></h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <p class="m-b-20"><img src="/admin/assets\images\blog\user.png" alt="" class="img-icon"></p>
                        <span>User</span>
                        <h3 class="m-b-10">+<span class="number count-to" data-speed="2000" data-fresh-interval="700"></span></h3>

                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2><strong>Recent</strong> Blog</h2>
                        <ul class="header-dropdown">
                            <li><button class="btn btn-primary" onclick="logAndNavigate(event, '/admin/posts','Blogs View');">View More</button></li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive social_media_table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SR.No</th>
                                        <th>Upload Time</th>
                                        <th>TITLE</th>
                                        <th>IMAGE</th>
                                        <th>CATEGORY</th>
                                        <th>ADDED BY</th>

                                    </tr>
                                </thead>
                                <tbody id="recentposts">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2><strong>Recent</strong> Contact</h2>
                        <ul class="header-dropdown">
                            <li><button class="btn btn-primary" onclick="logAndNavigate(event, '/admin/leads/contact','Leads Contact View');">View More</button></li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive social_media_table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SR.No</th>
                                        <th>Generate Time</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Message</th>

                                    </tr>
                                </thead>
                                <tbody id="recentContact">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("layout/footer.php"); ?>