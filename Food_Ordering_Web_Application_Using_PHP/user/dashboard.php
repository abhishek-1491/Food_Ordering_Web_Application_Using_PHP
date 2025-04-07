<?php
session_start();



if (!isset($_SESSION['user']) && !isset($_SESSION['allDishes']) && !isset($_SESSION['allResto'])) {
    header("Location: ../index.php");
    exit();
}




$user = $_SESSION['user'];
$allResto = $_SESSION['user_allResto'];
$allDishes = $_SESSION['user_allDishes'];
$user_id = $user["user_id"];
// $allWishlist = $_SESSION['allWishlist'];

$conn = new mysqli("localhost", "root", "", "foodapp");

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$allWishlist = [];
$allOrders = [];
$allQuantity = [];
$allOrderedResto = [];
//TO get All wishlist of current user

$getWishlist = $conn->prepare("SELECT menu_id,dish_name,dish_price,dish_image FROM menu WHERE menu_id IN (SELECT menu_id FROM wishlist WHERE user_id = ?)");
$getWishlist->bind_param("i", $user_id);
$getWishlist->execute();
$result = $getWishlist->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allWishlist[] = $row;
    }
}

// To get all orders all current user

$getOrderlist = $conn->prepare("SELECT invoice_no, dish_id,quantity,rest_id, total_payment, status, ordered_date FROM orders WHERE user_id = ?");
$getOrderlist->bind_param("i", $user_id);
$getOrderlist->execute();
$orderResult = $getOrderlist->get_result();
while ($orderRow = $orderResult->fetch_assoc()) {
    $invoice_no = $orderRow["invoice_no"];
    $dishIDs = json_decode($orderRow["dish_id"], true);
    $quantity = json_decode($orderRow["quantity"], true);
    $restoID = json_decode($orderRow["rest_id"], true);

    if ((!is_array($dishIDs) || empty($dishIDs) && !is_array($quantity) || empty($quantity)) && !is_array($restoID) || empty($restoID)) {
        continue;
    }
    $allQuantity[] = $quantity;
    // print_r($restoID);
    // echo "<br><br>";
    // print_r($invoice_no);
    $eachDishID = implode(",", array_fill(0, count($dishIDs), "?"));
    // print_r($eachDishID);
    $dishQuery = $conn->prepare("SELECT dish_name FROM menu WHERE menu_id IN ($eachDishID)");
    $types = str_repeat("i", count($dishIDs));

    $dishQuery->bind_param($types, ...$dishIDs);
    $dishQuery->execute();
    $dishResult = $dishQuery->get_result();

    $dishes = [];
    while ($dishRow = $dishResult->fetch_assoc()) {
        $dishes[] = $dishRow["dish_name"];
    }

    $dishQuery->close();

    $dishANDquantity = [];
    for ($i = 0; $i < count($dishes); $i++) {
        $dishANDquantity[] = $dishes[$i] . "($quantity[$i])";
    }

    $allOrders[] = [
        "invoice_no" => $invoice_no,
        "status" => $orderRow["status"],
        "total_payment" => $orderRow["total_payment"],
        "ordered_date" => $orderRow["ordered_date"],
        "dishes" => $dishANDquantity
    ];

}
$getOrderlist->close();

$allCount = [];
$sql2 = "SELECT dish_id, quantity FROM orders";
$topResult = $conn->query($sql2);
if ($topResult->num_rows > 0) {
    while ($row = $topResult->fetch_assoc()) {
        $eachDID = json_decode($row["dish_id"], true);
        $eachQ = json_decode($row["quantity"], true);

        for ($i = 0; $i < count($eachDID); $i++) {

            $allCount[] = [
                "$eachDID[$i]" => $eachQ[$i]
            ];
        }
    }
}
$count = [];
foreach ($allCount as $key => $value) {

    // print_r($value);
    // echo "<br>";
    $demo = $value;
    // print_r($demo);
    // echo "<br>";
    foreach ($demo as $key2 => $quan) {
        // echo $key2 . " - " .$quan;
        // echo "<br>";

        if (isset($count[$key2])) {
            $count[$key2] += $quan;
        } else {
            $count[$key2] = $quan;
        }
    }
}
arsort($count);
$topD = array_slice($count, 0, 2, true);

