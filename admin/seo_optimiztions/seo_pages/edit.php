<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <!-- <h2>New Post</h2> -->
                    <ul class="breadcrumb p-l-0 p-b-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="blog-dashboard.html">Seo Pages</a></li>
                        <li class="breadcrumb-item active">Edit Pages</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/seo/pages','Edit Seo ON Pages Back Button Click View clients Page');">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form id="seo_page_edit">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Page Url :</label>
                                        <input type="text" class="form-control" placeholder="Enter Page Url" name="page"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Meta Title :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Meta Title" name="title" id="metaTitle" />
                                        <div class="d-flex justify-content-between">
                                            <small id="metaTitleCount" class="form-text text-muted"></small>
                                            <small id="metaTitleMessage" class="form-text"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Meta Descriptions :</label>
                                        <input type="text" class="form-control" id="metaDescription" placeholder="Enter Blog Meta Descriptions" name="descriptions" />
                                        <div class="d-flex justify-content-between">
                                            <small id="metaDescriptionCount" class="form-text text-muted"></small>
                                            <small id="metaDescriptionMessage" class="form-text"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Meta Keywords :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Meta Keywords" name="keywords"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <label for="" class="px-2">Featured Image :</label>
                                        <div class="body">
                                            <div class="form-group">
                                                <input type="file" name="featured_image_url" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                                                <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                <label for="">Published / Draft</label>
                                    <select class="form-control show-tick" name="published">
                                        <option disabled selected>Select Published / Draft --</option>
                                        <option value="1">Published</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>

                            </div>

                            <div>
                                <input type="hidden" name="id" >
                                <input type="hidden"  name="Thumbnail_Image_available" >
                                <input type="hidden" id="user" name="user_id" value="<?php echo $_SESSION["user_id"] ?>">
                                <button class="btn btn-primary p-2"> Update</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    const metaTitleInput = document.getElementById('metaTitle');
    const messageElement = document.getElementById('metaTitleMessage');
    const countElement = document.getElementById('metaTitleCount');

    const metaDescriptionInput = document.getElementById('metaDescription');
    const metaDescriptionMessage = document.getElementById('metaDescriptionMessage');
    const metaDescriptionCount = document.getElementById('metaDescriptionCount');

    metaTitleInput.addEventListener('input', function() {
        const metaTitle = this.value;
        countElement.textContent = `Character count: ${metaTitle.length}`;
    });

    metaTitleInput.addEventListener('blur', function() {
        const metaTitle = this.value;

        if (metaTitle.length >= 50 && metaTitle.length <= 60) {
            messageElement.textContent = 'Meta title length is valid.';
            messageElement.style.color = 'green';
        } else {
            messageElement.textContent = 'Meta title length should be between 50 and 60 characters.';
            messageElement.style.color = 'red';
        }
    });

    metaDescriptionInput.addEventListener('input', function() {
        const metaDescription = this.value;
        metaDescriptionCount.textContent = `Character count: ${metaDescription.length}`;
    });

    metaDescriptionInput.addEventListener('blur', function() {
        const metaDescription = this.value;

        if (metaDescription.length >= 150 && metaDescription.length <= 160) {
            metaDescriptionMessage.textContent = 'Meta description length is valid.';
            metaDescriptionMessage.style.color = 'green';
        } else {
            metaDescriptionMessage.textContent = 'Meta description length should be between 150 and 160 characters.';
            metaDescriptionMessage.style.color = 'red';
        }
    });
</script>

<?php include("layout/footer.php"); ?>