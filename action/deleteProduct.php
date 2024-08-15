<?php
include 'config.php';

if (isset($_GET['id'])) {
    $productID = $_GET['id'];   

    $stmt = $pdo->prepare("DELETE FROM products WHERE productID = ?");
    $stmt->execute([$productID]);
    header("Location: http://localhost/WebIMS/product.php?productID=$productID&success=4");
    exit();
} else {
    header("Location: http://localhost/WebIMS/product.php?productID=$productID&success=5");
    exit();
}
?>