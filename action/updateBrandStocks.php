<?php
$host = "localhost";
$db_name = "myims";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlCategory = "SELECT categoryID, SUM(stocks) AS totalCategoryStocks FROM products GROUP BY categoryID ORDER BY categoryID";
    $resultCategory = $pdo->query($sqlCategory);

    while ($rowCategory = $resultCategory->fetch(PDO::FETCH_ASSOC)) {
        $updateCategorySQL = "UPDATE categories SET stocks = :totalStocks WHERE categoryID = :categoryID";
        $stmt = $pdo->prepare($updateCategorySQL);
        $stmt->bindParam(':totalStocks', $rowCategory['totalCategoryStocks']);
        $stmt->bindParam(':categoryID', $rowCategory['categoryID']);
        $stmt->execute();
    }

    $sqlBrand = "SELECT brandID, SUM(stocks) AS totalBrandStocks FROM products GROUP BY brandID ORDER BY brandID";
    $resultBrand = $pdo->query($sqlBrand);

    while ($rowBrand = $resultBrand->fetch(PDO::FETCH_ASSOC)) {
        $updateBrandSQL = "UPDATE brands SET stocks = :totalStocks WHERE brandID = :brandID";
        $stmt = $pdo->prepare($updateBrandSQL);
        $stmt->bindParam(':totalStocks', $rowBrand['totalBrandStocks']);
        $stmt->bindParam(':brandID', $rowBrand['brandID']);
        $stmt->execute();
    }

    header("location: http://localhost/WebIMS/brand.php");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
