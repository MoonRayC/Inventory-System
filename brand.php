<?php
session_start();

if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {
    header('location: login.php');
    exit();
}

include 'config.php';

$userType = $_SESSION['user_type'];
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
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/order.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/sideIcon.css">

</head>

<body>

    <div id="successMessage" class="alert alert-success alert-dismissible" role="alert"
        style='position: fixed; top: 20px; right: 20px; z-index: 9999; width:25rem;' hidden>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="add" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
        </symbol>
        <symbol id="house-door-fill" viewBox="0 0 16 16">
            <path
                d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z" />
        </symbol>
        <symbol id="refresh" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
            <path
                d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
        </symbol>
        <symbol id="delete" viewBox="0 0 16 16">
            <path
                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
        </symbol>
        <symbol id="edit" viewBox="0 0 16 16">
            <path
                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
            <path fill-rule="evenodd"
                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
        </symbol>
        <symbol id="setting" viewBox="0 0 16 16">
            <path
                d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
            <path
                d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
        </symbol>
    </svg>
    <?php include "includes/bgtheme.php" ?>

    <main class="d-flex flex-nowrap">
        <?php include "includes/sidebar.php" ?>


        <div class="b-example-divider b-example-vr"></div>
        <div class="container">
            <nav class="navbar bg-body">
                <div class="container-fluid">

                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis" href="index.php">
                                    <svg class="bi" width="16" height="16">
                                        <use xlink:href="#house-door-fill"></use>
                                    </svg>
                                    <span class="visually-hidden">Home</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Brands</li>
                        </ol>
                    </nav>

                    <form class="d-flex" role="search">
                        <div class="form-group">
                            <input type="text" name="search" id="search" class="form-control mr-2"
                                placeholder="Search by name">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form>
                </div>
            </nav>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card bg-body-secondary position-relative border-primary">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h2 class="card-title mb-0"><b>Brand</b></h2>
                            <div class="d-flex">
                                <div class="me-3">
                                    <a data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="right"
                                        data-bs-content="Add Brand"><button type="button"
                                            class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addBrand-form">
                                            <svg class="bi" width="30" height="30">
                                                <use xlink:href="#add" />
                                            </svg>
                                        </button></a>
                                </div>
                                <div>
                                    <a href="action/updateBrandStocks.php" class="btn btn-outline-primary" data-bs-toggle="popover"
                                        data-bs-trigger="hover" data-bs-placement="right" data-bs-content="Refresh">
                                        <svg class="bi" width="32" height="32" fill="currentColor">
                                            <use xlink:href="#refresh" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class='text-center'>
                                        <th>Name</th>
                                        <th>Stocks</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                    include 'config.php';

                    $limit = 5;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $searchCondition = "WHERE name LIKE :search OR status COLLATE utf8mb4_general_ci LIKE :search";

                    $stmtTotal = $pdo->prepare("SELECT COUNT(*) as total FROM brands $searchCondition");
                    $stmtTotal->execute(['search' => "%$search%"]);
                    $totalRecords = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

                    $limit = 5;
                    $totalPages = ceil($totalRecords / $limit);

                    $page = isset($_GET['page']) ? $_GET['page'] : 1;

                    $offset = ($page - 1) * $limit;

                    $stmt = $pdo->prepare("SELECT * FROM brands $searchCondition LIMIT $limit OFFSET $offset");
                    $stmt->execute(['search' => "%$search%"]);
                    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($brands) {
                        foreach ($brands as $brand) {

                            if ($brand['stocks'] <= 0) {
                                $brand['status'] = "unavailable";
                                $statusClass = 'btn-danger';
                            } else {
                                $statusClass = ($brand['status'] == 'available') ? 'btn-success' : 'btn-danger';
                            }

                            echo "<tr class='text-center'>";
                            echo "<td><a href='product.php?findProduct={$brand['name']}' style='text-decoration: none; font-weight: bold; color: #fff;'>{$brand['name']}</a></td>";
                            echo "<td>{$brand['stocks']}</td>";
                            echo "<td class='text-center'><a class='btn rounded-pill opacity-75 px-1 py-0 $statusClass' style='font-size: 12px;'>{$brand['status']}</a></td>";
                            echo "<td>
                                    <div class='dropdown'>
                                        <a class='d-flex align-items-center justify-content-center dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'
                                            style='text-decoration: none; font-weight: bold; color: #fff;' href='#'>
                                            <svg class='bi pe-none' width='24' height='24'>
                                                <use xlink:href='#setting' />
                                            </svg>&nbsp; Action
                                        </a>
                                        <ul class='dropdown-menu px-2 border-info'>
                                            <li><button type='button' class='btn btn-outline-info w-100 mb-1 text-start' onclick='openEditModal({$brand['brandID']})'>
                                            <svg class='bi pe-none' width='24' height='24'>
                                                <use xlink:href='#edit' />
                                            </svg>&nbsp;
                                            Edit Brand
                                            </button></li>
                                            <li><a class='btn btn-outline-info w-100' onclick='return confirmDelete();' href='action/deleteBrand.php?id={$brand['brandID']}'>
                                            <svg class='bi pe-none' width='24' height='24'>
                                                <use xlink:href='#delete' />
                                            </svg>&nbsp;
                                            Delete Brand
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr class='text-center'><td colspan='8'><b>No brand Found</b></td></tr>";
                    }    
                    ?>

                                </tbody>
                            </table>

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php
                                echo "<li class='page-item " . ($page == 1 ? 'disabled' : '') . "'>";
                                echo "<a class='page-link' href='?page=" . ($page - 1) . "' aria-label='Previous'
                                    data-bs-toggle='popover' data-bs-trigger='hover'
                                    data-bs-placement='bottom' data-bs-content='Previous Page'>";
                                echo "<span aria-hidden='true'>&laquo;</span>";
                                echo "</a>";
                                echo "</li>";

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'>";
                                    echo "<a class='page-link' href='?page=$i'>$i</a>";
                                    echo "</li>";
                                }

                                echo "<li class='page-item " . ($page == $totalPages || empty($brands) ? 'disabled' : '') . "'>";
                                echo "<a class='page-link' href='?page=" . ($page + 1) . "' aria-label='Next'
                                    data-bs-toggle='popover' data-bs-trigger='hover'
                                    data-bs-placement='bottom' data-bs-content='Next Page'>";
                                echo "<span aria-hidden='true'>&raquo;</span>";
                                echo "</a>";
                                echo "</li>";
                            ?>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="addBrand-form" tabindex="-1" aria-labelledby="addBrand"
                data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-top modal-dialog-scrollable modal-lg">
                    <div class="modal-content bg-body-secondary">
                        <div class="modal-body">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="">
                                        <h5 class="card-title mb-3"><b>Add Brand</b></h5>
                                    </div>
                                    <form action="action/addBrand.php" method="post" id="addBrandForm">
                                        <div class="form-floating">
                                            <input type="text" name="addBrandName" id="addBrandName"
                                                class="form-control">
                                            <label for="floatingInput">Brand Name</label>
                                            <span class="invalid-feedback"
                                                id="brandAddError"></span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="addBrand()">Add
                                                Brand</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>



            <div class="modal fade" id="editBrand-form" tabindex="-1" aria-labelledby="editBrand"
                data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-top modal-dialog-scrollable modal-lg">
                    <div class="modal-content bg-body-secondary">
                        <div class="modal-body">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="">
                                        <h5 class="card-title mb-3"><b>Edit Brand</b></h5>
                                    </div>
                                    <form action="action/editBrand.php" method="post" id="editBrandForm">
                                        <input type="hidden" id="brandID" name="brandID" value="">

                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" id="name" class="form-control" value=""
                                                required>
                                            <label for="floatingInput">Brand Name</label>
                                            <span class="invalid-feedback" id="nameError"></span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select name="status" id="status" class="form-select">
                                                <option value="null">~~SELECT~~</option>
                                                <option value="available">
                                                    Available</option>
                                                <option value="unavailable">
                                                    Unavailable</option>
                                            </select>
                                            <label for="status">Status</label>
                                            <span id="statusError" class="invalid-feedback"></span>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="editBrand()">Edit Brand</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/successMessage.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
    function openEditModal(brandID) {
        $.ajax({
            url: 'action/fetchBrand.php',
            type: 'GET',
            data: {
                brandID: brandID
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById('brandID').value = data.brandID;
                document.getElementById('name').value = data.name;
                document.getElementById('status').value = data.status;

                $('#editBrand-form').modal('show');
            },
            error: function() {
                console.log('Error fetching brand data.');
            }
        });
    }

    function addBrand() {
        if (validateAddForm()) {
            document.getElementById("addBrandForm").submit();
        }
    }

    function validateAddForm() {
        var brandName = document.getElementById("addBrandName").value;
        var brandErrorSpan = document.getElementById("brandAddError");

        brandErrorSpan.innerHTML = "";
        document.getElementById("addBrandName").classList.remove("is-invalid");

        if (brandName.trim() === "") {
            brandErrorSpan.innerHTML = "Please enter a brand name.";
            document.getElementById("addBrandName").classList.add("is-invalid");
            return false;
        }
        document.getElementById("addBrandName").classList.remove("is-invalid");
        return true;
    }

    function editBrand() {
        if (validateEditForm()) {
            document.getElementById("editBrandForm").submit();
        }
    }

    function validateEditForm() {
        var brandName = document.getElementById("name").value;
        var status = document.getElementById("status").value;
        var brandErrorSpan = document.getElementById("nameError");
        var statusErrorSpan = document.getElementById("statusError");

        brandErrorSpan.innerHTML = "";
        document.getElementById("name").classList.remove("is-invalid");

        statusErrorSpan.innerHTML = "";
        document.getElementById("status").classList.remove("is-invalid");

        if (brandName.trim() === "") {
            brandErrorSpan.innerHTML = "Please enter a brand name.";
            document.getElementById("name").classList.add("is-invalid");
            return false;
        }

        if (status.trim() === "null") {
            statusErrorSpan.innerHTML = "Please Select a Brand.";
            document.getElementById("status").classList.add("is-invalid");
            return false;
        }
        return true;
    }

    function confirmDelete() {
        return confirm("Are you sure you want to delete this brand?");
    }
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    </script>

</body>

</html>