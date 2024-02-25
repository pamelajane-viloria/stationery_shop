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

        <link rel="stylesheet" href="../assets/css/custom/global.css">
        <link rel="stylesheet" href="../assets/css/custom/cart.css">
        <script src="../assets/js/global/cart.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script src="../assets/js/vendor/Stripe.js"></script>

    </head>
    <body>
        <div class="wrapper">
            <header>
                <div>
                    <button class="profile_btn">
                        <span><?= $user_data['user_data']['first_name'][0] . $user_data['user_data']['last_name'][0]; ?></span>
                    </button>
                </div>
            </header>
            <aside>
                <a href="/products"><img src="../assets/images/studio_stationery_logo.svg" alt="Studio Stationery"></a>
            </aside>
            <section >
                <?php echo form_open('/Orders/search_by_name', array('id' => 'search_form', 'class' => 'search_form', 'method' => 'get')); ?>
                <form class="search_form">
                    <input type="text" name="search" id="search_input" placeholder="Search Products">
                </form>
                <?php echo form_close(); ?>

                <!-- <?php var_dump($user_data); ?> -->
                <button class="show_cart">Cart (<?= $user_data['user_item_count']; ?>)</button>
                <section>
                    <div class="cart_items_form">
                        <ul id="cart_list">
                        </ul>
                    </div>
                    <?= form_open('/Orders/checkout/' . $user_data['user_data']['user_id'], array('class' => 'checkout_form', 'method' => 'post')); ?>
                        <h3>Shipping Information</h3>
                        <input type="checkbox" name="same_billing" id="same_billing " checked><label for="same_billing"> Same in Billing</label>
                        <ul>
                            <li>
                                <input type="text" name="shipping_first_name" value="John" required>
                                <label>First Name</label>
                            </li>
                            <li>
                                <input type="text" name="shipping_last_name" value="Doe" required>
                                <label>Last Name</label>
                            </li>
                            <li>
                                <input type="text" name="shipping_address_1" value="San Fernando City" required>
                                <label>Address 1</label>
                            </li>
                            <li>
                                <input type="text" name="shipping_address_2" value="Laguna" required>
                                <label>Address 2</label>
                            </li>
                            <li>
                                <input type="text" name="shipping_city" value="San Fernando City" required>
                                <label>City</label>
                            </li>
                            <li>
                                <input type="text" name="shipping_state" value="La Union" required>
                                <label>State</label>
                            </li>
                            <li>
                                <input type="text" name="shipping_zip_code" value="1234" required>
                                <label>Zip Code</label>
                            </li>
                        </ul>
                        <div class="billing_form">
                            <h3>Billing Information</h3>
                            <ul>
                                <li>
                                    <input type="text" name="billing_first_name" value="" required>
                                    <label>First Name</label>
                                </li>
                                <li>
                                    <input type="text" name="billing_last_name" value="" required>
                                    <label>Last Name</label>
                                </li>
                                <li>
                                    <input type="text" name="billing_address_1" value="" required>
                                    <label>Address 1</label>
                                </li>
                                <li>
                                    <input type="text" name="billing_address_2" value="" required>
                                    <label>Address 2</label>
                                </li>
                                <li>
                                    <input type="text" name="billing_city" value="" required>
                                    <label>City</label>
                                </li>
                                <li>
                                    <input type="text" name="billing_state" value="" required>
                                    <label>State</label>
                                </li>
                                <li>
                                    <input type="text" name="billing_zip_code" value="" required>
                                    <label>Zip Code</label>
                                </li>
                            </ul>
                        </div>
                        <h3>Order Summary</h3>
                        <h4 class="items_amount">Items <span></span></h4>
                        <h4>Shipping Fee <span>45</span></h4>
                        <h4 class="total_amount">Total Amount <span></span></h4>
                        <input type="hidden" name="total_amount" value="">
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#card_details_modal">Proceed to Checkout</button>
                    <?= form_close(); ?>
                </section>
            </section>
            <div class="modal fade form_modal" id="card_details_modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                        <?= form_open('/Orders/pay_order/' . $user_data['user_data']['user_id'], array('id' => 'payment-form', 'method' => 'post')); ?>
                            <h2>Card Details</h2>
                            <ul>
                                <li>
                                    <input type="text" name="card_name" value="BDO" required>
                                    <label>Card Name</label>
                                </li>
                                <li id="card-element"></li>
                            </ul>
                            <button type="submit">Pay</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="popover_overlay"></div>
    </body>
</html>