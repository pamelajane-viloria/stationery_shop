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

        <script src="../assets/js/global/global.js"></script>
        <link rel="stylesheet" href="../assets/css/custom/global.css">
        <link rel="stylesheet" href="../assets/css/custom/signup.css">
        <script src="../assets/js/global/signup.js"></script>
    </head>
    <body>
<?php if($this->session->flashdata('input_errors')){ ?>
        <div class="error-alert rounded shadow">
            <span>There were errors with your submission</span>
            <?= $this->session->flashdata('input_errors'); ?>
        </div>
<?php } ?>
        <div class="wrapper">
            <?= form_open('Users/process_registration', 'class="signup_form"') ?>
                <img src="../assets/images/Stationery_studio.png" alt="stationery_shop">
                <h2>Signup to order.</h2>
                <ul>
                    <li>
                        <input type="text" name="first_name" class="validate" data-validation="empty minLength" data-min-length="2">
                        <label>First Name</label>
                        <span></span>
                    </li>
                    <li>
                        <input type="text" name="last_name" class="validate" data-validation="empty minLength" data-min-length="2">
                        <label>Last Name</label>
                        <span></span>
                    </li>
                    <li>
                        <input type="text" name="email" class="validate" data-validation="empty minLength" data-min-length="2">
                        <label>Email</label>
                        <span></span>
                    </li>
                    <li>
                        <input type="password" name="password" class="validate" data-validation="empty minLength" data-min-length="8">
                        <label>Password</label>
                        <span></span>
                    </li>
                    <li>
                        <input type="password" name="confirm_password" class="validate" data-validation="empty minLength" data-min-length="8">
                        <label>Confirm Password</label>
                        <span></span>
                    </li>
                </ul>
                <button class="signup_btn" type="submit">Signup</button>
                <input type="hidden" name="action" value="signup">
                <a href="/Users/login">Already a member? Login here.</a>
            <?= form_close(); ?>
        </div>
    </body>
</html>