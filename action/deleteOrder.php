<?php
session_start();

if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {
    header('location: login.php');
    exit();
}

include 'config.php';

$userType = $_SESSION['user_type'];

if ($userType == 2) { 
    header("Location: http://localhost/WebIMS/order.php?success=8");
    exit();
} else {
    if (isset($_GET['id'])) {
        $orderID = $_GET['id'];
    
         $stmtUpdateProduct = $pdo->prepare("DELETE FROM orders WHERE orderID = ?");
         $stmtUpdateProduct->execute([$orderID]);
    
        $stmtDeleteCategory = $pdo->prepare("DELETE FROM orderedItems WHERE orderID = ?");
        $stmtDeleteCategory->execute([$orderID]);
    
        header("Location: http://localhost/WebIMS/order.php?success=4");
        exit();
    } else {
        header("Location: http://localhost/WebIMS/order.php?success=5");
        exit();
    }
}
?>
