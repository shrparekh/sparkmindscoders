<div id="leftsidebar" class="sidebar mainNav">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info m-b-20">
                    <div class="image">
                        <a href="javascript:void(0)"><img src="https://assets.about.me/background/users/i/e/r/ierix_1688122275_121.jpg" alt="User"></a>
                    </div>
                    <div class="detail">
                        <h6><?= $_SESSION["name"] ?> </h6>
                        <p class="m-b-0"><?= $_SESSION["email"] ?></p>
                        <a href="https://www.facebook.com/ierixxinfotech" target="_blank" title="facebook" class=" waves-effect waves-block"><i class="zmdi zmdi-facebook-box"></i></a>
                        <a href="https://www.linkedin.com/company/ierix-infotech-pvt-ltd/" target="_blank" title="linkedin" class=" waves-effect waves-block"><i class="zmdi zmdi-linkedin-box"></i></a>
                        <a href="https://www.instagram.com/ierix_infotech_/" title="instagram" class=" waves-effect waves-block"><i class="zmdi zmdi-instagram"></i></a>
                        <a href="https://x.com/ierix_infotech" target="_blank" title="twitter" class=" waves-effect waves-block"><i class="zmdi zmdi-twitter-box"></i></a>
                        <a href="https://www.youtube.com/@ierixinfotech" target="_blank" title="youtube" class=" waves-effect waves-block"><i class="zmdi zmdi-youtube-play"></i></a>
                    </div>
                </div>
            </li>
            <li id="dashboard-menu-item" class="<?= $CURRENT_URL == '/admin' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin','Dashboard View');">
                    <i class="zmdi zmdi-blogger"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="header">Blogs</li>
            <li class="<?= $CURRENT_URL == '/admin/post/categories' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/post/categories','Blogs Categories View');">
                    <i class="zmdi zmdi-sort-amount-desc"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/post/tags' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/post/tags','Blogs Tags View');">
                    <i class="zmdi zmdi-grid"></i>
                    <span>Tags</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/posts' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/posts','Blogs View');">
                    <i class="zmdi zmdi-grid"></i>
                    <span>Posts list</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/post/add' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/post/add','Add Blogs');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>New Post</span>
                </a>
            </li>

            <li class="header">Seo Optimisation</li>
            <li class="<?= $CURRENT_URL == '/admin/seo/technical' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/seo/technical','Seo Code Insert View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>Code Insert</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/seo/pages' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/seo/pages','Seo ON Pages View');">
                    <i class="zmdi zmdi-file-text"></i>
                    <span>ON Pages</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/seo/test' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/seo/test','Seo Meta Checker View');">
                    <i class="zmdi zmdi-file-text"></i>
                    <span>Meta Checker</span>
                </a>
            </li>
            <li class="header">Leads</li>
            <li class="<?= $CURRENT_URL == '/admin/leads/contact' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/leads/contact','Leads Contact View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>Contact</span>
                </a>
            </li>
            <li class="header">Website Requirements</li>
            <li class="<?= $CURRENT_URL == '/admin/website/clients' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/website/clients','Clients View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/website/portfolio' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/website/portfolio','Portfolio View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>Portfolio</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/website/testimonial' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/website/testimonial','Testimonial View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <!-- Testimonial -> Google Review -> database -> show review -->
                    <span>Testimonial</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/website/related-searches' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/website/related-searches','Related Searches View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <!-- Testimonial -> Google Review -> database -> show review -->
                    <span>Related Searches</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/website/companies' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/website/companies','List of companies View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>List of companies</span>
                </a>
            </li>
            <li class="<?= $CURRENT_URL == '/admin/website/faq' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/website/faq','FAQ View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>FAQ</span>
                </a>
            </li>
            <li class="header">Users List</li>
            <li class="<?= $CURRENT_URL == '/admin/users' ? 'active open' : ''; ?>">
                <a href="javascript:void(0)" onclick="logAndNavigate(event, '/admin/users','Users View');">
                    <i class="zmdi zmdi-plus-circle"></i>
                    <span>Users</span>
                </a>
            </li>
        </ul>
    </div>
</div>