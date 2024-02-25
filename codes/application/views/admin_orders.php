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

        <link rel="stylesheet" href="../assets/css/custom/admin_global.css">
        <script src="../assets/js/global/admin_orders.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <h2>Orders</h2>
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
                <a href="/Products"><img src="../assets/images/Stationery_studio_dark.png" alt="stationery_shop"></a>
                <ul>
                    <li class="active"><a href="/Admin_orders/orders">Orders</a></li>
                    <li><a href="/Dashboards/products">Products</a></li>
                </ul>
            </aside>
            <section>
                <form action="Admin_orders/search_orders" method="post" class="search_form">
                    <input type="text" name="search" id="search_input" placeholder="Search Orders">
                </form>
                <?php echo form_open('Admin_orders/filter_orders', array('method' => 'post', 'class' => 'status_form')); ?>
                    <h3>Status</h3>
                    <ul>
                        <li>
                            <button type="submit" class="active" data-status-name="All">
                                <span><?= $order_count ?></span><img src="../assets/images/status-all-icon.svg" alt="#"><h4>All Products</h4>
                            </button>
                        </li>
                        <?php foreach ($status_counts as $status_item): ?>
                            <?php 
                            $status = $status_item['status'];
                            $count = $status_item['count'];
                            ?>
                            <li>
                                <button type="submit" class="" data-status-name="<?= $status ?>">
                                    <span><?= $count ?></span><img src="../assets/images/status-<?= strtolower($status) ?>-icon.svg" alt="#"><h4><?= $status ?></h4>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php echo form_close(); ?>
                <div>
                    <h3>All Orders</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID #</th>
                                <th>Order Date</th>
                                <th>Receiver</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="order_list">
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </body>
</html>