<?php
// Seções que podem ser acessadas sem estar logado
$secoesPublicas = ['login', 'cadastro', ''];

$secao = $_REQUEST['secao'] ?? '';

$estaLogado    = isset($_SESSION['usuario']);
$secaoEPublica = in_array($secao, $secoesPublicas, true);

if (!$estaLogado && !$secaoEPublica) {
    header('Location: ' . $url_base . '/index.php?secao=login');
    exit;
}
?>