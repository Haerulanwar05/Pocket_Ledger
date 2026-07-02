<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(trim($_POST['username']));
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header('Location: ../register.php?error=Username already exists');
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $monthly_budget_limit = 0; // Strictly set to 0 as required

    $stmt = $pdo->prepare('INSERT INTO users (username, password, monthly_budget_limit) VALUES (?, ?, ?)');
    if ($stmt->execute([$username, $hashed_password, $monthly_budget_limit])) {
        header('Location: ../login.php?success=Registration successful');
        exit;
    } else {
        header('Location: ../register.php?error=Registration failed');
        exit;
    }
}
?>
