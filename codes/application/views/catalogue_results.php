<h3>All Products(<?= $product_count; ?>)</h3>
<?php foreach($product_data as $product) { ?>
                        <li>
                            <a href="products/<?= $product['product_id']; ?>">
                                <img src="../assets/images/products/<?= $product['image_path']; ?>" alt="#">
                                <h3><?= $product['name']; ?></h3>
                                <ul class="rating">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                                <span>36 Rating</span>
                                <span class="price">₱ <?= $product['price']; ?></span>
                            </a>
                        </li>
<?php } ?>