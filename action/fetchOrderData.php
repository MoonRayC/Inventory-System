<?php
include 'config.php';
$orderID = isset($_GET['orderID']) ? $_GET['orderID'] : null;

if ($orderID) {

    $orderStmt = $pdo->prepare("SELECT * FROM orders WHERE orderID = ?");
    $orderStmt->execute([$orderID]);
    $orderDetails = $orderStmt->fetch(PDO::FETCH_ASSOC);

     $itemsStmt = $pdo->prepare("
     SELECT oi.*, p.name as productName
     FROM orderedItems oi
     JOIN products p ON oi.productID = p.productID
     WHERE oi.orderID = ?
    ");
    $itemsStmt->execute([$orderID]);
    $orderedItems = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [
        'orderDetails' => $orderDetails,
        'orderedItems' => $orderedItems,
    ];

    if ($orderDetails) {
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Order not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
