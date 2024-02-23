<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>

        <script src="../assets/js/vendor/jquery.min.js"></script>
        <script src="../assets/js/vendor/popper.min.js"></script>
        <script src="../assets/js/vendor/bootstrap.min.js"></script>
        <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

        <link rel="stylesheet" href="../assets/css/custom/admin_global.css">
        <script src="../assets/js/global/admin_products.js"></script>
    </head>
    <body>
<?php if($this->session->flashdata('input_errors')){ ?>
        <div class="error-alert rounded shadow">
            <span>There were errors with your submission</span>
            <?= $this->session->flashdata('input_errors'); ?>
        </div>
<?php } ?>
        <div class="wrapper">
            <header>
                <h1>Let's provide fresh items for everyone.</h1>
                <h2>Products</h2>
                <div>
                    <a class="switch" href="/products">Switch to Shop View</a>
                    <button class="profile">
                        <img src="../assets/images/profile.png" alt="#">
                    </button>
                </div>
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle profile_dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu admin_dropdown" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </div>
            </header>
            <aside>
                <a href="#"><img src="../assets/images/organi_shop_logo_dark.svg" alt="Organic Shop"></a>
                <ul>
                    <li><a href="/Dashboards/orders">Orders</a></li>
                    <li class="active"><a href="/Dashboards/products">Products</a></li>
                </ul>
            </aside>
            <section>
                <!-- <form action="process.php" method="post" class="search_form">
                    <input type="text" name="search" id="search_input" placeholder="Search Products">
                </form> -->
                <?= form_open('Dashboards/index_html', array('id' => 'search_form', 'class' => 'search_form', 'method' => 'get')); ?>
                    <input type="text" name="search" id="search_input" placeholder="Search Products">
                <?= form_close(); ?>
                <button class="add_product" data-toggle="modal" data-target="#add_product_modal">Add Product</button>
                <form action="process.php" method="post" class="status_form">
                    <h3>Categories</h3>
                    <ul id="category-list">
                        <li>
                            <button type="submit" class="active">
                                <span>20</span><img src="../assets/images/category-all-icon.svg" alt="#"><h4>All Products</h4>
                            </button>
                        </li>
<?php foreach($category_data as $category) { ?>
                        <li>
                            <button type="submit" data-category-name="<?= $category['name']; ?>">
                                <span><?= $category['product_count']; ?></span><img src="../assets/images/<?= $category['image']; ?>" alt="<?= $category['name']; ?>"><h4><?= $category['name']; ?></h4>
                            </button>
                        </li>
    <?php } ?>
                    </ul>
                </form>
                <div>
                    <table class="products_table">
                        <thead>
                            <tr>
                                <th><h3>All Products</h3></th>
                                <th>ID #</th>
                                <th>Price</th>
                                <th>Caregory</th>
                                <th>Inventory</th>
                                <th>Sold</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="modal fade form_modal" id="add_product_modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                        <form id="product_form" class="add_product_form" method="POST" enctype="multipart/form-data" name="product_form" action="/Dashboards/add_product/">
  
                            <h2>Add a Product</h2>
                            <ul>
                                <li>
                                    <input type="text" name="prouct_name" value="asdasd" >
                                    <label>Product Name</label>
                                </li>
                                <li>
                                    <textarea name="description" >dasddas</textarea>
                                    <label>Description</label>
                                </li>
                                <li>
                                    <label>Category</label>
                                    <select class="selectpicker">
                                        <option>Vegetables</option>
                                        <option>Fruits</option>
                                        <option>Pork</option>
                                        <option>Beef</option>
                                        <option>Chicken</option>
                                    </select>
                                </li>
                                <li>
                                    <input type="number" name="price" value="1" >
                                    <label>Price</label>
                                </li>
                                <li>
                                    <input type="number" name="inventory" value="1" >
                                    <label>Inventory</label>
                                </li>
                                <li>
                                    <label>Upload Images (5 Max)</label>
                                    <ul id="image_preview">
                                        <li>
                                            <button type="button" class="upload_image"></button>
                                        </li>
                                    </ul>
                                    <input type="file" id="image_upload" name="userfile[]" class="image_input" multiple/>
                                </li>
                            </ul>
                            <button type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="popover_overlay"></div>
    </body>
</html>