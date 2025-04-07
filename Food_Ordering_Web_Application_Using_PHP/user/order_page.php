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
$check = [];
$stmt5 = $conn->prepare("SELECT menu.menu_id,menu.rest_id, menu.dish_name, menu.dish_price, wishlist.quantity FROM menu INNER JOIN wishlist ON menu.menu_id = wishlist.menu_id where wishlist.user_id=?");
$stmt5->bind_param('i', $user_id);
$stmt5->execute();
$result5 = $stmt5->get_result();
if ($result5->num_rows > 0) {
    while ($row = $result5->fetch_assoc()) {
        $check[] = $row;
    }
}

$_SESSION['check'] = $check;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <script src="https://kit.fontawesome.com/35821647e0.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        .hidden {
            display: none;
        }

        .active {
            background-color: black;
        }

        nav {
            width: 100%;
            height: 8vh;
            background-color: aliceblue;
            position: fixed;
            top: 0;

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
                width: 40%;
                height: 100%;
                text-align: right;
                font-size: large;
                float: right;
                margin-right: 4%;

                li {
                    margin-top: 5px;
                    /* background-color: red; */
                    padding: 10px 15px;
                    margin-left: 20px;
                    color: black;
                    border-radius: 10px;

                    a {
                        text-decoration: none;
                        color: black;
                    }
                }

                li:hover {
                    cursor: pointer;
                    background-color: lightsalmon;
                }
            }
        }

        li {
            list-style: none;
        }

        .ordered-product {
            width: 100%;
            height: 90vh;
            margin-top: 8vh;
            /* background-color: red; */
            display: grid;
            grid-template-columns: 30% 70%;

        }

        .ordered-product .dish-ordered {

            width: 90%;
            height: 95%;
            margin-top: 5%;
            margin-left: 10%;
            border-radius: 15px;
            overflow: hidden;
            /* float: left; */
            /* background-color: blue; */
            box-shadow: 0 0 10px rgb(197, 173, 173);

        }

        .ordered-product .dish-ordered h1 {
            background-color: red;
            color: aliceblue;
            text-align: center;
            margin-top: 0;
        }

        .ordered-product .dish-ordered .cart-summary {
            width: 100%;
            height: 54%;
            box-shadow: 0 0 5px rgb(193, 164, 164);
            padding-bottom: 10px;
            overflow: scroll;
            scrollbar-width: thin;
            /* background-color: red; */
        }

        .ordered-product .dish-ordered .cart-summary table {
            width: 100%;
            /* border: 1px solid; */
            text-align: center;

            th {
                color: aliceblue;
                height: 20px;
                padding: 8px;
                position: sticky;
                top: 0;
            }

            td {
                padding: 5px 0px 5px 5px;
            }

            i:hover {
                cursor: pointer;
                border-radius: 20px;
                color: black;
                scale: 1.1;
                background-color: lightblue;
                padding: 5px;
                transition: 0.4s ease;
            }
        }

        .ordered-product .dish-ordered .cart-summary table td:nth-child(4) {
            i {
                font-size: large;
                color: blue;
                transition: 0.4s ease;

            }

            i:hover {
                cursor: pointer;
                border-radius: 20px;
                color: black;
                scale: 1.1;
                background-color: lightblue;
                padding: 5px;
                transition: 0.4s ease;
            }
        }

        .ordered-product .dish-ordered .cart-summary table th:nth-child(1) {
            width: 60%;
            background-color: red;
        }

        .ordered-product .dish-ordered .cart-summary table td:nth-child(1) {
            width: 60%;
            text-align: left;
            /* background-color: red; */
        }

        .ordered-product .dish-ordered .cart-summary table th:nth-child(2) {
            width: 20%;
            background-color: red;
        }

        .ordered-product .dish-ordered .cart-summary table th:nth-child(3) {
            width: 20%;
            background-color: red;
        }

        .ordered-product .dish-ordered .cart-summary table th:nth-child(4) {
            width: 20%;
            background-color: red;
        }

        .ordered-product .dish-ordered .running-total {
            /* background-color: blue; */
            width: 100%;
            height: 22%;
            /* box-shadow: 0 -5px 5px rgb(193, 164, 164); */
        }

        .ordered-product .dish-ordered .running-total table {
            /* border: 1px solid; */
            width: 100%;
            /* text-align: center; */
        }

        .ordered-product .dish-ordered .running-total table td:nth-child(1) {
            /* background-color: red; */
            width: 30%;
            text-align: center;
        }

        .ordered-product .dish-ordered .running-total table td:nth-child(2) {
            /* background-color: red; */
            width: 45%;
            /* text-align: center; */
        }

        .ordered-product .dish-ordered .running-total table td:nth-child(3) {
            /* background-color: red; */
            width: 25%;
            text-align: center;
        }

        .ordered-product .dish-ordered .procced-btn {
            width: 100%;
            height: 10.6%;
            /* background-color: red; */
            box-shadow: 0 -2px 5px rgb(193, 164, 164);
        }

        .ordered-product .dish-ordered .procced-btn button {
            padding: 10px 25px;
            border: none;
            background-color: red;
            margin-top: 10px;
            margin-left: 20%;
            font-size: large;
            color: aliceblue;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }

        .ordered-product .dish-ordered .procced-btn button:hover {
            cursor: pointer;
            background-color: black;
            color: gold;
            scale: 1.1;
            transition: 0.3s ease-in-out;
        }

        .ordered-product .dish-ordered-resto {
            width: 95.5%;
            height: 95%;
            margin-top: 2.1%;
            margin-left: 1%;
            border-radius: 15px;
            overflow: hidden;
            /* background-color: yellow; */
            box-shadow: 0 0 10px rgb(197, 173, 173);
        }

        .ordered-product .dish-ordered-resto .sub-navbar {
            background-color: red;
            width: 100%;
            height: 8.5%;
        }

        .ordered-product .dish-ordered-resto .sub-navbar .sub-navbar-items {
            /* background-color: aqua; */
            width: 50%;
        }

        .ordered-product .dish-ordered-resto .sub-navbar .sub-navbar-items li {
            display: inline-block;
            /* background-color: blue; */
            padding: 8px 15px;
            margin-left: 20px;
            margin-top: 5px;
            font-weight: bold;
            color: aliceblue;
            transition: 0.3s ease;
            border-radius: 15px;
        }

        .ordered-product .dish-ordered-resto .sub-navbar .sub-navbar-items li:hover {
            cursor: pointer;
            color: black;
            transition: 0.3s ease;

            background-color: antiquewhite;
        }

        .dish-ordered-resto .dish-ordered-container {
            /* background-color: yellow; */
            width: 98.7%;
            height: 92.2%;
            overflow: scroll;
            scrollbar-gutter: stable both-edges;
            padding: 10px;
            padding-right: 18px;
            scrollbar-color: red white;

        }

        .dish-ordered-resto .dish-ordered-container .suggested-dishes {
            /* background-color: aliceblue; */
            width: 100%;
            height: 100%;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            /* display: none; */

        }

        .dish-ordered-resto .dish-ordered-container .suggested-dishes .sd-card {
            height: 120px;
            box-shadow: 0 0 10px rgb(197, 173, 173);
            width: 100%;
            background-color: white;

        }

        .sd-card img {
            width: 40%;
            height: 100%;
            float: left;
        }

        .sd-card .sd-card-content {
            width: 56%;
            padding-left: 10px;
            height: 100%;
            float: left;
            position: relative;

            /* background-color: red; */
            h4,
            h3,
            h5 {
                margin: 0;
            }

            h3 {
                margin-top: 5px;
            }

            h5 {
                opacity: 0.6;
            }

            button {
                position: absolute;
                padding: 4px 30px;
                border: none;
                background-color: red;
                color: white;
                font-size: large;
                transition: 0.3s ease-in-out;
                bottom: 5%;
            }

            button:hover {
                cursor: pointer;
                margin-top: 30px;
                background-color: black;
                color: gold;
                scale: 1.1;
                transition: 0.3s ease-in-out;
            }
        }



        .dish-ordered-resto .dish-ordered-container .allDish {
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
            /* background-color: red; */
            /* display: none; */
        }

        .dish-ordered-resto .dish-ordered-container .allDish .sd-card {
            height: 120px;
            box-shadow: 0 0 10px rgb(197, 173, 173);
            width: 100%;
            background-color: white;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal button {
            margin: 10px;
            padding: 8px 12px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        .ok-btn {
            background-color: green;
            color: white;
        }

        .cancel-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo">
            <h1><i class="fa-solid fa-utensils"></i> &nbsp; Food<span style="color:red">Kart</span></h1>
        </div>

        <div class="nav-items">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="">Restaurants</a></li>
            <li><span><i class="fa-regular fa-user"></i>&nbsp; Profile</span> </li>
            <li><span><i class="fa-solid fa-right-from-bracket"></i>&nbsp; <a href="../logout.php">Logout</a></span>
            </li>
        </div>

    </nav>
    <div class="ordered-product">
        <div class="dish-ordered">
            <h1>Cart Summary</h1>
            <div class="cart-summary">

                <table id="menuTable">
                    <thead>
                        <tr>
                            <th>Dish Name</th>
                            <th>Quantity</th>
                            <th>price</th>
                            <th>Action</th>
                            <th style="display:none">Menu ID</th>
                            <th style="display:none">Rest ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($check) != 0) {
                            foreach ($check as $key => $single) {
                                ?>

                                <tr>
                                    <td>
                                        <?php echo $single['dish_name'] ?>
                                    </td>
                                    <td>
                                        <?php

                                        $qt = "quantity_" . $single['menu_id'];
                                        $p = "price_" . $single['menu_id'];
                                        ?>
                                        <i class="fa-solid fa-minus"
                                            onclick="removeQuantity('<?php echo $qt ?>','<?php echo $p ?>','<?php echo $single['dish_price'] ?>')"></i>
                                        &nbsp;
                                        <span id="<?php echo $qt ?>">
                                            <?php echo $single['quantity'] ?>
                                        </span>
                                        &nbsp;<i class="fa-solid fa-plus"
                                            onclick="addQuantity('<?php echo $qt ?>','<?php echo $p ?>','<?php echo $single['dish_price'] ?>')"></i>
                                    </td>
                                    <td id="<?php echo $p ?>" class="valP">
                                        <?php echo $single['dish_price'] * $single['quantity'] ?>
                                    </td>
                                    <td><i class="fa-solid fa-xmark" onclick=removeDish(this)></i></td>
                                    <td style="display:none">
                                        <?php echo $single['menu_id'] ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $single['rest_id'] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <b>No dishes order Yet !</b>
                            <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
            <div class="running-total">
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                        <td id="tol"></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td>Discount(5%)</td>
                        <td id="discount"></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td>Delivery Charges</td>
                        <td id="dcharges"></td>
                    </tr>
                    <tr>
                        <td><b>Total</b></td>
                        <td></td>
                        <td style="border-top: 1px solid;"><b>₹ <span id="gtotal"></span></b></td>
                    </tr>



                </table>
            </div>
            <div class="procced-btn">
                <button id="checkoutBtn">Procced To Payment</button>
            </div>
        </div>
        <div class="dish-ordered-resto">
            <div class="sub-navbar">
                <div class="sub-navbar-items">
                    <li class="tablink active" onclick="show('sd')">Suggested Dishes</li>

                    <li class="tablink " onclick="show('allDish')">All Dishes</li>
                </div>
            </div>
            <div class="dish-ordered-container">
                <div class="sd-container tabcontent " id="sd">
                    <div class="suggested-dishes" id="sd">

                        <?php
                        if (count($allDishes) != 0) {
                            foreach ($allDishes as $key => $single) {
                                ?>

                                <div class="sd-card">
                                    <img src="<?php echo $single['dish_image'] ?>" alt="">
                                    <div class="sd-card-content">
                                        <h3>
                                            <?php echo $single['dish_name'] ?>
                                        </h3>
                                        <h4>₹
                                            <?php echo $single['dish_price'] ?>
                                        </h4>
                                        <h5>
                                            <?php echo $single['rest_name'] ?>
                                        </h5>
                                        <button>Add</button>
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
                </div>


                <div class="allDish-container tabcontent hidden" id="allDish">
                    <div class="allDish">
                        <?php
                        if (count($allDishes) != 0) {
                            foreach ($allDishes as $key => $single) {
                                ?>

                                <div class="sd-card">
                                    <img src="<?php echo $single['dish_image'] ?>" alt="">
                                    <div class="sd-card-content">
                                        <h3>
                                            <?php echo $single['dish_name'] ?>
                                        </h3>
                                        <h4>₹
                                            <?php echo $single['dish_price'] ?>
                                        </h4>
                                        <h5>
                                            <?php echo $single['rest_name'] ?>
                                        </h5>
                                        <button>Add</button>
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
                </div>
            </div>
        </div>
    </div>
    <div id="customAlert" class="modal">
        <div class="modal-content">
            <p id="alertMessage">Are you sure you want to continue?</p>
            <button class="ok-btn" onclick="closeAPP()">Yes</button>
            <button class="cancel-btn" onclick="closeAlert()">No</button>
        </div>
    </div>
</body>
<script>
    let tablinks = document.getElementsByClassName('tablink');
    let tabcontents = document.getElementsByClassName('tabcontent');

    function show(str) {
        for (const ele of tablinks) {
            ele.classList.remove("active");
        }
        for (tab of tabcontents) {
            tab.classList.add("hidden");
        }
        event.currentTarget.classList.add("active");
        document.getElementById(str).classList.remove("hidden");
    }

    function total() {
        let prices = document.querySelectorAll('.valP');
        let discount = document.getElementById('discount');
        let dcharges = document.getElementById('dcharges');
        let gtotal = document.getElementById('gtotal');



        let grandTotal = 0;

        prices.forEach(element => {
            grandTotal += Number(element.innerHTML);
        });

        let tol = document.getElementById('tol');
        tol.textContent = grandTotal;

        let dis = grandTotal * 5 / 100;
        let deliveryCharges;


        if (grandTotal > 40) {
            deliveryCharges = 40;
        }
        else {
            deliveryCharges = 0;
        }

        discount.innerText = "-" + dis;
        dcharges.innerText = "+" + deliveryCharges;
        gtotal.innerText = grandTotal - dis + deliveryCharges;
    }
    total();

    function addQuantity(quantity, price, dishPrice) {
        let a = document.getElementById(quantity);
        let b = document.getElementById(price);

        a.textContent = Number(a.textContent) + 1;
        b.textContent = Number(b.textContent) + Number(dishPrice);

        total();


    }
    function removeQuantity(quantity, price, dishPrice) {
        let a = document.getElementById(quantity);
        let b = document.getElementById(price);

        a.textContent = Number(a.textContent) - 1;
        b.textContent = Number(b.textContent) - Number(dishPrice);

        total();

    }
    function removeDish(button) {

        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);

        total();
    }
    function showAlert() {
        document.getElementById("alertMessage").innerText = "Did You Really Want to cancel This Delisious Dish";
        document.getElementById("customAlert").style.display = "block";
    }

    function closeAlert() {
        document.getElementById("customAlert").style.display = "none";
    }
    function closeAPP() {
        closeAlert();
        document.getElementById('demo').innerText = "Success";

    }


    document.getElementById("checkoutBtn").addEventListener("click", () => {
        const tableRows = document.querySelectorAll("#menuTable tbody tr");
        const totalPayment = document.getElementById('gtotal').innerText;
        let menuIDs = [];
        let restIDs = [];
        let quantity = [];
        tableRows.forEach(row => {
            const columns = row.children;
            menuIDs.push(
                Number(columns[4].textContent)
            );
            restIDs.push(
                Number(columns[5].textContent)
            );
            quantity.push(
                Number(columns[1].textContent)
            );

        });

        console.log(menuIDs);
        console.log(restIDs);
        console.log(quantity);

        localStorage.setItem("checkoutId" , JSON.stringify(menuIDs));
        localStorage.setItem("restIDs" , JSON.stringify(restIDs));
        localStorage.setItem("quantity" , JSON.stringify(quantity));
        localStorage.setItem("totalpayment",JSON.stringify(totalPayment));
        window.location.href = "payment.html";
        

    });
</script>

</html>