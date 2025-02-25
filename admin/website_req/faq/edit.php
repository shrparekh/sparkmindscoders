<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Website Requirements</a></li>
                        <li class="breadcrumb-item active">Edit Frequently Asked Questions</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/website/faq','Add Frequently Asked Questions Back Button Click View Frequently Asked Questions Page');">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form id="faq_edit">
                        <div class="body">
                            <div class="row clearfix">
                               
                                <div class="col-md-12 pt-2">
                                    <label for="">Frequently Asked Questions Tag</label>
                                    <select class="form-control z-index show-tick" name="page_url" data-live-search="true" >
                                        <option disabled selected>Select Tags --</option>
                                        <option value="website-development">Website Development</option>
                                        <option value="branding">Branding</option>
                                        <option value="seo">Seo</option>
                                        <option value="social-media-marketing">Social Media Marketing</option>
                                        <option value="graphic-designing-video-production">Graphic Designing</option>
                                        <option value="digital-marketing">Digital Marketing</option>
                                        <option value="performance-marketing-lead-generation">Performace Marketing</option>
                                        <option value="bulk-sms-marketing">Bulk Sms Marketing</option>
                                        <option value="bulk-whatsapp-marketing">Bulk Whatsapp Marketing</option>
                                        <option value="bulk-email-marketing">Bulk Email Marketing</option>
                                        <option value="content-writing">Content Writing</option>
                                        <option value="e-commerce">E-commerce</option>
                                        <option value="domain-web-hosting">Domain Web Hosting</option>
                                        <option value="web-mobile-app-development">Web Mobile App Development</option>
                                        <option value="affiliate-marketing">Affiliate Marketing</option>
                                        <option value="online-reputation-management-orm">Online Reputation Management Orm</option>
                                        <option value="domain-web-hosting">Domain Web Hosting</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Frequently Asked Questions:</label>
                                        <input type="text" class="form-control" placeholder="Enter Frequently Asked Questions Name" name="name" id="faq_name" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Frequently Asked Questions Content :</label>
                                        <!-- <textarea name="faq_content" class="form-control" placeholder="Enter Frequently Asked Questions Content"></textarea> -->
                                        <textarea name="faq_content" class="form-control" placeholder="Enter Frequently Asked Questions Content" id="summernote"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="">Published / Draft</label>
                                    <select class="form-control show-tick" name="published">
                                        <option disabled selected>Select Published / Draft --</option>
                                        <option value="1">Published</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                                
                                <div class="col-sm-6 d-flex align-items-end">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"] ?>">
                                    <button class="btn btn-primary p-2">Update FAQ</button>
                                </div>
                            </div>
                            

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>


<?php include("layout/footer.php"); ?>