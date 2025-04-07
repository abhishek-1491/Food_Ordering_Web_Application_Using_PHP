<section class="sidebar ">
        <div class="user-profile">
            <img src="<?php echo $user['image'] ?>" alt="">
            <h3 style="opacity:0.6 ; margin:0">Welcome !</h3>
            <h1>
                <?php echo $user["name"]; ?>
            </h1>
        </div>
        <div class="sidebar-list">

            <li class="tablink active" onclick="showContainer('dashboard')">Dashboard</li>

            <li class="tablink" onclick="showContainer('rest')">Restaurant</li>

            <li class="tablink" onclick="showContainer('menu')">Menu</li>
            <li class="tablink" onclick="showContainer('orders')">Orders</li>

        </div>
    </section>