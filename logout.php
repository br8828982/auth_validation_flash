<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    unset($_SESSION["username"]);
    session_regenerate_id(true);
    $_SESSION["flash_message"] = "You have been logged out successfully.";
}
header("Location: login.php");
exit();
?>