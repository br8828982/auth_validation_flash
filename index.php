<?php
session_start();

if (isset($_SESSION["username"])) {
    header("Location: welcome.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Welcome Home</h1>
    <p>This is the home page.</p>
    
    <?php if (!isset($_SESSION["username"])): ?>
        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to get started.</p>
    <?php endif; ?>
</body>
</html>