// print_r($topD);

$top2 = [];
foreach ($topD as $key => $value) {
    $sql3 = "SELECT menu_id, dish_image,dish_name,dish_price,dish_desc,rest_name,rest_id FROM menu where menu_id = $key";
    $top2Dishes = $conn->query($sql3);
    if ($top2Dishes->num_rows > 0) {
        while ($row5 = $top2Dishes->fetch_assoc()) {
            $top2[] = $row5;
        }
    }
}
// print_r($top2);


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <script src="https://kit.fontawesome.com/35821647e0.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        nav {
            width: 100%;
            height: 8vh;
            background-color: aliceblue;

            li {
                display: inline-block;
            }

            .logo {
                /* background-color: red; */
                margin-left: 40px;
                width: 50%;
                float: left;

                h1 {
                    margin: 0;
                    font-size: 35px;
                }
            }

            .nav-items {
                /* background-color: red; */
                width: 20%;
                height: 100%;
                text-align: right;
                font-size: 25px;
                float: right;
                margin-right: 2%;

                li {
                    padding: 5px;
                    border-radius: 50%;
                    background-color: red;
                    color: white;
                    width: 40px;
                    height: 36px;
                    text-align: center;
                    margin-top: 4px;
                    margin-right: 20px;

                    span {
                        font-size: medium;

                    }

                    a {
                        color: white;
                    }
                }

                li:hover {
                    cursor: pointer;
                    background-color: black;
                }
            }
        }

        li {
            list-style: none;
        }

        .row {
            float: left;
        }

        .sidebar {
            width: 15%;
            height: 92vh;
            /* background-color: rgb(55, 45, 45); */
            /* background-color: aqua; */
            position: fixed;
            top: 8vh;

            /* display: none; */
            .user-profile {
                /* background-color: antiquewhite; */
                width: 100%;
                /* height: 200px; */
                /* padding-bottom: 15px; */
                text-align: center;


                img {
                    width: 130px;
                    height: 130px;
                    margin-top: 15px;
                    border-radius: 50%;
                }

                h1 {
                    margin: 0;
                }
            }

            .sidebar-list {
                /* background-color: red; */
                width: 100%;
                margin-top: 20px;
                /* margin-left: 10%; */


                li {
                    list-style: none;
                    width: 80%;
                    padding: 15px;
                    padding-left: 30px;
                    margin-top: 10px;
                    transition: 0.5s ease-in-out;
                    /* background-color: black; */
                }

                li:hover {
                    transition: 0.5s ease-in-out;
                    color: aliceblue;
                    background-color: black;
                    cursor: pointer;
                }
            }
        }

        .dashboard {
            width: 85%;
            height: 90.6vh;
            /* position: fixed; */
            /* background-color: aquamarine; */
            overflow: scroll;
            scrollbar-width: none;
            margin-left: 15%;
            padding-top: 10px;


            display: none;

            .top-dish {
                width: 90%;
                height: 50vh;
                margin-left: 5%;
                padding: 15px;
                margin-top: 25px;
                /* box-shadow: 0 0 10px rgb(220, 200, 200); */
                border-radius: 5px;
                margin-bottom: 50px;
                position: relative;

                .top-dish-cards {
                    display: grid;
                    grid-template-columns: 49% 49%;
                    grid-gap: 15px;
                    /* background-color: red; */
                    padding: 20px;

                    div {
                        padding: 5px;
                        height: 300px;
                        /* margin-left: 15%; */
                        box-shadow: 0 0 10px rgb(220, 200, 200);
                        /* background-color: red; */

                        img {
                            width: 43%;
                            height: 290px;
                            /* border: 1px solid; */
                            float: left;
                            padding-right: 15px;
                        }

                        h1 {
                            margin: 0;
                            /* margin-bottom: 5px; */
                        }

                        h3,
                        h4,
                        h5 {
                            margin: 0;
                            margin-bottom: 5px;
                        }

                        dl {
                            margin-top: -6px;
                            height: 90px;
                            overflow: scroll;
                            scrollbar-width: thin;
                            font-size: small;
                        }

                        button {
                            padding: 5px 15px;
                            border: 2px dashed blue;
                            transition: 0.5s ease-in-out;
                            background: transparent;
                            font-size: medium;
                            margin-right: 10px;

                        }

                        button:hover {
                            cursor: pointer;
                            background-color: black;
                            transition: 0.5s ease-in-out;
                            color: gold;
                            scale: 1.1;
                            border: none;
                        }
                    }
                }




            }

        }

        .dashboard .dashboard-content {
            width: 93.5%;
            height: 40vh;
            margin-left: 2%;
            padding: 15px;
            margin-top: 25px;
            /* display: none; */
            /* box-shadow: 0 0 10px rgb(220, 200, 200); */
            border-radius: 5px;
            /* background-color: red; */

            h1 {
                font-size: 45px;
                width: 99%;
                margin-top: 0;
                padding-left: 30px;
                color: white;
                background-color: red;
            }



        }

        .dashboard .dashboard-content .dashboard-cards {
            /* background-color: red; */
            /* height: 50px; */
            padding: 0 50px;
            /* gap: 10px; */
            /* display: flex; */
            display: grid;
            grid-gap: 10px;
            grid-template-columns: repeat(3, 1fr);
            /* max-width: 90%; */

        }

        .dashboard .dashboard-content .dashboard-cards .card {
            /* background-color: blue; */
            padding: 10px;
            width: 90%;
            height: 120px;
            margin: 15px;
            box-shadow: 0 0 5px rgb(229, 206, 206);




            .card-img {
                width: 30%;
                height: 100%;
                /* background-color: red; */
            }

            .card-content {
                /* background-color: blue; */
                width: 70%;
                height: 100%;
            }
        }



        .orders {
            width: 85%;
            height: 92vh;
            position: fixed;
            /* background-color: aquamarine; */
            top: 8vh;
            left: 15%;

            display: none;
        }

        .orders .orders-content {
            width: 90%;
            height: 80vh;
            margin-left: 5%;
            padding: 15px;
            margin-top: 25px;
            box-shadow: 0 0 10px rgb(220, 200, 200);
            border-radius: 5px;
            /* background-color: red; */

            h1 {
                height: 35px;
                border-radius: 5px 5px 0 0;
                background-color: blue;
                padding: 5px;
            }
        }

        .orders .orders-content .orders-table {
            width: 99.8%;
            height: 85%;
            margin-top: -20px;
            /* border: 1px solid rgb(199, 178, 178); */
            border-top: none;
            overflow: scroll;
            scrollbar-width: none;
            /* background-color: red; */

            table {
                width: 100%;
                margin-top: 10px;
                border-left: none;
            }

            table,
            th,
            td {
                border: 1px solid rgb(199, 178, 178);
                border-collapse: collapse;
            }

            th,
            td {
                padding: 8px;
            }
        }

        .active {
            background-color: lightslategray;
            font-size: large;
            color: aliceblue;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .displayBlock {
            display: block;
        }


        .restaurant {
            width: 83.2%;
            height: 87.8vh;
            position: fixed;
            /* background-color: black; */
            top: 8vh;
            left: 15%;
            padding: 15px;
            overflow: scroll;
            scrollbar-width: none;
            /* border: 1px solid; */

            display: none;

            h1 {
                font-size: 45px;
                width: 97%;
                margin-top: 0;
                padding-left: 30px;
                color: white;
                background-color: red;
            }
        }

        .restaurant .resto-cards {
            width: 95%;
            display: grid;
            grid-template-columns: repeat(3, minmax(350px, 1fr));
            gap: 25px;
            padding-left: 30px;
        }

        .restaurant .resto-card {
            height: 450px;
            margin-bottom: 10px;
            margin-top: 10px;
            /* background-color: red; */
            box-shadow: 0 0 10px rgb(215, 187, 187);


            img {
                width: 100%;
                height: 50%;
            }

            .resto-content {
                width: 94%;
                height: 45.3%;
                /* line-height: 10px; */
                /* background-color: red; */

                position: relative;
                padding: 10px;
                padding-top: 0;

                h2 {
                    margin: 0;
                }

                /*p{
                    line-height: 12px;
                } */

                table {
                    /* border: 1px solid; */
                    width: 100%;
                    text-align: left;
                }

                .btn {
                    /* padding: 7px 20px; */
                    /* background-color: antiquewhite; */
                    position: absolute;
                    bottom: 5%;
                    padding-left: 10px;

                    button {
                        padding: 7px 18px;
                        border: 2px dashed blue;
                        transition: 0.5s ease-in-out;
                        background: transparent;
                        font-size: medium;
                    }

                    button:hover {
                        cursor: pointer;
                        background-color: black;
                        transition: 0.5s ease-in-out;
                        color: gold;
                        scale: 1.1;
                        border: none;
                    }
                }

                button:nth-child(2) {
                    /* padding: 8px; */
                    margin-left: 50px;
                }
            }

        }

        .menu {
            width: 83.2%;
            height: 87.8vh;
            position: fixed;
            /* background-color: black; */
            top: 8vh;
            left: 15%;
            padding: 15px;
            overflow: scroll;
            scrollbar-width: none;
            /* border: 1px solid; */

            display: none;

            h1 {
                font-size: 45px;
                width: 97%;
                margin-top: 0;
                padding-left: 30px;
                color: white;
                background-color: red;
            }
        }

        .menu .menu-cards {
            width: 95%;
            display: grid;
            grid-template-columns: repeat(2, minmax(300px, 1fr));
            gap: 25px;
            padding-left: 30px;
            /* background-color: aliceblue; */
        }

        .menu .menu-card {
            height: 300px;
            margin-bottom: 10px;
            margin-top: 10px;
            /* background-color: red; */
            box-shadow: 0 0 10px rgb(215, 187, 187);


            img {
                width: 35%;
                padding-right: 10px;
                height: 70%;
                float: left;
            }

            .menu-content {
                width: 94%;
                height: 45.3%;
                /* line-height: 10px; */
                /* background-color: red; */

                position: relative;
                padding: 10px;
                padding-top: 0;

                h2 {
                    margin: 0;
                    margin-top: 5px;

                }

                h3 {
                    margin: 0;
                    opacity: 0.5;
                    font-size: medium;
                }

                h4 {
                    margin: 0;
                    font-size: large;
                }

                h5 {
                    margin: 0;
                }

                dl {
                    margin-top: -3px;
                    height: 90px;
                    overflow: scroll;
                    scrollbar-width: thin;
                    font-size: small;
                }

                .rating {
                    /* background-color: red; */
                    width: 40%;
                    float: left;
                    font-size: larger;
                    margin-top: 10px;
                }

                .btn {
                    /* padding: 7px 20px; */
                    /* background-color: antiquewhite; */
                    /* position: absolute; */
                    bottom: 5%;
                    padding-left: 10px;
                    margin-top: 55px;

                    button {
                        padding: 7px 18px;
                        border: 2px dashed blue;
                        transition: 0.5s ease-in-out;
                        background: transparent;
                        font-size: medium;

                        a {
                            color: black;
                            /* border: 1px solid; */
                            padding: 6px 10px;
                            transition: 0.5s ease-in-out;

                        }

                        a:hover {
                            color: white;
                            transition: 0.5s ease-in-out;
                        }
                    }

                    button:hover {
                        cursor: pointer;
                        background-color: black;
                        transition: 0.5s ease-in-out;
                        color: white;
                        scale: 1.1;
                        border: none;
                    }
                }

                button:nth-child(2) {
                    /* padding: 8px; */
                    margin-left: 10px;
                }

            }

        }

        .stars {
            display: flex;
            direction: row;
            cursor: pointer;
        }

        .star {
            font-size: 30px;
            color: #ccc;
            transition: color 0.3s;
        }

        .star:hover,
        .star.activestar {
            color: gold;
        }

        .cart-list {
            position: fixed;
            width: 300px;
            height: 400px;
            /* background-color: aquamarine; */
            right: 10.7%;
            top: 7.2%;
            filter: drop-shadow(0 0 10px rgb(215, 187, 187));
            display: none;
        }

        .cart-list .triangle-up {
            width: 50px;
            height: 50px;
            background-color: white;
            margin-top: -40px;
            margin-left: 67.4%;
            clip-path: polygon(45% 77%, 21% 100%, 69% 100%);
        }

        .cart-list .main-cart-list {
            width: 100%;
            height: 92%;

            background-color: white;
        }

        .cart-list .main-cart-list .main-cart {
            width: 100%;
            height: 100%;
            /* background-color: blue; */
            padding-top: 15px;
            overflow: scroll;
            scrollbar-width: none;
            position: relative;
        }

        .cart-list .main-cart-list .cart-order-list {
            width: 100%;
            height: 20%;
            margin-bottom: 10px;
            /* margin-top: 5px; */
            /* padding-top: 5px; */
            /* background-color: red; */
            box-shadow: 0 0 10px rgb(215, 187, 187);

            .cart-order-list-image {
                height: 100%;
                width: 30%;
                margin-left: 1%;
                float: left;

                /* background-color: blue; */
                img {
                    width: 90%;
                    height: 90%;
                    margin-top: 5%;
                    margin-left: 5%;
                    border-radius: 10px;
                    /* display: none; */
                }
            }

            .cart-order-list-content {
                float: left;
                height: 100%;
                /* background-color: yellow; */
                width: 60%;
                padding-left: 15px;
                position: relative;

                h5,
                h4 {
                    margin: 0;
                }

                button {
                    border: none;
                    padding: 5px 15px;
                    background-color: red;
                    color: white;
                    margin-left: 35%;
                    position: absolute;
                    bottom: 7%;
                    right: 2%;
                    /* margin-top: -15px; */
                    transition: 0.5s ease-in-out;
                }

                button:hover {
                    cursor: pointer;
                    background-color: black;
                    font-size: large;
                    transition: 0.3s ease-in-out;
                    color: white;
                }
            }
        }

        .checkout-btn {
            width: 100%;
            height: 11%;
            position: absolute;
            bottom: 0;
            background-color: white;
            box-shadow: 0 0 10px rgb(215, 187, 187);
        }

        .checkout-btn button {
            padding: 7px 20px;
            border: none;
            background-color: red;
            font-size: large;
            float: right;
            margin-top: 7px;
            margin-right: 20px;
            transition: 0.3s ease-in-out;
            color: white;

            a {
                text-decoration: none;
                color: white;
            }

            a:hover {
                color: gold;
            }
        }

        .checkout-btn button:hover {
            cursor: pointer;
            scale: 1.1;
            background-color: black;
            color: gold;
            transition: 0.3s ease-in-out;

        }

        .profile {
            position: fixed;
            width: 200px;
            height: 200px;
            /* background-color: aquamarine; */
            right: 7.7%;
            top: 7.2%;
            filter: drop-shadow(0 0 10px rgb(215, 187, 187));
            display: none;
        }

        .profile .triangle-up {
            width: 50px;
            height: 50px;
            background-color: white;
            margin-top: -40px;
            margin-left: 67.4%;
            clip-path: polygon(45% 77%, 21% 100%, 69% 100%);
        }

        .profile .main-cart-list {
            width: 100%;
            height: 96%;

            background-color: white;
        }

        .profile .main-cart-list .main-cart {
            width: 100%;
            height: 100%;
            /* background-color: blue; */
            padding-top: 30px;
            overflow: scroll;
            scrollbar-width: none;
            position: relative;
        }

        .profile .main-cart-list .main-cart button {
            width: 100%;
            /* height: 35px; */
            /* margin-bottom: 10px; */
            border: none;
            font-size: large;
            padding: 15px;
            background: transparent;
            transition: 0.3s ease-in-out;

        }

        .profile .main-cart-list .main-cart button:hover {
            cursor: pointer;
            scale: 1.1;
            transition: 0.5s ease-in-out;
            background-color: aqua;
        }

        a {
            text-decoration: none;

        }
    </style>
</head>

<body>
    <nav>
        <div class="logo">
            <h1><i class="fa-solid fa-utensils"></i> &nbsp; Food<span style="color:red">Kart</span></h1>
        </div>

        <div class="nav-items">
            <li onmouseover="showWishlist()"><span><i class="fa-solid fa-cart-shopping"></i></span> </li>
            <li onmouseover="showProfile()"><span><i class="fa-regular fa-user"></i></span> </li>
            <li onmouseover="hideProfile()"><span><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"
                            onmouseover="hideWishlist()"></i></a></span></li>
        </div>

    </nav>


    <?php
    include 'user_sidebar.php';

    include 'user_dashboard_container.php';
    include 'user_restaurant_container.php';
    include 'user_menu_container.php';
    include 'user_orders_container.php';
    // print_r($allWishlist);
    ?>

    <section class="cart-list" id="cartlist">
        <div class="triangle-up"></div>
        <div class="main-cart-list">
            <div class="main-cart" id="checkoutKart">



                <!-- <div class="cart-order-list">
                    <div class="cart-order-list-image row">
                        <img src="../images/dishimg/palak-Paneer.jpg" alt="">
                    </div>
                    <div class="cart-order-list-content row">
                        <h3>Palak Paneer</h3>
                        <h4>₹ 220</h4>
                        <button>Remove</button>
                    </div>
                </div> -->

                <?php
                if (count($allWishlist) != 0) {
                    foreach ($allWishlist as $key => $single) {
                        ?>

                        <div class="cart-order-list">
                            <div class="cart-order-list-image row">
                                <img src="<?php echo $single['dish_image'] ?>" alt="">
                            </div>
                            <div class="cart-order-list-content row">
                                <h4>
                                    <?php echo $single['dish_name'] ?>
                                </h4>
                                <h5>₹
                                    <?php echo $single['dish_price'] ?>
                                </h5>
                                <button>Remove</button>
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
            <div class="checkout-btn">
                <button><a href="order_page.php">Checkout</a></button>
            </div>
        </div>
    </section>
    <section class="profile" id="profile">
        <div class="triangle-up"></div>
        <div class="main-cart-list">
            <div class="main-cart">
                <button onclick="showContainer('orders')" style="color:black">My Orders</button>
                <button>View Profile</button>
                <button>Reset Password</button>
            </div>
        </div>
    </section>

</body>
<script src="script.js"></script>
<script>
    let tablink = document.getElementsByClassName('tablink');
    let tabcontent = document.getElementsByClassName('tabcontent');
    // console.log(tabcontent);
    function showContainer(str) {
        // console.log(str);
        if (str == "rest") {
            document.getElementById('rest').style.display = "block";
        } else {
            document.getElementById('rest').style.display = "none";
        }
        if (str == "menu") {
            document.getElementById('menu').style.display = "block";
        } else {
            document.getElementById('menu').style.display = "none";
        }


        for (const ele of tablink) {
            ele.classList.remove("active");
        }
        for (const tab of tabcontent) {
            tab.classList.remove("displayBlock");
        }
        event.currentTarget.classList.add("active");
        document.getElementById(str).classList.add("displayBlock");

    }

    function starFunction(a, b) {
        let select = "." + a + " .star";

        const stars = document.querySelectorAll(select);

        stars.forEach(s => s.classList.remove('activestar'));
        for (let i = 0; i < b; i++) {
            stars[i].classList.add('activestar');
        }
    }

    function showWishlist() {
        hideProfile();
        document.getElementById('cartlist').style.display = "block";
    }
    function hideWishlist() {

        document.getElementById('cartlist').style.display = "none";
    }
    function showProfile() {
        hideWishlist();
        document.getElementById('profile').style.display = "block";
    }
    function hideProfile() {
        document.getElementById('profile').style.display = "none";
    }

    window.addEventListener("click", function () {
        hideProfile();
        hideWishlist();
    });


    function addToWishlist(menuId, userId) {
        const data = {};
        data['id'] = menuId;
        data['user_id'] = userId;




        fetch("addtoWishlist2.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result['status'] == "success") {

                    let records = result['wishlist'];
                    // console.log(records);

                    const container = document.getElementById('checkoutKart');

                    container.innerHTML = '';
                    var html = '';
                    for (const eachrecord of records) {

                        // console.log(eachrecord);

                        html += `
                        <div class="cart-order-list">
                    <div class="cart-order-list-image row">
                        <img src="${eachrecord['dish_image']}" alt="">
                    </div>
                    <div class="cart-order-list-content row">
                        <h4>${eachrecord['dish_name']}</h4>
                        <h5>₹ ${eachrecord['dish_price']}</h5>
                        <button>Remove</button>
                    </div>
                </div>
                        `;

                    }
                    container.innerHTML = html;
                }
                else {
                    console.log("Failed");
                }
            })
            .catch(error => console.log("Error : ", error));
    }

</script>

</html>