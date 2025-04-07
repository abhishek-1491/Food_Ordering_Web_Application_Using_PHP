<?php
session_start();
$conn = new mysqli("localhost", "root", "", "foodapp");

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {


    $vendor_id = $_POST["vendor_id"];
    $vendor_name = $_POST["vendor_name"];
    $r_name = $_POST["r_name"];
    $r_address = $_POST["r_address"];
    $r_mobile = $_POST["r_mobile"];
    $r_email = $_POST["r_email"];

    $o_time = date("H:i", strtotime($_POST['o_time']));
    $c_time = date("H:i", strtotime($_POST['c_time']));
    $r_image = $_POST["image"];



    $sql = "INSERT INTO restaurants (vendor_id, vendor_name, name, address,phone,email, o_time, c_time) 
    VALUES (
        '$vendor_id',
        '$vendor_name',
        '$r_name',
        '$r_address',
        '$r_mobile',
        '$r_email',
        '$o_time',
        '$c_time'
    )";

    if ($conn->query($sql) == TRUE) {
        echo "Record Added Successfully";



        header('location:dashboard.php');
    } else {
        echo "Error : " . $conn->error;
    }
    $conn->close();


}



?>