<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: registration_login.php");
    exit();
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];

    $valid_statuses = ['Active', 'Inactive', 'Do Not Disturb'];
    if (in_array($status, $valid_statuses)) {
        $_SESSION['status'] = $status;

        header("Location: index.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
