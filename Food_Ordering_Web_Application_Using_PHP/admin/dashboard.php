<?php
session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['allUsers'])) {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user'];
$allUsers = $_SESSION['allUsers'];
$allResto = $_SESSION['admin_allResto'];
$allDishes = $_SESSION['admin_allDishes'];

$users = [];
$vendors = [];
foreach ($allUsers as $key => $single) {
    if ($single["role"] == "user") {
        $users[] = $single;
    } else if ($single["role"] == "vendor") {
        $vendors[] = $single;
    }
}

// print_r($allResto);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
                color: white;
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

        .row {
            float: left;
        }

        .users {
            width: 85%;
            height: 92vh;
            position: fixed;
            /* background-color: aquamarine; */
            top: 8vh;
            left: 15%;

            display: none;
        }

        .users .users-content {
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

        .users .users-content .users-table {
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
            overflow: scroll;

            h1 {
                width: 110.8%;
                height: 35px;
                border-radius: 5px 5px 0 0;
                background-color: blue;
                padding: 5px;
            }
        }

        .restaurant .restaurant-content .restaurant-table {
            width: 111.8%;
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

        .vendor {
            width: 85%;
            height: 92vh;
            position: fixed;
            /* background-color: aquamarine; */
            top: 8vh;
            left: 15%;

            display: none;
        }

        .vendor .vendor-content {
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

        .vendor .vendor-content .vendor-table {
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

        nav {
            width: 100%;
            height: 8vh;
            background-color: aliceblue;
        }
    </style>
</head>

<body>

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
            <li class="tablink" onclick="show('users')">Users</li>
            <li class="tablink" onclick="show('restaurant')">Restaurant</li>
            <li class="tablink" onclick="show('vendor')">Vendors</li>
            <li class="tablink" onclick="show('menu')">Menu</li>
            <li class="tablink" onclick="show('orders')">Orders</li>

        </div>
    </section>
    <section class="dashboard tabcontent displayBlock" id="dashboard">
        <div class="dashboard-content">
            <h1>Admin Dashboard</h1>

            <div class="dashboard-cards">
                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4><?php echo count($allResto) ?></h4>
                        <h2>Restaurant</h2>
                    </div>
                </div>
                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4>
                            <?php echo count($allDishes) ?>
                        </h4>
                        <h2>Dishes</h2>
                    </div>
                </div>
                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4>
                            <?php echo count($users) ?>
                        </h4>
                        <h2>Users</h2>
                    </div>
                </div>
                <div class="card row">
                    <div class="row card-img">Image</div>
                    <div class="row card-content">
                        <h4>
                            <?php echo count($vendors) ?>
                        </h4>
                        <h2>Vendors</h2>
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

    <section class="users tabcontent " id="users">
        <div class="users-content">
            <h1>All Users</h1>
            <div class="users-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Profile Pic</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    foreach ($users as $key => $singleuser) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>
                            <td>
                                <?php echo $singleuser["name"] ?>
                            </td>
                            <td>
                                <?php echo $singleuser["email"] ?>
                            </td>
                            <td></td>
                            <td></td>

                            <td>
                                <?php echo $singleuser["role"] ?>
                            </td>
                            <td></td>
                            <td><button>Edit</button> <button>Delete</button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
    <section class="restaurant tabcontent " id="restaurant">
        <div class="restaurant-content">
            <h1>All Restaurants</h1>
            <div class="restaurant-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Restaurant Image</th>
                        <th>Owner Name</th>
                        <th>Restaurant Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Opening Time</th>
                        <th>Closing Time</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    foreach ($allResto as $key => $singleresto) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>
                            <td>Image</td>
                            <td>
                                <?php echo $singleresto["vendor_name"] ?>
                            </td>
                            <td>
                                <?php echo $singleresto["name"] ?>
                            </td>
                            <td>
                                <?php echo $singleresto["address"] ?>
                            </td>
                            <td>
                                <?php echo $singleresto["phone"] ?>
                            </td>
                            <td>
                                <?php echo $singleresto["email"] ?>
                            </td>
                            <td>
                                <?php echo date("H:i", strtotime($singleresto["o_time"])) ?> AM
                            </td>
                            <td>
                                <?php echo date("H:i", strtotime($singleresto["c_time"])) ?> PM
                            </td>
                            <td><button>Edit</button> <button>Delete</button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>

    <section class="vendor tabcontent " id="vendor">
        <div class="vendor-content">
            <h1>All vendors</h1>
            <div class="vendor-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile No.</th>
                        <th>Profile Image</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    foreach ($vendors as $key => $singleuser) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>

                            <td>
                                <?php echo $singleuser["name"] ?>
                            </td>
                            <td>
                                <?php echo $singleuser["email"] ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td><button>Edit</button> <button>Delete</button></td>
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
            <h1>All Dishes</h1>
            <div class="menu-table">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Name</th>
                        <th>Restaurant Name </th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>price</th>
                        <th>Dish Image</th>
                        <th>Availability</th>
                    </tr>
                    <?php
                    foreach ($allDishes as $key => $singledish) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>

                            <td>
                                <?php echo $singledish["dish_name"] ?>
                            </td>
                            <td>
                                <?php echo $singledish["rest_name"] ?>
                            </td>
                            <td>
                                <?php echo $singledish["dish_category"] ?>
                            </td>
                            <td>
                                <?php echo $singledish["dish_desc"] ?>
                            </td>
                            <td>
                                <?php echo $singledish["dish_price"] ?>
                            </td>

                            <td></td>
                            <td>
                                <?php echo $singledish["dish_availability"] ?>
                            </td>
                            
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
</body>
<script>
    let tablink = document.getElementsByClassName('tablink');
    let tabcontent = document.getElementsByClassName('tabcontent');

    function show(str) {
        for (const ele of tablink) {
            ele.classList.remove("active");
        }
        for (tab of tabcontent) {
            tab.classList.remove("displayBlock");
        }
        event.currentTarget.classList.add("active");
        document.getElementById(str).classList.add("displayBlock");
    }

</script>

</html>