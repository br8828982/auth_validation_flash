<?php
require_once "database.php";
require_once "functions.php";
session_start();
$errors = [];

if (isset($_SESSION["username"])) {
    header("Location: welcome.php");
    exit();
}

if (isset($_SESSION["flash_message"])) {
    $flashMessage = $_SESSION["flash_message"];
    unset($_SESSION["flash_message"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($username)) {
        $errors["username"] = "Username is required.";
    }
    
    if (empty($password)) {
        $errors["password"] = "Password is required.";
    }

    if (empty($errors)) {
        $user = findByUsername($username);
        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["username"] = $username;
            $_SESSION["flash_message"] = "Login successful. Welcome, $username!";
            header("Location: welcome.php");
            exit();
        } else {
            $errors["login"] = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1 class="center">Login</h1>
    <?php if (isset($flashMessage)): ?>
        <p class="flash center"><?= $flashMessage ?></p>
    <?php endif; ?>

    <?php if (isset($errors["login"])): ?>
        <p class="alpha center"><?= $errors["login"] ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
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
        
        <input type="submit" value="Login">
    </form>

    <p class="center">Don't have an account? <a href="register.php">Register here</a> | <a href="/">Home</a></p>
</body>
</html>
