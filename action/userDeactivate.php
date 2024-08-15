<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminID = $_POST['adminID'];
    $userType = $_POST['userType'];
    if ($userType == 1) {
        $stmt = $pdo->prepare("UPDATE admins SET status = 'inactive' WHERE adminID = :adminID");
    } elseif ($userType == 2) {
        $stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE userID = :adminID");
    }

    $stmt->bindParam(':adminID', $adminID, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User deactivated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deactivating user']);
    }
    exit();
}
?>
