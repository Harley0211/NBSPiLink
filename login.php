<?php
require 'dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "Invalid credentials.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="login.php" class="form-card">
            <h2>Login</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <input type="text" name="username" placeholder="Username, Email, or Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p class="register-link">Don't have an account? <a href="registration.php">Create now</a></p>
        </form>
    </div>
</body>
</html>
