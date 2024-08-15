<?php

$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "myims";

$connect = new mysqli($localhost, $username, $password, $dbname);
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
}

$sql = 'SELECT productID, name FROM products WHERE status = "available"';
$stmt = $connect->query($sql);
$data = $stmt->fetch_all();
$pdo = null;

echo json_encode($data);
