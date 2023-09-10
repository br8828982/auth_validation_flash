<?php
require_once "database.php";
require_once "functions.php";
session_start();
$errors = [];

if (isset($_SESSION["username"])) {
    header("Location: welcome.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($username)) {
        $errors["username"] = "Username is required.";
    } elseif (strlen($username) < 3) {
        $errors["username"] = "Username must be at least 3 characters long.";
    }
    
    if (empty($password)) {
        $errors["password"] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors["password"] = "Password must be at least 6 characters long.";
    }

    if (findByUsername($username)) {
        $errors["username"] = "Username already exists.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (registerUser($username, $hashedPassword)) {
            $_SESSION["flash_message"] = "Registration successful. Please login.";
            header("Location: login.php");
            exit();
        } else {
            $errors["register"] = "An error occurred during registration. Please try again later.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1 class="center">Register</h1>
    <?php if (isset($errors["register"])): ?>
        <p><?= $errors["register"] ?></p>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>"><br>
        <?php if (isset($errors["username"])): ?>
            <p class="error"><?= $errors["username"] ?></p>
        <?php endif; ?>
        
        <label for="password">Password:</label>
        <input type="password" name="password"><br>
        <?php if (isset($errors["password"])): ?>
            <p class="error"><?= $errors["password"] ?></p>
        <?php endif; ?>
        
        <input type="submit" value="Register">
    </form>

    <p class="center">Already have an account? <a href="login.php">Login here</a> | <a href="/">Home</a></p>
</body>
</html>
