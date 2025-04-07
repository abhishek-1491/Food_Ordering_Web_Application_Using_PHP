<?php
session_start();
$conn = new mysqli("localhost", "root", "", "foodapp");

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $username = $_POST["username"];
    $password = $_POST["password"];


    echo $username;
    echo "<br>";
    echo $password;

    echo "<br>";

    $stmt10 = $conn->prepare("SELECT * FROM users WHERE user_name = ?");
    $stmt10->bind_param("s", $username);
    $stmt10->execute();
    $result10 = $stmt10->get_result();
    $user = $result10->fetch_assoc();

    print_r($user."nhi");
    $userId = $user['user_id'];
    echo $userId."Abhi";
    if (password_verify($password, $user['password'])) {

        $condition = $user["role"];

        switch ($condition) {
            case 'admin':

                $username = $user["user_name"];
                $allResto = [];
                $allDishes = [];


                $stmt2 = $conn->prepare("SELECT user_name,name,email,role FROM users WHERE user_name != ?");
                $stmt2->bind_param("s", $username);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $allUsers = [];
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $allUsers[] = $row;
                    }
                } else {
                    echo "No results found";
                }

                $stmt = $conn->prepare("SELECT *
                FROM restaurants");
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $allResto[] = $row;
                    }
                } else {
                    echo "No results found";
                }

                $stmt3 = $conn->prepare("SELECT *
                FROM menu");
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                if ($result3->num_rows > 0) {
                    while ($row = $result3->fetch_assoc()) {
                        $allDishes[] = $row;
                    }
                } else {
                    echo "No results found";
                }


                $_SESSION['user'] = $user;
                $_SESSION["allUsers"] = $allUsers;
                $_SESSION["admin_allResto"] = $allResto;
                $_SESSION["admin_allDishes"] = $allDishes;

                print_r($allDishes);

                header('location:admin/dashboard.php');
                break;

            case 'vendor':
                $allResto = [];
                $allDishes = [];
                $allOrders = [];

                $vendor_id = $user["user_id"];
                // $stmt2 = $conn->prepare("SELECT vendor_id, name, address, 
                // TIME_FORMAT(o_time, '%H:%i') AS o_time, 
                // TIME_FORMAT(c_time, '%H:%i') AS c_time 
                // FROM restaurants WHERE vendor_id = ?");
                $stmt2 = $conn->prepare("SELECT *
                FROM restaurants WHERE vendor_id = ?");
                $stmt2->bind_param("i", $vendor_id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $allResto[] = $row;
                    }
                } else {
                    echo "No results found";
                }

                $stmt = $conn->prepare("SELECT *
                FROM menu WHERE vendor_id = ?");
                $stmt->bind_param("i", $vendor_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $allDishes[] = $row;
                    }
                } else {
                    echo "No results found";
                }




                $_SESSION['vendor'] = $user;
                $_SESSION['vendor_allResto'] = $allResto;
                $_SESSION['vendor_allDishes'] = $allDishes;
                // print_r($allDishes);
                header('location:vendor/dashboard.php');
                break;

            case 'user':
                // echo "Inside user code<br>";

                $allResto = [];
                $allDishes = [];

                print_r($user);
                $stmt3 = $conn->prepare("SELECT *
                FROM menu");
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                if ($result3->num_rows > 0) {
                    while ($row = $result3->fetch_assoc()) {
                        $allDishes[] = $row;
                    }
                } else {
                    echo "No results found";
                }

                $stmt = $conn->prepare("SELECT *
                FROM restaurants");
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $allResto[] = $row;
                    }
                } else {
                    echo "No results found";
                }



                // $top2 = [];
                // $stmt5 = $conn->prepare("SELECT menu.dish_image,menu.dish_name,menu.dish_desc,menu.rest_name,menu.dish_price FROM menu JOIN (SELECT menu_id from wishlist GROUP BY menu_id ORDER BY SUM(quantity) DESC LIMIT 2) AS top_dish ON menu.menu_id = top_dish.menu_id");

                // $stmt5->execute();
                // $result5 = $stmt5->get_result();
                // if ($result5->num_rows > 0) {
                //     while ($row = $result5->fetch_assoc()) {
                //         $top2[] = $row;
                //     }
                // } else {
                //     echo "No results found";
                // }

                // $_SESSION['top2'] = $top2;

               
                $_SESSION['user'] = $user;
                $_SESSION['user_allResto'] = $allResto;
                $_SESSION['user_allDishes'] = $allDishes;


                header('location:user/dashboard.php');
                break;


        }

    }
    else{
        echo "Username and password incorrect";
    }

}



?>