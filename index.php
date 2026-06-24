<?php

require __DIR__ . '/includes/db/conn.php';

//url amigavel
$secao = $_REQUEST["secao"] ?? '';
$secaoE = explode("/", $secao);

$arquivo = $secaoE["0"] ?? '';
$arquivo2 = $secaoE["1"] ?? '';
$arquivo3 = $secaoE["2"] ?? '';
$arquivo4 = $secaoE["3"] ?? '';
$arquivo5 = $secaoE["4"] ?? '';
var_dump($arquivo);
//$_SESSION['usuario'] = 1;

$url_base = 'http://localhost/CarroVeio';
?>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>

<style>
html, body {
    height: 100%;
    margin: 0;
}

.body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main {
    flex: 1;
}
</style>

<div class="body">
    
    <?php include 'header.php'; ?>

    <div role="main" class="main" >
        <?php
            if ((isset($arquivo)) && ($arquivo != '') && is_file("conteudo/inc_" . $arquivo . ".php")) {
                include "conteudo/inc_" . $arquivo . ".php"; // se o arquivo não existir, vai para a página inicial
            } else {
                if (!isset($_SESSION['usuario'])) {
                    include 'landing.php';
                }else{
                    include "inc_inicio.php"; // se o arquivo não existir, vai para a página inicial
                }
            }
        ?>
    </div>

    <?php include "footer.php" ?>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>