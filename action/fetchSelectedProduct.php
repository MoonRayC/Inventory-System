<?php

require_once 'config.php';

$productID = $_POST['productID'];

$sql = "SELECT productID, categoryID, brandID, name, price, stocks, status FROM products WHERE productID = :productID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$pdo = null;

echo json_encode($row);
