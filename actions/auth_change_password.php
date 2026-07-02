<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass !== $confirm_pass) {
        header('Location: ../profile.php?error=Password baru tidak cocok');
        exit;
    }

    $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (password_verify($old_pass, $user->password)) {
        $hashed_new = password_hash($new_pass, PASSWORD_BCRYPT);
        $update = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $update->execute([$hashed_new, $_SESSION['user_id']]);
        header('Location: ../profile.php?success=Password berhasil diubah');
        exit;
    } else {
        header('Location: ../profile.php?error=Password lama salah');
        exit;
    }
}
?>
