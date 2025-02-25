<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Website Requirements</a></li>
                        <li class="breadcrumb-item active">Edit Related Searches</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/website/related-searches','Add Related Searches Back Button Click View Related Searches Page');">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form id="related_searches_edit">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Related Searches Name:</label>
                                        <input type="text" class="form-control" placeholder="Enter Related Searches Name" name="name" id="tag_name" />
                                    </div>
                                </div>
                                <div class="col-md-12 pt-2">
                                    <label for="">Related Searches Pages</label>
                                    <select class="form-control z-index show-tick" name="page_url[]" data-live-search="true" multiple>
                                        <option disabled selected>Select Pages --</option>
                                        <option value="/">Home</option>
                                        <option value="/about-us">About</option>
                                        <option value="/services">Services</option>
                                        <option value="/portfolio">portfolio</option>
                                        <option value="/clients">clients</option>
                                        <option value="/blogs">blogs</option>
                                        <option value="/contact-us">contact</option>
                                        <option value="/services/website-development">Website Development</option>
                                        <option value="/services/branding">Branding</option>
                                        <option value="/services/seo">Seo</option>
                                        <option value="/services/social-media-marketing">Social Media Marketing</option>
                                        <option value="/services/graphic-designing-video-production">Graphic Designing</option>
                                        <option value="/services/digital-marketing">Digital Marketing</option>
                                        <option value="/services/performance-marketing-lead-generation">Performace Marketing</option>
                                        <option value="/services/bulk-sms-marketing">Bulk Sms Marketing</option>
                                        <option value="/services/bulk-whatsapp-marketing">Bulk Whatsapp Marketing</option>
                                        <option value="/services/bulk-email-marketing">Bulk Email Marketing</option>
                                        <option value="/services/content-writing">Content Writing</option>
                                        <option value="/services/e-commerce">E-commerce</option>
                                        <option value="/services/domain-web-hosting">Domain Web Hosting</option>
                                        <option value="/services/web-mobile-app-development">Web Mobile App Development</option>
                                        <option value="/services/affiliate-marketing">Affiliate Marketing</option>
                                        <option value="/services/online-reputation-management-orm">Online Reputation Management Orm</option>
                                        <option value="/services/domain-web-hosting">Domain Web Hosting</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Related Searches Content :</label>
                                        <!-- <textarea name="tag_content" class="form-control" placeholder="Enter Related Searches Content"></textarea> -->
                                        <textarea name="tag_content" class="form-control" placeholder="Enter Related Searches Content" id="summernote"></textarea>
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
                                    <button class="btn btn-primary p-2">Update Related Searches</button>
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