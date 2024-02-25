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

