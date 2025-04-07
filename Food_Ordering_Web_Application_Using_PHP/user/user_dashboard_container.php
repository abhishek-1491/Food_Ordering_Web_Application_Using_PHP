<section class="dashboard tabcontent displayBlock " id="dashboard">
    <div class="dashboard-content">
        <h1>User Dashboard</h1>

        <div class="dashboard-cards">
            <div class="card">
                <div class="row card-img">Image</div>
                <div class="row card-content">
                    <h4>
                        <?php echo count($allResto) ?>
                    </h4>
                    <h2>Restaurant</h2>
                </div>
            </div>
            <div class="card">
                <div class="row card-img">Image</div>
                <div class="row card-content">
                    <h4>
                        <?php echo count($allDishes) ?>
                    </h4>
                    <h2>Dishes</h2>
                </div>
            </div>

            <div class="card">
                <div class="row card-img">Image</div>
                <div class="row card-content">
                    <h4><?php echo count($allOrders) ?></h4>
                    <h2>Orders</h2>
                </div>
            </div>

        </div>


    </div>
    <div class="top-dish">
        <h1>Top 2 Dishes</h1>
        <div class="top-dish-cards">


            <?php
            if (count($top2) != 0) {
                foreach ($top2 as $key => $dish) {
                    ?>
                    <div>
                        <img src="<?php echo $dish['dish_image'] ?>" alt="">
                        <h1>
                            <?php echo $dish['dish_name'] ?>
                        </h1>
                        <h3>
                            <?php echo $dish['rest_name'] ?>
                        </h3>
                        <h4>₹
                            <?php echo $dish['dish_price'] ?>
                        </h4>
                        <h5>Description :</h5>
                        <dl>
                            <dd>
                                <?php echo $dish['dish_desc'] ?>

                            </dd>
                        </dl>
                        <button>Order Now</button>
                        <button>Add To Cart</button>
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
    </div>
</section>