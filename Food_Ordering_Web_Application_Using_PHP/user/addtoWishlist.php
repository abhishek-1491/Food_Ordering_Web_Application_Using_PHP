<?php
$conn = new mysqli("localhost", "root", "", "foodapp");

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$jsonData = file_get_contents("php://input");

// Convert JSON to PHP array
$data = json_decode($jsonData, true);


$id = $data["id"];
$userId = $data["user_id"];


$sql = "INSERT INTO wishlist (menu_id,user_id) VALUES ('$id','$userId')";

if ($conn->query($sql) === TRUE) {

    $allWishlist = [];
    $stmt = $conn->prepare("SELECT * FROM menu WHERE menu_id IN (SELECT menu_id FROM wishlist WHERE user_id = ?)");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $allWishlist[] = $row;
        }
    } else {
        echo "No results found";
    }

    // $_SESSION['allWishlist'] = $allWishlist;



    echo json_encode(["status" => "success", "Data Stored Successfully","wishlist" => $allWishlist]);


} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
$conn->close();





?>