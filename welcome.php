<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$flashMessage = isset($_SESSION["flash_message"]) ? $_SESSION["flash_message"] : "";
unset($_SESSION["flash_message"]);

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php if (!empty($flashMessage)): ?>
        <p class="flash center"><?= $flashMessage ?></p>
    <?php endif; ?>

    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
    <form class="logout" method="post" action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>
</html>