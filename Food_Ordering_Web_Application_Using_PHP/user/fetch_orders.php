<?php


$conn = new mysqli("localhost", "root", "", "foodapp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user']['user_id'] ?? null;
if (!$user_id) {
    die("Unauthorized access");
}

$allOrders = [];

$orderQuery = $conn->prepare("SELECT invoice_no, dish_id, total_payment, status, ordered_date FROM orders WHERE user_id = ?");
$orderQuery->bind_param("i", $user_id);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

while ($orderRow = $orderResult->fetch_assoc()) {
    $invoice_no = $orderRow["invoice_no"];
    $dishIds = json_decode($orderRow["dish_id"], true);

    if (!is_array($dishIds) || empty($dishIds)) {
        continue;
    }

    $placeholders = implode(",", array_fill(0, count($dishIds), "?"));
    $dishQuery = $conn->prepare("SELECT dish_name FROM menu WHERE menu_id IN ($placeholders)");

    $types = str_repeat("i", count($dishIds));
    $dishQuery->bind_param($types, ...$dishIds);
    $dishQuery->execute();
    $dishResult = $dishQuery->get_result();

    $dishes = [];
    while ($dishRow = $dishResult->fetch_assoc()) {
        $dishes[] = $dishRow["dish_name"];
    }

    $allOrders[] = [
        "invoice_no" => $invoice_no,
        "status" => $orderRow["status"],
        "total_payment" => $orderRow["total_payment"],
        "ordered_date" => $orderRow["ordered_date"],
        "dishes" => $dishes
    ];
}

foreach ($data as $record) {
    echo "Invoice No: " . $record['invoice_no'] . "<br>";
    echo "Total Payment: " . $record['total_payment'] . "<br>";
    echo "Ordered Date: " . $record['ordered_date'] . "<br>";
    echo "Dishes: " . implode(", ", $record['dishes']) . "<br>";
    echo "--------------------------------<br>";
}

header('Content-Type: application/json');
echo json_encode($allOrders);
?>
