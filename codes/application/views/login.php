<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Stationery</title>

    <link rel="shortcut icon" href="../assets/images/studio_stationery.ico" type="image/x-icon">

    <script src="../assets/js/vendor/jquery.min.js"></script>
    <script src="../assets/js/vendor/popper.min.js"></script>
    <script src="../assets/js/vendor/bootstrap.min.js"></script>
    <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

    <script src="../assets/js/global/dashboard.js"></script>
    <link rel="stylesheet" href="../assets/css/custom/global.css">
    <link rel="stylesheet" href="../assets/css/custom/signup.css">
    <script src="../assets/js/global/signup.js"></script>

</head>
<!-- <script>
    $(document).ready(function() {
        $("input[name=email]").focus();
        $("form").submit(function(event) {
            event.preventDefault();
            return false;
        });
        /* prototype add */
        $(".login_btn").click(function() {
            window.location.href = "catalogue.html";
        });
    });
</script> -->
<body>
<?php if($this->session->flashdata('validation_errors')){ ?>
        <div class="error-alert rounded shadow">
            <span>There were errors with your submission</span>
            <p><?= $this->session->flashdata('validation_errors'); ?><p>
        </div>
<?php } ?>
    <div class="wrapper">
        <?= form_open('Users/login_user', 'class="login_form"') ?>
            <img src="../assets/images/Stationery_studio.png" alt="stationery_shop">
            <h2>Login to order.</h2>
            <a href="/Users/register">New Member? Register here.</a>
            <ul>
                <li>
                    <input type="text" name="email" value="jdoe@gmail.com">
                    <label>Email</label>
                    <span></span>
                </li>
                <li>
                    <input type="password" name="password" value="123456789">
                    <label>Password</label>
                    <span></span>
                </li>
            </ul>
            <button type="submit" class="login_btn">Login</button>
            <input type="hidden" name="action" value="login">
        <?= form_close(); ?>
    </div>
</body>
</html>