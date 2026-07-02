<?php 
session_start();

require __DIR__ . '/../db/conn.php'; 

header('Content-Type: application/json');

$nome           = trim($_POST['nome'] ?? '');
$email          = trim($_POST['email'] ?? '');
$senha          = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmar_senha'] ?? '';

$erros = [];

if ($nome === '') {
    $erros[] = 'Informe o nome.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'E-mail inválido.';
}

// Senha: mínimo 8 caracteres, 1 maiúscula, 1 minúscula, 1 número
$regraSenha = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
if (!preg_match($regraSenha, $senha)) {
    $erros[] = 'A senha precisa ter no mínimo 8 caracteres, incluindo letra maiúscula, minúscula e número.';
}

if ($senha !== $confirmarSenha) {
    $erros[] = 'As senhas não conferem.';
}

if (empty($erros)) {
    // Checa e-mail duplicado de novo (proteção contra corrida de requisições)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $erros[] = 'Esse e-mail já está cadastrado.';
    }
}

if (!empty($erros)) {
    echo json_encode(['success' => false, 'errors' => $erros]);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email, password, photo) VALUES (:nome, :email, :senha, NULL)"
    );
    $stmt->execute([
        'nome'  => $nome,
        'email' => $email,
        'senha' => $senhaHash,
    ]);

    $usuario = $pdo->prepare("SELECT * FROM USERS where email = :email");
    $usuario->execute(['email' => $email]);
    $user = $usuario->fetch(PDO::FETCH_ASSOC);

    // ---- Login automático ----
    $_SESSION['usuario']    = $user['id'];
    $_SESSION['user_nome']  = $nome;
    $_SESSION['user_email'] = $email;

    echo json_encode([
        'success'  => true,
        'message'  => 'Cadastro realizado com sucesso!',
        'redirect' => 'index.php'
    ]);
} catch (PDOException $e) {
    // Código 23000 = violação de constraint (ex.: UNIQUE de email)
     if ($e->getCode() === '23000') {
        echo json_encode(['success' => false, 'errors' => ['Esse e-mail já está cadastrado.']]);
    } else {
        echo json_encode(['success' => false, 'errors' => ['Erro ao cadastrar. Tente novamente.']]);
    }
}