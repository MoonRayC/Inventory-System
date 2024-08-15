<?php
include 'config.php';

if (isset($_GET['id'])) {
    $brandID = $_GET['id'];  

     $stmtUpdateProduct = $pdo->prepare("UPDATE products SET brandID = NULL WHERE brandID = ?");
     $stmtUpdateProduct->execute([$brandID]);

    $stmt = $pdo->prepare("DELETE FROM brands WHERE brandID = ?");
    $stmt->execute([$brandID]);
    header("Location: http://localhost/WebIMS/brand.php?brandID=$brandId&success=4");
    exit();
} else {
    header("Location: http://localhost/WebIMS/brand.php?brandID=$brandId&success=5");
    exit();
}
?>