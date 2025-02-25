<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <!-- <h2>New Post</h2> -->
                    <ul class="breadcrumb p-l-0 p-b-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="blog-dashboard.html">Blog</a></li>
                        <li class="breadcrumb-item active">New Post</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/posts','Add Posts Back Button Click View Posts Page');">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form id="posts_add">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Title :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Title" name="title" id="post_name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Slug :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Slug" name="slug" id="post_slug" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Meta Title :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Meta Title" name="meta_title" id="metaTitle" />
                                        <div class="d-flex justify-content-between">
                                            <small id="metaTitleCount" class="form-text text-muted"></small>
                                            <small id="metaTitleMessage" class="form-text"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Meta Descriptions :</label>
                                        <input type="text" class="form-control" id="metaDescription" placeholder="Enter Blog Meta Descriptions" name="meta_descriptions" />
                                        <div class="d-flex justify-content-between">
                                            <small id="metaDescriptionCount" class="form-text text-muted"></small>
                                            <small id="metaDescriptionMessage" class="form-text"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Meta Keywords :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Meta Keywords" name="meta_keyword" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Featured Image Alt Tag :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Featured Image Alt" name="featured_image_alt" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Image Alt Tag :</label>
                                        <input type="text" class="form-control" placeholder="Enter Blog Featured Image Alt" name="image_alt" />
                                    </div>
                                </div>
                                <div class="col-md-6 pt-3">
                                    <div class="card">
                                        <label for="exampleInputFile" class="px-2">Featured Image :</label>
                                        <div class="body">
                                            <div class="form-group">
                                                <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp" name="featured_image" onchange="previewImage(event, 'imagePreview', 'imageSize1', 'error1', true, 92, 92)">
                                                <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                                            </div>
                                            <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; display: none;">
                                            <p id="imageSize1" style="display: none;">Size: </p>
                                            <p id="error1" style="color: red; display: none;">Error: File size should be less than 10 KB and dimensions should be 92x92 pixels.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 pt-3">
                                    <div class="card">
                                        <label for="exampleInputFile2" class="px-2">Image :</label>
                                        <div class="body">
                                            <div class="form-group">
                                                <input type="file" name="image" class="form-control-file" id="exampleInputFile2" aria-describedby="fileHelp2" onchange="previewImage(event, 'img-preview', 'imageSize2', 'error2', true, 390, 290)">
                                                <small id="fileHelp2" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                                            </div>
                                            <img id="img-preview" src="#" alt="Preview" style="max-width: 100%; display: none;">
                                            <p id="imageSize2" style="display: none;">Size: </p>
                                            <p id="error2" style="color: red; display: none;">Error: File size should be less than 10 KB and dimensions should be 390x290 pixels.</p>
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
                                <div class="col-sm-6">
                                    <label for="post_category_dropdown">Category</label>
                                    <select id="post_category_dropdown" class="form-control z-index show-tick" name="category_id" data-live-search="true">
                                        <option>Select Category --</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="col-md-12 pt-2">
                                    <label for="post_tag_dropdown">Select Tags:</label>
                                    <select id="post_tag_dropdown" name="tag_id[]" class=" show-tick z-index form-control" data-live-search="true" multiple>
                                        <!-- Options will be dynamically populated -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h2> <strong>Content :</strong></h2>
                                    </div>
                                    <div class="body">
                                        <textarea name="content" id="summernote"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <input type="hidden" id="user" name="user_id" value="<?php echo $_SESSION["user_id"] ?>">
                                <button class="btn btn-primary p-2">Add Post</button>
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
<script>
    function previewImage(event, previewId, sizeId, errorId, checkDimensions, width, height) {
        var input = event.target;
        var preview = document.getElementById(previewId);
        var sizeDisplay = document.getElementById(sizeId);
        var errorDisplay = document.getElementById(errorId);

        if (input.files && input.files[0]) {
            var file = input.files[0];

            if (file.size > 10240) { // 10 KB in bytes
                errorDisplay.style.display = 'block';
                sizeDisplay.style.display = 'none';
                preview.style.display = 'none';
                return;
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;

                if (checkDimensions) {
                    var img = new Image();
                    img.onload = function() {
                        if (img.width === width && img.height === height) {
                            errorDisplay.style.display = 'none';
                            sizeDisplay.textContent = 'Size: ' + (file.size / 1024).toFixed(2) + ' KB';
                            sizeDisplay.style.display = 'block';
                            preview.style.display = 'block';
                        } else {
                            errorDisplay.style.display = 'block';
                            sizeDisplay.style.display = 'none';
                            preview.style.display = 'none';
                        }
                    }
                    img.src = e.target.result;
                } else {
                    errorDisplay.style.display = 'none';
                    sizeDisplay.textContent = 'Size: ' + (file.size / 1024).toFixed(2) + ' KB';
                    sizeDisplay.style.display = 'block';
                    preview.style.display = 'block';
                }
            }

            reader.readAsDataURL(file); // convert to base64 string
        } else {
            preview.src = '#';
            preview.style.display = 'none';
            sizeDisplay.style.display = 'none';
            errorDisplay.style.display = 'none';
        }
    }
</script>

<?php include("layout/footer.php"); ?>