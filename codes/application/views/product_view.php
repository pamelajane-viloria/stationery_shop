<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>

        <link rel="shortcut icon" href="../assets/images/studio_stationery.ico" type="image/x-icon">

        <script src="../assets/js/vendor/jquery.min.js"></script>
        <script src="../assets/js/vendor/popper.min.js"></script>
        <script src="../assets/js/vendor/bootstrap.min.js"></script>
        <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

        <link rel="stylesheet" href="../assets/css/custom/global.css">
        <link rel="stylesheet" href="../assets/css/custom/product_view.css">
        <script src="../assets/js/global/product_view.js"></script>

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
                <a href="catalogue.html"><img src="../assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
                <!-- <ul>
                    <li class="active"><a href="#"></a></li>
                    <li><a href="#"></a></li>
                </ul> -->
            </aside>
            <section >
                <form action="process.php" method="post" class="search_form">
                    <input type="text" name="search" placeholder="Search Products">
                </form>
                <a class="show_cart" href="/cart">Cart (0)</a>
                <a href="/products">Go Back</a>
                <ul>
                    <li>
                        <?php foreach ($product_image as $image) { ?>
                            <?php if ($image['is_main']) { ?>
                                <img src="../assets/images/products/<?= $image['image_path']; ?>" alt="<?= $product_data['name']; ?>" class="default-image">
                            <?php } ?>
                        <?php } ?>
                        <ul>
                            <?php foreach ($product_image as $image) { ?>
                                <li><button class="show_image"><img src="../assets/images/products/<?= $image['image_path']; ?>" alt="<?= $product_data['name']; ?>"></button></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li>
                        <h2><?= $product_data['name']; ?></h2>
                        <ul class="rating">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <span>36 Rating</span>
                        <span class="amount">₱ <?= $product_data['price']; ?></span>
                        <p><?= $product_data['description']; ?></p>
                        <form action="" method="post" id="add_to_cart_form">
                            <ul>
                                <li>
                                    <label>Quantity</label>
                                    <input type="text" min-value="1" value="1" class="form-control">
                                    <ul>
                                        <li><button type="button" class="increase_decrease_quantity" data-quantity-ctrl="1"></button></li>
                                        <li><button type="button" class="increase_decrease_quantity" data-quantity-ctrl="0"></button></li>
                                    </ul>
                                </li>
                                <li>
                                    <label>Total Amount</label>
                                    <span class="total_amount">₱ <?= $product_data['price']; ?></span>
                                </li>
                                <li><button type="submit" id="add_to_cart">Add to Cart</button></li>
                            </ul>
                        </form>
                    </li>
                </ul>
                <section>
                    <h3>Similar Items</h3>
                    <ul id="similar-products-list">
                        <?php foreach($similar_products as $similar_product) { ?>
                        <li>
                            <a href="product_view.html">
                                <img src="../assets/images/products/<?= $similar_product['image_path']; ?>" alt="#">
                                <h3><?= $similar_product['name']; ?></h3>
                                <ul class="rating">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                                <span>36 Rating</span>
                                <span class="price">₱ <?= $similar_product['price']; ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </section>
            </section>
        </div>
    </body>
</html>