

<section class="menu tabcontent" id="menu">
        <h1>All Dishes</h1>
        <div class="menu-cards">

            <?php
            if (count($allDishes) != 0) {
                foreach ($allDishes as $key => $singledish) {
                    ?>

                    <div class="menu-card">
                        <img src="<?php echo $singledish["dish_image"] ?>" alt="">
                        <div class="menu-content">
                            <h2>
                                <?php echo $singledish["dish_name"] ?>
                            </h2>
                            <h3>
                                <?php echo $singledish["rest_name"] ?>
                            </h3>
                            <h4>Price &nbsp;: &nbsp; ₹
                                <?php echo $singledish["dish_price"] ?> /-
                            </h4>
                            <h5>Description :</h5>
                            <dl>
                                <dd>
                                    <?php echo $singledish["dish_desc"] ?>

                                </dd>
                            </dl>
                            <section class="rating star_<?php echo $singledish["menu_id"] ?>">
                                <?php $starvalue = "star_" . $singledish["menu_id"]; $menuId = $singledish['menu_id'];?>
                                <div class="stars" id="starRating">
                                    <span class="star" data-value="1"
                                        onclick="starFunction('<?php echo $starvalue ?>',1)">★</span>
                                    <span class="star" data-value="2"
                                        onclick="starFunction('<?php echo $starvalue ?>',2)">★</span>
                                    <span class="star" data-value="3"
                                        onclick="starFunction('<?php echo $starvalue ?>',3)">★</span>
                                    <span class="star" data-value="4"
                                        onclick="starFunction('<?php echo $starvalue ?>',4)">★</span>
                                    <span class="star " data-value="5"
                                        onclick="starFunction('<?php echo $starvalue ?>',5)">★</span>
                                </div>
                            </section>
                            <div class="btn">
                                <button onclick="addToWishlist('<?php  echo $menuId ?>','<?php echo $user_id ?>')"><a href="order_page.php">Order Now</a></button>
                                <button onclick="addToWishlist('<?php  echo $menuId ?>','<?php echo $user_id ?>')">Add To Wishlist</button>
                                <!-- <button><a href="addtoWishlist2.php">Add To Wishlist</a></button> -->
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <b>No Dishes Now</b>
                <?php
            }
            ?>
        </div>
    </section>