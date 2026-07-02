<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['error' => 'Unauthorized']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['id']) || !isset($data['amount']) || !isset($data['description']) || !isset($data['category']) || !isset($data['type'])) {
        http_response_code(400);
        exit(json_encode(['error' => 'Bad Request']));
    }
    
    $stmt = $pdo->prepare('UPDATE transactions SET type = ?, category = ?, amount = ?, description = ? WHERE id = ? AND user_id = ?');
    if ($stmt->execute([$data['type'], $data['category'], $data['amount'], $data['description'], $data['id'], $_SESSION['user_id']])) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}
?>
