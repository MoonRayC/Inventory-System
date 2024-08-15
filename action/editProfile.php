<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $oldPassword = trim($_POST['oldpassword']);
    $lastPassword = trim($_POST['lastpassword']);

    if (!password_verify($oldPassword, $lastPassword)) {
        header("location: http://localhost/WebIMS/profileForm.php?success=0");
        exit();
    } else if(password_verify($oldPassword, $lastPassword)) {
        $userID = trim($_POST['userID']);
        $userType = trim($_POST['userType']);
        $username = trim($_POST['username']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $phoneNumber = trim($_POST['phoneNumber']);
        $fbAcc = trim($_POST['fbAccount']);
        $xAcc = trim($_POST['XAccount']);

        if($userType == 1){
            $updateProfileSql = 'UPDATE admins SET username = :username, firstname = :firstname, lastname = :lastname, email = :email, address = :address, phoneNumber = :phoneNumber, fbAcc = :fbAcc, xAcc = :xAcc WHERE adminID = :userID';
        } else if($userType == 2){
            $updateProfileSql = 'UPDATE users SET username = :username, firstname = :firstname, lastname = :lastname, email = :email, phoneNumber = :phoneNumber, fbAcc = :fbAcc, xAcc = :xAcc WHERE userID = :userID';
        }
        $updateProfileStmt = $pdo->prepare($updateProfileSql);
        $updateProfileStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':address', $address, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':fbAcc', $fbAcc, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':xAcc', $xAcc, PDO::PARAM_STR);
        $updateProfileStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $updateProfileStmt->execute();

        $newPassword = trim($_POST['newpassword']);
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updatePasswordSql = 'UPDATE users SET password = :password WHERE userID = :userID';
            if($userType == 1){
                $updatePasswordSql = 'UPDATE admins SET password = :password WHERE adminID = :userID';
            } else if($userType == 2){
                $updatePasswordSql = 'UPDATE users SET password = :password WHERE userID = :userID';
            }
            $updatePasswordStmt = $pdo->prepare($updatePasswordSql);
            $updatePasswordStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $updatePasswordStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $updatePasswordStmt->execute();
        }
        header("location: http://localhost/WebIMS/profileForm.php?success=1");
        exit();
    } else {
        header("location: http://localhost/WebIMS/profileForm.php?success=2");
        exit(); 
    }
}
?>