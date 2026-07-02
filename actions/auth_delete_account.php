<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Hapus seluruh transaksi yang berelasi dengan user_id ini
    $stmt1 = $pdo->prepare('DELETE FROM transactions WHERE user_id = ?');
    $stmt1->execute([$user_id]);

    // Hapus data akun user
    $stmt2 = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt2->execute([$user_id]);

    // Hancurkan sesi untuk melogout secara paksa
    session_destroy();

    // Arahkan kembali ke halaman login dengan pesan sukses
    header('Location: ../login.php?success=Akun beserta seluruh riwayat kas berhasil dihapus permanen');
    exit;
}
?>
