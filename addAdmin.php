<?php
include 'config.php';

session_start();

if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {
    header('location: login.php');
    exit();
}

$userType = $_SESSION['user_type'];

$username = $firstname = $lastname = $password = $confirm_password = '';
$username_err = $firstname_err = $lastname_err = $password_err = $confirm_password_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter a username.';
    } else {
        $username = trim($_POST['username']);
    }

    if (empty(trim($_POST['firstname']))) {
        $firstname_err = 'Please enter your firstname.';
    } else {
        $firstname = trim($_POST['firstname']);
    }

    if (empty(trim($_POST['lastname']))) {
        $lastname_err = 'Please enter your lastname.';
    } else {
        $lastname = trim($_POST['lastname']);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter a password.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    if (empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = 'INSERT INTO admins (username, firstname, lastname, password, status, userType) 
                    VALUES (:username, :firstname, :lastname, :password, "active", 1)';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $param_firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $param_lastname, PDO::PARAM_STR);
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);

            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                header('location: userData.php');
            } else {
                echo 'Something went wrong. Please try again later.';
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RDCJ IMS</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/sideIcon.css">
    <link href="styles/sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <?php include "includes/bgtheme.php" ?>

    <main class="form-signin w-100 m-auto" style="max-width: 450px;">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-4 text-center">
                <img class="mx-auto" src="assets/imgs/logo.png" alt="" width="200" height="100">
            </div>
            <h1 class="h3 mb-3 fw-normal text-center">CREATE ADMIN ACCOUNT</h1>
            <div class="form-floating">
                <input type="text" name="username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $username; ?>">
                <label for="floatingInput">Username</label>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-floating">
                <input type="text" name="firstname"
                    class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $firstname; ?>">
                <label for="floatingInput">Firstname</label>
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-floating">
                <input type="text" name="lastname"
                    class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $lastname; ?>">
                <label for="floatingInput">Lastname</label>
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-floating">
                <input type="password" name="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>">
                <label for="floatingPassword">Password</label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-floating">
                <input type="password" name="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $confirm_password; ?>">
                <label for="floatingPassword">Confirm Password</label>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit" style="margin-bottom: 10px;">Sign in</button>
            <button type="button" class="btn btn-danger w-100 py-2"
                onclick="window.location.href='userData.php'">Cancel</button>
        </form>
    </main>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>