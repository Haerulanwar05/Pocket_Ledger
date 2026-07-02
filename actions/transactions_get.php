<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['error' => 'Unauthorized']));
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT id, type, category, amount, DATE_FORMAT(transaction_date, "%Y-%m-%d") as date, description FROM transactions WHERE user_id = ? ORDER BY transaction_date DESC, id DESC');
$stmt->execute([$userId]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($transactions);
?>
