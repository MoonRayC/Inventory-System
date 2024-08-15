<?php
include 'config.php';

$query = "SELECT DATE(orderDate) AS orderDay, SUM(grandTotal) AS dailyRevenue FROM orderHistory GROUP BY orderDay";
$statement = $pdo->query($query);
$dailyData = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');  
echo json_encode($dailyData);
?>