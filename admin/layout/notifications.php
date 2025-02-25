<?php if (isset($_GET['successfully']) && $_GET['successfully'] == $_GET['successfully']) : ?>
    <div data-notify="container" class="bootstrap-notify-container alert alert-dismissible alert-success p-r-35 animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; top: 20px; left: 0px; right: 0px;">
        <span data-notify="icon"></span>
        <span data-notify="title"></span>
        <span data-notify="message"><?php echo $_GET['message'] ?></span>
    </div>
<?php endif ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 1) : ?>
    <div data-notify="container" class="bootstrap-notify-container alert alert-dismissible alert-danger p-r-35 animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; top: 20px; left: 0px; right: 0px;">
        <span data-notify="icon"></span>
        <span data-notify="title"></span>
        <span data-notify="message"><?php echo $_GET['message'] ?></span>
    </div>
<?php endif ?>
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == $_GET['deleted']) : ?>
    <div data-notify="container" class="bootstrap-notify-container alert alert-dismissible alert-danger p-r-35 animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; top: 20px; left: 0px; right: 0px;">
        <span data-notify="icon"></span>
        <span data-notify="title"></span>
        <span data-notify="message"><?php echo $_GET['message'] ?></span>
    </div>
<?php endif ?>