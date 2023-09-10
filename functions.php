<?php
function registerUser($username, $password) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        error_log("Database error during user registration: " . $e->getMessage());
        return false;
    }
}

function findByUsername($username) {
    global $pdo;
  
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error during username lookup: " . $e->getMessage());
        return false;
    }
}
?>
