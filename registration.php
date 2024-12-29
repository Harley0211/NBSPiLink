<?php
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username, email, or phone number already exists. Please use a different one.');</script>";
    } else {
        $query = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $phone, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('An error occurred. Please try again.');</script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="registration.php" class="form-card">
            <h2>Register</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
