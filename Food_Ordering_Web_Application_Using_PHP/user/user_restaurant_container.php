

<section class="restaurant tabcontent " id="rest">
        <h1>All Restaurants</h1>
        <div class="resto-cards">
            <div class="resto-card">
                <img src="../images/r1.jpg" alt="">
                <div class="resto-content">
                    <h2>Title of Resto</h2>
                    <table>
                        <tr>
                            <th>Timing</th>
                            <th>:</th>
                            <td>09:00 to 21:00</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <th>:</th>
                            <td>Karve Nagar, Nanded</td>
                        </tr>
                        <tr>
                            <th>Contact</th>
                            <th>:</th>
                            <td>9527974938</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <td>abhi@gmail.com</td>
                        </tr>
                    </table>

                    <div class="btn">
                        <button>View Menu</button>
                        <button>Add To Wishlist</button>
                    </div>
                </div>
            </div>
            <?php
            foreach ($allResto as $key => $singleResto) {
                ?>
                <div class="resto-card">
                    <img src="../images/r1.jpg" alt="">
                    <div class="resto-content">
                        <h2>
                            <?php echo $singleResto["name"] ?>
                        </h2>
                        <table>
                            <tr>
                                <th>Timing</th>
                                <th>:</th>
                                <td>
                                    <?php echo date("H:i", strtotime($singleResto["o_time"])) ?> AM to
                                    <?php echo date("H:i", strtotime($singleResto["c_time"])) ?> AM
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td>
                                    <?php echo $singleResto["address"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Contact</th>
                                <th>:</th>
                                <td>
                                    <?php echo $singleResto["phone"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th>:</th>
                                <td>
                                    <?php echo $singleResto["email"] ?>
                                </td>
                            </tr>
                        </table>

                        <div class="btn">
                            <button>View Menu</button>
                            <button>Add To Wishlist</button>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>



        </div>
    </section>