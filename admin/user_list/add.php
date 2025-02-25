<?php include("layout/header.php"); ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <ul class="breadcrumb p-l-0 p-b-0">
                        <li class="breadcrumb-item"><a href="/"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/users">Users</a></li>
                        <li class="breadcrumb-item active">New User</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div class="input-group m-b-0">
                        <button class="btn btn-default" type="button" onclick="logAndNavigate(event, '/admin/users','Add USER Back Button Click View Users Page');">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form id="user_add_form">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">Full Name:</label>
                                        <input type="text" id="full_name" class="form-control" placeholder="Enter Full Name" name="name" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" class="form-control" placeholder="Enter Email" name="email" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" class="form-control password-wrapper" placeholder="Enter Password" name="password" required />
                                        <span id="passwordToggle_password" class="password-toggle" onclick="togglePasswordVisibility('password')"><i class="fas fa-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password:</label>
                                        <input type="password" id="confirmation" name="password_confirmation" class="form-control password-wrapper" placeholder="Enter Confirm Password" required />
                                        <span id="passwordToggle_confirmation" class="password-toggle" onclick="togglePasswordVisibility('confirmation')"><i class="fas fa-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="role_id">User Type:</label>
                                        <select id="role_id" class="form-control show-tick" name="role_id" required>
                                            <option disabled selected>Select User Type --</option>
                                            <option value="1">Admin</option>
                                            <option value="2">SEO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Published / Draft</label>
                                        <select class="form-control show-tick" name="published">
                                            <option disabled selected>Select Published / Draft --</option>
                                            <option value="1">Published</option>
                                            <option value="0">Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div>

                                <input type="hidden" name="assign_roles_name" value="<?php echo $_SESSION['name']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <button class="btn btn-primary p-2" type="submit">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function togglePasswordVisibility(inputId) {
        var passwordInput = document.getElementById(inputId);
        var passwordToggle = document.getElementById("passwordToggle_" + inputId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggle.innerHTML = '<i class="fas fa-eye"></i>';
        } else {
            passwordInput.type = "password";
            passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
        }
    }
</script>

<?php include("layout/footer.php"); ?>