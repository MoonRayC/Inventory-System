<?php
include 'config.php';

if (isset($_GET['id'])) {
    $categoryID = $_GET['id'];

     $stmtUpdateProduct = $pdo->prepare("UPDATE products SET categoryID = NULL WHERE categoryID = ?");
     $stmtUpdateProduct->execute([$categoryID]);

    $stmtDeleteCategory = $pdo->prepare("DELETE FROM categories WHERE categoryID = ?");
    $stmtDeleteCategory->execute([$categoryID]);

    header("Location: http://localhost/WebIMS/category.php?categoryID=$categoryID&success=4");
    exit();
} else {
    header("Location: http://localhost/WebIMS/category.php?success=5");
    exit();
}
?>
