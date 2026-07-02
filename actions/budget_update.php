<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['error' => 'Unauthorized']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['budgetLimit'])) {
        http_response_code(400);
        exit(json_encode(['error' => 'Bad Request']));
    }
    
    $budgetLimit = (int)$data['budgetLimit'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare('UPDATE users SET monthly_budget_limit = ? WHERE id = ?');
    if ($stmt->execute([$budgetLimit, $userId])) {
        $_SESSION['monthly_budget_limit'] = $budgetLimit;
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}
?>
