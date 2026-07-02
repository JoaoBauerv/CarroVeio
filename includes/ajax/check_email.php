<?php
require __DIR__ . '\..\db\conn.php'; 

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['valid' => false, 'message' => 'E-mail inválido.']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
$stmt->execute(['email' => $email]);

$existe = $stmt->fetch(PDO::FETCH_ASSOC) !== false;

echo json_encode([
    'valid'   => !$existe,
    'message' => $existe ? 'Esse e-mail já está cadastrado.' : ''
]);