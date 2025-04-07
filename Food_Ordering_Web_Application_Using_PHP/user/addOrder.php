<?php
session_start();


// Check if orderId is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderId"])) {
    
    
    $invoice_no = "#". mt_rand(100000, 999999);;
    $orderIdString = $_POST["orderId"];
    $restIdString = $_POST["restId"];
    $quantityString = $_POST["quantity"];
    $totalPayment = $_POST["totalPayment"];
    // Convert comma-separated string back into an array
    
    $orderArray = json_decode($orderIdString, true);
    $restArray = json_decode($restIdString,true);
    $quantityArray = json_decode($quantityString,true);

    
    $userID = $_SESSION['user']['user_id'];
    // Database connection (Replace with your actual credentials)
    $conn = new mysqli("localhost", "root", "", "foodapp");

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    foreach ($orderArray as $value) {
        $sql = "DELETE FROM wishlist WHERE menu_id = $value AND user_id= $userID";
        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error; // Show error message if insertion fails
            exit(); // Stop execution on failure
        }else{
            echo "Data deleted successfully";
        }
    }

    $sql = "INSERT INTO orders (invoice_no,user_id,dish_id,rest_id,quantity,total_payment) VALUES ('$invoice_no','$userID','$orderIdString','$restIdString','$quantityString','$totalPayment')";
    if (!$conn->query($sql)) {
        echo "Error: " . $conn->error; 
        exit(); 
    }else{
        echo "Data stored in database";
    }

    $conn->close();

    
    header("Location: ../user/dashboard.php");
    exit();
} else {
    echo "No order ID received!";
}
?>