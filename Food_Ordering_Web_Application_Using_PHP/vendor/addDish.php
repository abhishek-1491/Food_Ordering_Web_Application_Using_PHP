<?php
session_start();
$conn = new mysqli("localhost", "root", "", "foodapp");

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["dish_image"])) {

    $targetDir = "../images/dishimg/";
    $rest_id = $_POST["rest_id"];
    $rest_name;
    $vendor_id;
    $dish_name = $_POST["name"];
    $dish_desc = $_POST["desc"];
    $dish_price = $_POST["price"];
    $dish_category = $_POST["category"];
    $dish_availability = $_POST["availability"];
   


    if(!file_exists($targetDir)){
        mkdir($targetDir, 0777, true);
    }

    $targetfile = $targetDir . basename($_FILES["dish_image"]["name"]);

    move_uploaded_file($_FILES["dish_image"]["tmp_name"],$targetfile);
    


    //    echo $rest_name." - ". $dish_name . " - " . $dish_desc . " - " .$dish_price . " - ". $dish_category . " - " . $dish_availability;

    $stmt2 = $conn->prepare("SELECT name, vendor_id FROM restaurants WHERE rest_id = ?");
    $stmt2->bind_param("s", $rest_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $resto_name = $result2->fetch_assoc();
    $rest_name = $resto_name["name"];
    $vendor_id = $resto_name["vendor_id"];


    $stmt = "INSERT INTO menu (rest_id,rest_name,vendor_id,dish_name,dish_desc,dish_price,dish_category,dish_image,dish_availability) 
    VALUES (
        '$rest_id',
        '$rest_name',
        '$vendor_id',
        '$dish_name',
        '$dish_desc',
        '$dish_price',
        '$dish_category',
        '$targetfile',
        '$dish_availability'
        
    )";

    if ($conn->query($stmt) == TRUE) {
        
        $updatedDishes = [];
        $stmt3 = $conn->prepare("SELECT *
                FROM menu WHERE vendor_id = ?");
        $stmt3->bind_param("i", $vendor_id);
        $stmt3->execute();
        $result = $stmt3->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $updatedDishes[] = $row;
            }
        } else {
            echo "No results found";
        }

        $_SESSION["vendor_allDishes"] = $updatedDishes;
        // print_r($_SESSION["vendor_allDishes"]);
        
        header('location:dashboard.php');
    } else {
        echo "Error : " . $conn->error;
    }

    $conn->close();


}



?>