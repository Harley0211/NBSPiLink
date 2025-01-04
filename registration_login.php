<?php
session_start();
include 'dbconnect.php';

if (isset($_POST['register'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $middle_name = $conn->real_escape_string($_POST['middle_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        $query = "INSERT INTO users (first_name, middle_name, last_name, dob, username, email, password, created_at)
                  VALUES ('$first_name', '$middle_name', '$last_name', '$dob', '$username', '$email', '$hashed_password', NOW())";
        if ($conn->query($query)) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('No account found with this username!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    .section {
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('login/banner.jpg');
        background-size: cover;
        background-position: center;
    }

    .form-box {
        width: 380px;
        height: 480px;
        position: relative;
        margin: 6% auto;
        background: #fff;
        padding: 5px;
        overflow: hidden;
        border-radius: 10px;
    }

    .button-box {
        width: 220px;
        margin: 35px auto;
        position: relative;
        box-shadow: 0 0 20px 9px #ff61241f;
        border-radius: 30px;
    }

    .toggle-btn {
        padding: 10px 30px;
        cursor: pointer;
        background: transparent;
        border: 0;
        outline: none;
        position: relative;

    }

    #btn {
        top: 0;
        left: 0;
        position: absolute;
        width: 110px;
        height: 100%;
        background: linear-gradient(to right, #0f004b, #2700d4);
        border-radius: 30px;
        transition: .5s;
    }

    .social-icons {
        margin: 30px auto;
        text-align: center;
    }

    .social-icons img {
        width: 30px;
        margin: 0 12px;
        box-shadow: 0 0 20px 0 #7f7f7f3d;
        cursor: pointer;
        border-radius: 50%;
    }

    .input-group {
        top: 180px;
        position: absolute;
        width: 280px;
        transition: .5s;
    }

    .input-field {
        width: 100%;
        padding: 10px 0;
        margin: 5px 0;
        border-left: 0;
        border-top: 0;
        border-right: 0;
        border-bottom: 1px solid #999;
        outline: none;
        background: transparent;

    }

    .submit-btn {
        width: 85%;
        padding: 10px 30px;
        cursor: pointer;
        display: block;
        margin: auto;
        background: linear-gradient(to right, #0f004b, #2700d4);
        border: 0;
        outline: none;
        border-radius: 30px;

    }

    .check-box {
        margin: 30px 10px 30px 0;
    }

    span {
        color: #777;
        font-size: 12px;
        bottom: 68px;
        position: absolute;

    }

    #login {
        left: 50px;
    }

    #register {
        left: 450px;
        overflow-y: auto;
        padding-right: 10px;
        max-height: 300px;
    }
</style>

<body>

    <div class="section">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Login</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>
            </div>
            <div class="social-icons">
                <a href="https://www.fb.com/"><img src="login/fb.png"></a>
                <a href="https://www.twitter.com/"><img src="login/tw.png"></a>
                <a href="https://www.google.com/"><img src="login/gp.png"></a>
            </div>

            <form id="login" class="input-group" method="POST" action="">
                <input type="taext" name="username" class="input-field" placeholder="Username" required>
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" name="login" class="submit-btn">Log in</button>
            </form>

            <form id="register" class="input-group" method="POST" action="">
                <input type="text" name="first_name" class="input-field" placeholder="First Name" required>
                <input type="text" name="middle_name" class="input-field" placeholder="Middle Name (Optional)">
                <input type="text" name="last_name" class="input-field" placeholder="Last Name" required>
                <input type="date" name="dob" class="input-field" placeholder="Date of Birth" required>
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <input type="email" name="email" class="input-field" placeholder="Email" required>
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" required>
                <button type="submit" name="register" class="submit-btn">Register</button>
            </form>

        </div>
    </div>

    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn");

        function register() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0px";
        }
    </script>
</body>

</html>