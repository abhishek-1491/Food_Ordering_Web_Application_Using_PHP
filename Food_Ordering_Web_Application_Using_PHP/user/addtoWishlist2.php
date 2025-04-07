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

// Check if the item exists in the wishlist
$stmt = $conn->prepare("SELECT quantity FROM wishlist WHERE menu_id = ? AND user_id =?");
$stmt->bind_param("ii", $id,$userId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // If item exists, update quantity
    $newQuantity = $row['quantity'] + 1;
    $stmt = $conn->prepare("UPDATE wishlist SET quantity = ? WHERE menu_id = ?");
    $stmt->bind_param("ii", $newQuantity, $id);
} else {
    // If item does not exist, insert new record
    $stmt = $conn->prepare("INSERT INTO wishlist (menu_id, user_id, quantity) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $id, $userId);
}

// Execute the query and check for success
if ($stmt->execute()) {
    $allWishlist = [];
    $stmt = $conn->prepare("SELECT menu_id,dish_name,dish_price,dish_image FROM menu WHERE menu_id IN (SELECT menu_id FROM wishlist WHERE user_id = ?)");
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
    $_SESSION['allWishlist'] = $allWishlist;
    echo json_encode(["status" => "success", "Data Stored Successfully","wishlist" => $allWishlist]);

} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
$conn->close();





?>