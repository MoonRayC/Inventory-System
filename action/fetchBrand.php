<?php
include 'config.php';

$brandID = $_GET['brandID'];

$stmt = $pdo->prepare("SELECT * FROM brands WHERE brandID = :brandID");
$stmt->bindParam(":brandID", $brandID);
$stmt->execute();
$brandData = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($brandData);
?>
