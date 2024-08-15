<?php
session_start();

if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {
    header('location: login.php');
    exit();
}

include 'config.php';

$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];

if($userType == 1){
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE adminid = :userID"); 
} else if($userType == 2){
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = :userID");
}
$stmt->bindParam(":userID", $userID);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $userData['username'];
$firstname = $userData['firstname'];
$lastname = $userData['lastname'];
$email = $userData['email'];
$address = $userData['address'];
$phoneNumber = $userData['phoneNumber'];
$fbAcc = $userData['fbAcc'];
$xAcc = $userData['xAcc'];
$userType = $userData['userType'];
$lastPassword = $userData['password'];
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RDCJ IMS]</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/sideIcon.css">
    <link href="styles/indexStyle.css" rel="stylesheet">
</head>

<body>

    <div id="successMessage" class="alert alert-success alert-dismissible" role="alert"
        style='position: fixed; top: 20px; right: 20px; z-index: 9999;' hidden>
        Profile Updated Successfully
    </div>

    <div id="failedMessage" class="alert alert-danger alert-dismissible" role="alert"
        style='position: fixed; top: 20px; right: 20px; z-index: 9999;' hidden>
        Profile Updated Successfully
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="editsvg" viewBox="0 0 16 16">
            <path
                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
            <path fill-rule="evenodd"
                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
        </symbol>
        <symbol id="house-door-fill" viewBox="0 0 16 16">
            <path
                d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z" />
        </symbol>
    </svg>
    <?php include "includes/bgtheme.php" ?>

    <main class="d-flex flex-nowrap">
        <?php include "includes/sidebar.php" ?>


        <div class="b-example-divider b-example-vr"></div>
        <div class="container">
            <nav class="navbar bg-body">
                <div class="container-fluid">

                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis" href="index.php">
                                    <svg class="bi" width="16" height="16">
                                        <use xlink:href="#house-door-fill"></use>
                                    </svg>
                                    <span class="visually-hidden">Home</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>

                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </nav>
            <div class="profile-container position-relative">
                <a class="position-absolute top-0 end-0 m-3 text-decoration-none" data-bs-toggle="popover"
                    data-bs-trigger="hover" data-bs-placement="right" data-bs-content="Edit Profile">
                    <button button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#editProfile-form">
                        <svg class="bi" width="25" height="25" fill="currentColor">
                            <use xlink:href="#editsvg" />
                        </svg>
                    </button></a>
                <img src="assets/imgs/roundpic.png" alt="Profile Picture" class="profile-pic img-fluid">
                <h2><?php echo (isset($userData['firstname']) ? $userData['firstname'] : ' ') . ' ' . (isset($userData['lastname']) ? $userData['lastname'] : ' '); ?>
                </h2>
                <hr>

                <?php if ($userType == 1): ?>
                <div>Admin</div>
                <?php elseif ($userType == 2): ?>
                <div>Employee</div>
                <?php endif; ?>
                <div class="user-info">
                    <div><strong>Username:</strong>
                        <?php echo isset($userData['username']) ? $userData['username'] : ' '; ?></div>
                    <div><strong>Email:</strong> <?php echo isset($userData['email']) ? $userData['email'] : ' '; ?>
                    </div>
                    <div><strong>Phone Number:</strong>
                        <?php echo isset($userData['phoneNumber']) ? $userData['phoneNumber'] : ' '; ?></div>
                    <div><strong>Address:</strong>
                        <?php echo isset($userData['address']) ? $userData['address'] : ' '; ?></div>
                    <div><strong>Facebook Account:</strong>
                        <?php echo isset($userData['fbAcc']) ? $userData['fbAcc'] : ' '; ?></div>
                    <div><strong>X Account:</strong> <?php echo isset($userData['xAcc']) ? $userData['xAcc'] : ' '; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editProfile-form" tabindex="-1" aria-labelledby="payment" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-dialog-scrollable modal-lg">
                <div class="modal-content bg-body-secondary">
                    <div class="modal-header">
                        <div class="col text-center">
                            <h5 class="card-title mb-3"><b>Edit Profile</b></h5>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="action/editProfile.php" method="POST" id="editForm">
                            <input type="hidden" name="userID" id="userID" value="<?php echo $userID ?>">
                            <input type="hidden" name="userType" id="userType" value="<?php echo $userType ?>">
                            <input type="hidden" name="lastpassword" id="lastpassword"
                                value="<?php echo $lastPassword ?>">

                            <div class="form-floating mb-3">
                                <input type="text" name="username" id="username" class="form-control border-info"
                                    value="<?php echo $username ?>">
                                <label for="floatingInput">Username</label>
                                <span id="usernameError" class="invalid-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="firstname" id="firstname"
                                            class="form-control border-info" value="<?php echo $firstname ?>">
                                        <label for="floatingInput">Firstname</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="lastname" id="lastname"
                                            class="form-control border-info" value="<?php echo $lastname ?>">
                                        <label for="floatingInput">Lastname</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="email" id="email" class="form-control border-info"
                                    value="<?php echo $email ?>">
                                <label for="floatingInput">Email</label>
                                <span id="emailError" class="invalid-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="address" id="address" class="form-control border-info"
                                            value="<?php echo $address ?>">
                                        <label for="floatingInput">Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="phoneNumber" id="phoneNumber"
                                            class="form-control border-info" value="<?php echo $phoneNumber ?>">
                                        <label for="floatingInput">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="fbAccount" id="fbAccount"
                                            class="form-control border-info" value="<?php echo $fbAcc ?>">
                                        <label for="floatingInput">Facebook Account</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="XAccount" id="XAccount"
                                            class="form-control border-info" value="<?php echo $xAcc ?>">
                                        <label for="floatingInput">X Account</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="newpassword" id="newpassword"
                                            class="form-control border-info">
                                        <label for="floatingInput">New Password</label>
                                        <span id="unmatchError1" class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="confirmpassword" id="confirmpassword"
                                            class="form-control border-info">
                                        <label for="floatingInput">Confirm Password</label>
                                        <span id="unmatchError2" class="invalid-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="oldpassword" id="oldpassword"
                                    class="form-control border-info">
                                <label for="floatingInput">Password</label>
                                <span id="passwordError" class="invalid-feedback"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="editForm()">Edit
                                    Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="scripts/profile.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this reservation?");
    }

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    </script>
</body>

</html>