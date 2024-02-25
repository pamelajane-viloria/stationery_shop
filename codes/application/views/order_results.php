<?php foreach($order_data as $order) { ?>
                        <tr>
                            <td><span><a href="#"><?= $order['order_id']; ?></a></span></td>
                            <td><span><?= $order['date_ordered']; ?></span></td>
                            <td><span><?= $order['shipping_first_name'] . " " . $order['shipping_last_name'] ?><span><?= $order['shipping_address_1'] . " " . $order['shipping_city'] . " " . $order['shipping_state'] . " " . $order['shipping_zip_code']; ?></span></span></td>
                            <td><span>₱ <?= $order['total_amount']; ?></span></td>
                            <td>
                            <?= form_open('Admin_orders/update_order_status/' . $order['order_id'], array('class' => 'update_order_form', 'method' => 'post')); ?>
                                <!-- <form action="process.php" method="post"> -->
                                    <select class="selectpicker" name="status">
<?php foreach($statuses as $status) { ?>
                                        <option <?php if($order['status'] == $status) echo 'selected'; ?>><?= $status ?></option>
<?php } ?>
                                    </select>
                                <!-- </form> -->
                                <?= form_close() ?>
                            </td>
                        </tr>
<?php } ?>