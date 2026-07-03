<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
 
session_start();
 
// Limpa todas as variáveis da sessão
$_SESSION = [];
 
// Remove o cookie de sessão do navegador (boa prática de segurança)
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}
 
// Destrói a sessão no servidor
session_destroy();
 
// Redireciona para a página de login (ajuste o caminho se necessário)
header('Location: ' . $_ENV['BASE_URL'] . '/index.php?secao=login');
exit;
