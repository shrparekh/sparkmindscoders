<?php include("layout/header.php"); ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <!-- <h2>Seo Pages</h2> -->
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Website Requirements</a></li>
                        <li class="breadcrumb-item active">Portfolio</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/website/portfolio/add','ADD PORTFOLIO Button Click');">ADD PORTFOLIO</button>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable" id="portfolioTable">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Upload Time</th>
                                            <th> Name</th>
                                            <th>Image</th>
                                            <th>Image Alt</th>
                                            <th>Published</th>
                                            <th>Added by</th>
                                            <th>Changing Time</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Upload Time</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Image Alt</th>
                                            <th>Published</th>
                                            <th>Added by</th>
                                            <th>Changing Time</th>
                                            <th>Manage</th>

                                        </tr>
                                    </tfoot>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>
<?php include("layout/footer.php"); ?>