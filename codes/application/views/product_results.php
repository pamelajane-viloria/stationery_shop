<?php foreach($product_data as $product) { ?>
                        <tr>
                            <td>
                                <span>
                                    <img src="../assets/images/products/<?= $product['image_path']; ?>" alt="#">
                                    <span><?= $product['name']; ?></span>
                                </span>
                            </td>
                            <td><span><?= $product['product_id']; ?></span></td>
                            <td><span>₱ <?= $product['price']; ?></span></td>
                            <td><span><?= $product['category_id']; ?></span></td>
                            <td><span><?= $product['inventory']; ?></span></td>
                            <td><span><?= $product['sold']; ?></span></td>
                            <td>
                                <span>
                                    <button class="edit_product" value="<?= $product['product_id']; ?>">Edit</button>
                                    <button class="delete_product">X</button>
                                </span>
                                <?= form_open('Dashboards/archive_product/' . $product['product_id'], array('id' => 'archive_form', 'class' => 'delete_product_form', 'method' => 'post')); ?>
                                    <p>Are you sure you want to remove this item?</p>
                                    <button type="button" class="cancel_remove">Cancel</button>
                                    <button type="submit">Remove</button>
                                <?= form_close(); ?>
                            </td>
                        </tr>
<?php } ?>