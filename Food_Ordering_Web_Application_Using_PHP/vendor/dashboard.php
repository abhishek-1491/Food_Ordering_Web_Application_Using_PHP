<?php
session_start();

if (!isset($_SESSION['vendor']) && !isset($_SESSION['allResto']) && !isset($_SESSION['allDishes'])) {
    header("Location: ../index.php");
    exit();
}

$vendor = $_SESSION['vendor'];
$allResto = $_SESSION['vendor_allResto'];
$allDishes = $_SESSION['vendor_allDishes'];

// print_r($allDishes);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Panel</title>
    <script src="https://kit.fontawesome.com/35821647e0.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            margin: 0;
            padding: 0%;
            font-family: "Poppins", sans-serif;
        }

        .sidebar {
            width: 15%;
            height: 92vh;
            /* background-color: rgb(55, 45, 45); */
            background-color: aqua;
            position: fixed;
            top: 8vh;


            .sidebar-list {
                /* background-color: red; */
                width: 80%;
                margin-top: 20px;
                margin-left: 10%;


                li {
                    list-style: none;
                    width: 80%;
                    padding: 15px;
                    margin-top: 10px;
                    transition: 0.5s ease-in-out;
                    /* background-color: black; */
                }

                li:hover {
                    transition: 0.5s ease-in-out;

                    background-color: antiquewhite;
                    cursor: pointer;
                }
            }
        }

        .active {
            background-color: aquamarine;
        }

        .displayBlock {
            display: block;
        }

        nav {
            width: 100%;
            height: 8vh;
            background-color: aliceblue;
        }

        .row {
            float: left;
        }

        .dashboard {
            width: 85%;
            height: 92vh;
            position: fixed;
            /* background-color: aquamarine; */
            top: 8vh;
            left: 15%;

            display: none;

        }

        .dashboard .dashboard-content {
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

        .dashboard .dashboard-content .dashboard-cards {
            /* background-color: aliceblue; */

            gap: 10px;
        }

        .dashboard .dashboard-content .dashboard-cards .card {
            /* background-color: blue; */
            padding: 10px;
            width: 27%;
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

        .restaurant {
            width: 85%;
            height: 92vh;
            position: fixed;
            /* background-color: aquamarine; */
            top: 8vh;
            left: 15%;

            display: none;
        }

        .restaurant .restaurant-content {
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

            button {
                padding: 9px 20px;
                margin-left: 80%;
                margin-top: 20px;
                border: none;
                border-radius: 5px;
                background-color: blue;
                font-size: large;
                color: white;
                transition: 0.3s ease-in-out;
            }

            button:hover {
                cursor: pointer;
                transition: 0.3s ease-in-out;
                background-color: black;
            }

        }

        .restaurant .restaurant-content .restaurant-table {
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

                img {
                    width: 60px;
                    height: 60px;
                    box-shadow: 0 0 10px black;
                }
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

        .menu {
            width: 85%;
            height: 92vh;
            position: fixed;
            /* background-color: aquamarine; */
            top: 8vh;
            left: 15%;

            display: none;
        }

        .menu .menu-content {
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

            button {
                padding: 9px 20px;
                margin-left: 85%;
                margin-top: 20px;
                border: none;
                border-radius: 5px;
                background-color: blue;
                font-size: large;
                color: white;
                transition: 0.3s ease-in-out;
            }

            button:hover {
                cursor: pointer;
                transition: 0.3s ease-in-out;
                background-color: black;
            }
        }

        .menu .menu-content .menu-table {
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
            background-color: aquamarine;
        }

        .displayBlock {
            display: block;
        }

        .addResto {
            position: absolute;
            width: 30%;
            height: 80vh;
            left: 25%;
            top: 13.5%;
            border-radius: 15px;
            overflow: scroll;
            scrollbar-width: none;
            box-shadow: 0 0 10px rgb(197, 170, 170);
            background-color: whitesmoke;
            display: none;
        }

        .addResto .container {
            width: 98.5%;
            height: 100%;
            padding: 5px;
            /* background-color: red; */
            position: relative;


            h1 {
                text-align: center;
                font-size: 35px;
                margin-top: 50px;
            }

            i {
                position: fixed;
                /* float: left; */
                margin-right: 5px;
                font-size: 30px;
                /* background-color: black;
                color: white; */
                color: blue;
                padding: 5px;
            }

            i:hover {
                cursor: pointer;
            }

            form {
                /* border: 1px solid; */
                width: 72%;
                margin-top: -30px;
                margin-left: 10%;
                padding: 20px;
                font-size: large;

                input {
                    width: 100%;
                    height: 30px;
                    margin-top: 5px;
                    margin-bottom: 10px;
                    border: none;
                    box-shadow: 0 0 10px rgb(212, 192, 192);
                }

                input[type="file"] {
                    box-shadow: none;
                    background: transparent;
                }

                button {
                    width: 101%;
                    padding: 10px;
                    border: none;
                    background-color: blue;
                    color: white;
                    transition: 0.3s ease-in-out;
                    font-size: large;
                    /* height: 40px; */
                }

                button:hover {
                    cursor: pointer;
                    background-color: black;
                    transition: 0.3s ease-in-out;
                }
            }
        }

        .addDish {
            position: absolute;
            width: 30%;
            height: 80vh;
            left: 25%;
            top: 13.5%;
            border-radius: 15px;
            overflow: scroll;
            scrollbar-width: none;
            box-shadow: 0 0 10px rgb(197, 170, 170);
            background-color: whitesmoke;
            display: none;
        }

        .addDish .container {
            width: 98.5%;
            height: 100%;
            padding: 5px;
            /* background-color: red; */
            position: relative;


            h1 {
                text-align: center;
                font-size: 35px;
                margin-top: 50px;
            }

            i {
                position: fixed;
                /* float: left; */
                margin-right: 5px;
                font-size: 30px;
                /* background-color: black;
                color: white; */
                color: blue;
                padding: 5px;
            }

            i:hover {
                cursor: pointer;
            }

            form {
                /* border: 1px solid; */
                width: 72%;
                margin-top: -30px;
                margin-left: 10%;
                padding: 20px;
                font-size: large;

                input {
                    width: 100%;
                    height: 30px;
                    margin-top: 5px;
                    margin-bottom: 10px;
                    border: none;
                    box-shadow: 0 0 10px rgb(212, 192, 192);
                }

                select {
                    width: 100%;
                    height: 30px;
                    font-size: large;
                    margin-top: 5px;
                    margin-bottom: 10px;
                    border: none;
                    box-shadow: 0 0 10px rgb(212, 192, 192);
                }

                input[type="file"] {
                    box-shadow: none;
                    background: transparent;
                }

                button {
                    width: 101%;
                    padding: 10px;
                    border: none;
                    background-color: blue;
                    color: white;
                    transition: 0.3s ease-in-out;
                    font-size: large;
                    /* height: 40px; */
                }

                button:hover {
                    cursor: pointer;
                    background-color: black;
                    transition: 0.3s ease-in-out;
                }
            }
        }
    </style>
</head>

<body id="body">
    <nav>
        <div class="logo">
            LOGO
        </div>
        <div class="logout-btn">
            <button><a href="../logout.php">Logout</a></button>
        </div>
    </nav>
    <section class="sidebar">
        <div class="sidebar-list">
            <label for="">HOME</label>
            <li class="tablink active" onclick="show('dashboard')">Dashboard</li>
            <label for="">LOG</label>

            <li class="tablink" onclick="show('restaurant')">Restaurant</li>

            <li class="tablink" onclick="show('menu')">Menu</li>
            <li class="tablink" onclick="show('orders')">Orders</li>

        </div>
    </section>

    <section class="dashboard tabcontent displayBlock" id="dashboard">
        <div class="dashboard-content">
            <h1>Vendor Dashboard</h1>

            <div class="dashboard-cards">
                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4>
                            <?php echo count($allResto) ?>
                        </h4>
                        <h2>Restaurant</h2>
                    </div>
                </div>
                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4><?php echo count($allDishes) ?></h4>
                        <h2>Dishes</h2>
                    </div>
                </div>

                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4>5</h4>
                        <h2>Orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="restaurant tabcontent " id="restaurant">
        <div class="restaurant-content">
            <button onclick="addResto()"><i class="fa-solid fa-plus"></i> Add Restaurant</button>
            <h1>All Restaurants</h1>
            <div class="restaurant-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Image</th>
                        <th>Restaurant Name</th>
                        <th>Address</th>
                        <th>Mobile No.</th>
                        <th>Email</th>
                        <th>Opening Time</th>
                        <th>Closing Time</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    // print_r($allResto);
                    foreach ($allResto as $key => $singleResto) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>
                            <td>
                                Image
                            </td>
                            <td>
                                <?php echo $singleResto["name"] ?>
                            </td>
                            <td>
                                <?php echo $singleResto["address"] ?>
                            </td>
                            <td>
                                <?php echo $singleResto["phone"] ?>
                            </td>
                            <td>
                                <?php echo $singleResto["email"] ?>
                            </td>
                            <td>
                                <?php echo date("H:i", strtotime($singleResto["o_time"])) ?> AM
                            </td>
                            <td>
                                <?php echo date("H:i", strtotime($singleResto["c_time"])) ?> PM
                            </td>
                            <td>Edit || Delete</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
    <section class="menu tabcontent " id="menu">
        <div class="menu-content">
            <button onclick="addDish()"><i class="fa-solid fa-plus"></i> Add Dish</button>
            <h1>All Dishes</h1>
            <div class="menu-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Dish Image</th>
                        <th>Dish Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // print_r($allResto);
                    foreach ($allDishes as $key => $singleDish) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>
                            <td>
                            Image
                            </td>
                            <td>
                                <?php echo $singleDish["dish_name"] ?>
                            </td>
                            <td>
                                <?php echo $singleDish["dish_category"] ?>
                            </td>
                            <td>
                                <?php echo $singleDish["dish_desc"] ?>
                            </td>
                            <td>
                                <?php echo $singleDish["dish_price"] ?>
                            </td>
                            <td>
                                <?php echo $singleDish["dish_availability"] ?>
                            </td>
                           
                            <td>Edit || Delete</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
    <section class="orders tabcontent " id="orders">
        <div class="orders-content">
            <h1>All Orders</h1>
            <div class="orders-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>

                </table>
            </div>
        </div>
    </section>

    <section class="addResto" id="addResto">
        <div class="container">
            <i class="fa-solid fa-xmark" onclick="closeAddResto()"></i>

            <h1>Add Restaurant</h1>
            <form action="addResto.php" method="POST" enctype="multipart/form-data">

                <input type="text" name="vendor_id" hidden value="<?php echo $vendor['user_id'] ?>"><br>
                <input type="text" name="vendor_name" hidden value="<?php echo $vendor['name'] ?>"><br>

                <label for="">Enter Restaurant Name : </label><br>
                <input type="text" name="r_name" required><br>


                <label for="">Enter Restaurant Address : </label><br>
                <input type="text" name="r_address" required><br>

                <label for="">Enter Restaurant Contact No : </label><br>
                <input type="number" name="r_mobile" required><br>

                <label for="">Enter Restaurant Email : </label><br>
                <input type="email" name="r_email" required><br>

                <label for="">Opening Time :</label><br>
                <input type="time" name="o_time" id="" required><br>

                <label for="">Closing Time :</label><br>
                <input type="time" name="c_time" id="" required><br>

                <label for="">Add Restaurant Image : </label><br>
                <input type="file" name="image"><br>
                <br>

                <button onclick="closeAddResto()">Submit</button>
            </form>
        </div>
    </section>
    <section class="addDish" id="addDish">
        <div class="container">
            <i class="fa-solid fa-xmark" onclick="closeAddDish()"></i>

            <h1>Add Dish</h1>
            <form action="addDish.php" method="POST" enctype="multipart/form-data">

                <label for="">Select Restaurant Name : </label><br>
                <!-- <input type="text" name="r_name" required><br> -->
                <!-- <?php print_r($allResto); ?> -->
                <select name="rest_id" id="">
                    <option value="">---- Select Restaurant ----</option>
                    <?php
                    foreach ($allResto as $single) {
                        ?>
                        <option value="<?php echo $single['rest_id'] ?>">
                            <?php echo $single["name"] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select><br>

                <label for="">Enter Dish Name : </label><br>
                <input type="text" name="name" required><br>

                <label for="">Enter Dish Description : </label><br>
                <input type="text" name="desc" required><br>

                <label for="">Enter Dish Price : </label><br>
                <input type="text" name="price" required><br>

                <label for="">Enter Dish Category :</label><br>
                <input type="text" name="category" id="" required><br>

                <label for="">Dish Availability :</label><br>
                <select name="availability" id="">
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select><br>

                <label for="">Add Dish Image : </label><br>
                <input type="file" name="dish_image"><br>
                <br>

                <button onclick="closeAddResto()">Submit</button>
            </form>
        </div>
    </section>
</body>
<script>
    let tablink = document.getElementsByClassName('tablink');
    let tabcontent = document.getElementsByClassName('tabcontent');

    function show(str) {
        document.getElementById('addResto').style.display = "none";
        document.getElementById('addDish').style.display = "none";
        for (const ele of tablink) {
            ele.classList.remove("active");
        }
        for (tab of tabcontent) {
            tab.classList.remove("displayBlock");
        }
        event.currentTarget.classList.add("active");
        document.getElementById(str).classList.add("displayBlock");
    }

    function addResto() {
        document.getElementById('addResto').style.display = "block";
    }
    function closeAddResto() {
        document.getElementById('addResto').style.display = "none";
    }

    function addDish() {
        document.getElementById('addDish').style.display = "block";
    }
    function closeAddDish() {
        document.getElementById('addDish').style.display = "none";
    }

</script>

</html>