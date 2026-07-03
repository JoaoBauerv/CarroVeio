<?php
session_start();

require __DIR__ . '/../db/conn.php'; 

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$erros = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'Informe um e-mail válido.';
}

if ($senha === '') {
    $erros[] = 'Informe a senha.';
}

if (!empty($erros)) {
    echo json_encode(['success' => false, 'errors' => $erros]);
    exit;
}

$stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = :email LIMIT 1");
$stmt->execute(['email' => $email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Mensagem genérica 
if (!$usuario || !password_verify($senha, $usuario['password'])) {
    echo json_encode(['success' => false, 'errors' => ['E-mail ou senha inválidos.']]);
    exit;
}

//Login 
$_SESSION['usuario']    = $usuario['id'];
$_SESSION['user_nome']  = $usuario['name'];
$_SESSION['user_email'] = $usuario['email'];

echo json_encode([
    'success'  => true,
    'message'  => 'Login realizado com sucesso!',
    'redirect' => 'index.php'
]);