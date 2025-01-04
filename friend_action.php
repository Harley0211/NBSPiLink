<?php
session_start();
require 'dbconnect.php';

if (!isset($_SESSION['id'])) {
    header("Location: registration_login.php");
    exit();
}

$user_id = $_SESSION['id'];
$friend_id = intval($_POST['friend_id']);
$action = $_POST['action'];

if ($action === 'add') {
    $query = "INSERT INTO friends (user_id, friend_id) VALUES (?, ?)";
} elseif ($action === 'delete') {
    $query = "DELETE FROM friends WHERE user_id = ? AND friend_id = ?";
} else {
    die("Invalid action.");
}

$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("ii", $user_id, $friend_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit();
?>
