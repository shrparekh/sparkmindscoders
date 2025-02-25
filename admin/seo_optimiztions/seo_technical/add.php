<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <!-- <h2>New Post</h2> -->
                    <ul class="breadcrumb p-l-0 p-b-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="blog-dashboard.html">Seo Technical</a></li>
                        <li class="breadcrumb-item active">New Technical</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/seo/technical','Add Seo Code Insert Back Button Click View clients Page');">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form id="seo_technical_add">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""> Technical Name :</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Technical Name" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for=""> Technical Type</label>
                                    <select class="form-control show-tick" name="type">
                                        <option disabled selected>Select Type --</option>
                                        <option value="meta">Header</option>
                                        <option value="javascript">Footer</option>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                <label for="">Published / Draft</label>
                                    <select class="form-control show-tick" name="published">
                                        <option disabled selected>Select Published / Draft --</option>
                                        <option value="1">Published</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""> Technical code:</label>
                                        <textarea name="message" class="form-control" placeholder="Enter Technical Code"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <input type="hidden" id="user" name="user_id" value="<?php echo $_SESSION["user_id"] ?>">
                                <button class="btn btn-primary p-2"> Add</button>
                                
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>


<?php include("layout/footer.php"); ?>