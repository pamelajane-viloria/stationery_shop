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
        <script src="../assets/js/global/global.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <div>
                    <button class="profile_btn">
                    <span><?= $user_data['user_data']['first_name'][0] . $user_data['user_data']['last_name'][0]; ?></span>
                    </button>
                    <a href="/Users/logout">Logout</a>
                </div>
            </header>
            <aside>
                <a href="/products"><img src="../assets/images/studio_stationery_logo.svg" alt="Studio Stationery"></a>
            </aside>
            <section>
                <?php echo form_open('Products/index_html', array('id' => 'search_form', 'class' => 'search_form', 'method' => 'get')); ?>
                    <input type="text" name="search" id="search_input" placeholder="Search Products">
                <?php echo form_close(); ?>
                <a class="show_cart" href="cart">Cart (<?= $user_data['user_item_count']; ?>)</a>
                <?php echo form_open('Products/filter_products', array('method' => 'post', 'class' => 'categories_form')); ?>
                    <h3>Categories</h3>
                    <ul id="category-list">
                        <li>
                            <button type="button" class="filter-button active" data-category-name="All">
                                <span><?= $total_products; ?></span><img src="../assets/images/category-all-icon.svg" alt="#"><h4>All Products</h4>
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
                    <ul id="product-list">
                    <h3>All Products(<?= $product_count; ?>)</h3>
<?php foreach($product_data as $product) { ?>
                        <li>
                            <a href="/products/<?= $product['product_id']; ?>">
                                <img src="../assets/images/products/<?= $product['image_path']; ?>" alt="#">
                                <h3><?= $product['name']; ?></h3>
                                <ul class="rating">
<?php for($i = 0; $i < $product['rating']; $i++) { ?>
                                    <li></li>
<?php } ?>
                                </ul>
                                <span class="price">₱ <?= $product['price']; ?></span>
                            </a>
                        </li>
<?php } ?>
                    <ul class="pagination">
<?php foreach($pagination_links as $link) { ?>
                        <li>
                            <a href="<?php echo $link['url']; ?>" data-page="' . $link['page_number'] . '" class="<?php echo $link['page_number'] == $page ? 'active' : ''; ?>">
                                <?php echo $link['page_number']; ?>
                            </a>
                        </li>
<?php } ?>    
                        </ul>
                    </ul>
                </div>
            </section>
        </div>
    </body>
</html>