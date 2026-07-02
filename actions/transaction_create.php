<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['error' => 'Unauthorized']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $type = $data['type'] ?? '';
    $category = $data['category'] ?? '';
    $amount = $data['amount'] ?? 0;
    $description = $data['description'] ?? '';
    $date = date('Y-m-d'); // Current date for transaction

    if (!in_array($type, ['Pemasukan', 'Pengeluaran']) || empty($category) || empty($amount) || empty($description)) {
        http_response_code(400);
        exit(json_encode(['error' => 'Invalid data']));
    }

    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO transactions (user_id, type, category, amount, description, transaction_date) VALUES (?, ?, ?, ?, ?, ?)');
    if ($stmt->execute([$userId, $type, $category, $amount, $description, $date])) {
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}
?>
