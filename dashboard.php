<?php
session_start();

if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {
    header('location: login.php');
    exit();
}

include 'config.php';

$userType = $_SESSION['user_type'];

if (isset($_SESSION['brand_err'])) {
    $brand_err = $_SESSION['brand_err'];
    unset($_SESSION['brand_err']);
} else {
    $brand_err = ""; 
}
  $countProductQuery = "SELECT COUNT(*) AS total_products FROM products";
  $countProductStatement = $pdo->query($countProductQuery);
  $countProduct = $countProductStatement->fetch(PDO::FETCH_ASSOC)['total_products'];

  $selectQuery = "SELECT COUNT(*) AS low_stock_count FROM products WHERE stocks <= 20";
  $selectStatement = $pdo->query($selectQuery);
  $countLowStock = $selectStatement->fetch(PDO::FETCH_ASSOC)['low_stock_count'];

  $countOrderQuery = "SELECT COUNT(*) AS total_orders FROM orders";
  $countOrderStatement = $pdo->query($countOrderQuery);
  $countOrder = $countOrderStatement->fetch(PDO::FETCH_ASSOC)['total_orders'];

  $sumQuery = "SELECT SUM(grandTotal) AS total_price FROM orders";
  $sumStatement = $pdo->query($sumQuery);
  $totalPrice = $sumStatement->fetch(PDO::FETCH_ASSOC)['total_price'];

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RDCJ IMS</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/order.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/sideIcon.css">

</head>

<body>
    <?php include "includes/bgtheme.php" ?>

    <main class="d-flex flex-nowrap">
        <?php include "includes/sidebar.php" ?>


        <div class="b-example-divider b-example-vr"></div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <a href="product.php" class="btn btn-outline-success d-flex justify-content-between">
                        Total Products
                        <span class="badge text-bg-success"><?php echo $countProduct; ?></span>
                    </a>
                </div>


                <div class="col-md-4 mb-5">
                    <a href="product.php?showLowStock=true&stocks=<?php echo $countLowStock; ?>" class="btn btn-outline-danger d-flex justify-content-between">
                        Low Stocks
                        <span class="badge text-bg-danger"><?php echo $countLowStock; ?></span>
                    </a>
                </div>
                <div class="col-md-4 mb-5">
                    <a href="order.php" class="btn btn-outline-info d-flex justify-content-between">
                        Total Orders
                        <span class="badge text-bg-info"><?php echo $countOrder; ?></span>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-header text-center text-info-emphasis">
                            <h3><b><?php echo date('Y-m-d'); ?></b></h3>
                        </div>
                        <div class="card-body text-center">
                            <h5>Date</h5>
                        </div>
                    </div>
                    <div class="card mt-5 border-primary">
                        <div class="card-header text-center text-info-emphasis">
                            <h3><b>₱ <?php echo $totalPrice; ?></b></h3>
                        </div>
                        <div class="card-body text-center">
                            <h5>Total Revenue</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="graph-container">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
    </main>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/successMessage.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>


    <script>
      fetch('action/fetchOrderDate.php')
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(entry => entry.orderDay),
                    datasets: [{
                        label: 'Daily Revenue',
                        data: data.map(entry => entry.dailyRevenue),
                        backgroundColor: 'rgba(10, 9, 216, 0.8)',
                        borderColor: 'rgba(3, 2, 114, 0.8)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    </script>

</body>

</html>