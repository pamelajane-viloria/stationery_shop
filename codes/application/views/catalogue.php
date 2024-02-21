<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="<?php echo $this->security->get_csrf_hash(); ?>">
        <title>Studio Stationery</title>

        <link rel="shortcut icon" href="../assets/images/studio_stationery.ico" type="image/x-icon">

        <script src="../assets/js/vendor/jquery.min.js"></script>
        <script src="../assets/js/vendor/popper.min.js"></script>
        <script src="../assets/js/vendor/bootstrap.min.js"></script>
        <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

        <link rel="stylesheet" href="../assets/css/custom/global.css">
        <link rel="stylesheet" href="../assets/css/custom/product_dashboard.css">
        <script src="../assets/js/global/catalogue.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <h1>Let's order fresh items for you.</h1>
                <div>
                    <a class="signup_btn" href="signup.html">Signup</a>
                    <a class="login_btn" href="login.html">Login</a>
                </div>
            </header>
            <aside>
                <a href="products_dashboard.html"><img src="../assets/images/studio_stationery_logo.svg" alt="Organic Shop"></a>
                <!-- <ul>
                    <li class="active"><a href="#"></a></li>
                    <li><a href="#"></a></li>
                </ul> -->
            </aside>
            <section>
                <?php echo form_open('Products/index_html', array('id' => 'search_form', 'class' => 'search_form', 'method' => 'get')); ?>
                    <input type="text" name="search" id="search_input" placeholder="Search Products">
                <?php echo form_close(); ?>
                <a class="show_cart" href="cart">Cart (0)</a>
                <?php echo form_open('Products/filter_products', array('method' => 'post', 'class' => 'categories_form')); ?>
                    <h3>Categories</h3>
                    <ul id="category-list">
                        <li>
                            <button type="submit" data-category-name=" " class="active">
                                <span>36</span><img src="../assets/images/category-all-icon.svg" alt="#"><h4>All Products</h4>
                            </button>
                        </li>
<?php foreach($category_data as $category) { ?>
                        <li>
                            <button type="button" data-category-name="<?= $category['name']; ?>">
                                <span><?= $category['product_count']; ?></span><img src="../assets/images/<?= $category['image']; ?>" alt="<?= $category['name']; ?>"><h4><?= $category['name']; ?></h4>
                            </button>
                        </li>
<?php } ?>
                    </ul>
                <?php echo form_close(); ?>
                <div>
                    <ul id="product-list"></ul>
                </div>
            </section>
        </div>
    </body>
</html>