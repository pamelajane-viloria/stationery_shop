<?php if ($cart_data == 0) { ?>
    <li class="no_data">
        <p>There are no items in this cart.</p>
        <a href="/Products">Continue Shipping</a>
    </li>
<?php } else { 
foreach($cart_data as $cart_item) { ?>
                            <li>
                                <img src="../assets/images/products/<?= $cart_item['image_path']; ?>" alt="">
                                <h3><?= $cart_item['name']; ?></h3>
                                <span class="amount"><?= $cart_item['price']; ?></span>
                                <ul>
                                    <?= form_open('/Orders/update_product_quantity/' . $cart_item['cart_id'], array('method' => 'post')); ?>
                                        <li>
                                            <label>Quantity</label>
                                            <input type="text" min-value="1" value="<?= $cart_item['quantity']; ?>" name="update_cart_item_id" class="form_control">
                                            <ul>
                                                <li><button type="button" class="increase_decrease_quantity" data-quantity-ctrl="1"></button></li>
                                                <li><button type="button" class="increase_decrease_quantity" data-quantity-ctrl="0"></button></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <label>Total Amount</label>
                                            <input class="total_amount" value="<?= $cart_item['total_amount']; ?>" name="item_total_amount" readonly >
                                        </li>
                                        <li>
                                            <button type="button" class="remove_item"></button>
                                        </li>
                                    <?= form_close(); ?>
                                </ul>
                                <div>
                                    <?= form_open('/Orders/archive_order/' . $cart_item['cart_id'], array('id' => 'archive_form', 'class' => 'delete_product_form', 'method' => 'post')); ?>
                                        <p>Are you sure you want to remove this item?</p>
                                        <button type="button" class="cancel_remove">Cancel</button>
                                        <button type="submit" class="remove">Remove</button>
                                    <?= form_close(); ?>
                                </div>
                            </li>
<?php } ?>
<?php } ?>