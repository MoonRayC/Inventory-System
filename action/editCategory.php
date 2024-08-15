<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $categoryID = trim($_POST['categoryID']);
    $categoryName = trim($_POST["editCategoryName"]);
    $status = trim($_POST["status"]); 

    $updateCategorySql = 'UPDATE categories SET name = :categoryName, status = :status WHERE categoryID = :categoryID';
    $updateCategoryStmt = $pdo->prepare($updateCategorySql);
    $updateCategoryStmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
    $updateCategoryStmt->bindParam(':status', $status, PDO::PARAM_STR);
    $updateCategoryStmt->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
    $updateSuccess = $updateCategoryStmt->execute();

    if ($updateSuccess) {
        header("location: http://localhost/WebIMS/category.php?success=2");
        exit();
    }else{
        header("location: http://localhost/WebIMS/category.php?success=3");
        exit();
    }
}
?>