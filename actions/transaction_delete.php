<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['error' => 'Unauthorized']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['id'])) {
        http_response_code(400);
        exit(json_encode(['error' => 'Bad Request']));
    }

    $txId = $data['id'];
    $userId = $_SESSION['user_id'];

    // Double-check user_id matches session
    $stmt = $pdo->prepare('DELETE FROM transactions WHERE id = ? AND user_id = ?');
    if ($stmt->execute([$txId, $userId])) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}
?>
