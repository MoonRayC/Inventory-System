<?php
include 'config.php';

session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $brandName = trim($_POST["addBrandName"]);

        $addBrandSql = 'INSERT INTO brands (name, stocks, status) VALUES (:brandName, 0, "unavailable")';
        $addBrandStmt = $pdo->prepare($addBrandSql);
        $addBrandStmt->bindParam(':brandName', $brandName, PDO::PARAM_STR);

        $updateSuccess = $addBrandStmt->execute(); 

        if ($updateSuccess) {
            header("location: http://localhost/WebIMS/brand.php?success=1");
            exit();
        } else {
            header("location: http://localhost/WebIMS/brand.php?success=0");
            exit();
        }
}
?>
