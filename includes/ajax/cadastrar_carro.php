<?php
session_start();

require __DIR__ . '/../db/conn.php'; 

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'errors' => ['Você precisa estar logado para cadastrar um carro.']]);
    exit;
}

$marca         = trim($_POST['marca'] ?? '');
$modelo        = trim($_POST['modelo'] ?? '');
$ano           = trim($_POST['ano'] ?? '');
$placa         = trim($_POST['placa'] ?? '');
$cor           = trim($_POST['cor'] ?? '');
$quilometragem = trim($_POST['quilometragem'] ?? '');

$erros = [];

if ($marca === '') {
    $erros[] = 'Informe a marca.';
}

if ($modelo === '') {
    $erros[] = 'Informe o modelo.';
}

if ($ano === '' || !ctype_digit($ano) || (int) $ano < 1900 || (int) $ano > 2100) {
    $erros[] = 'Informe um ano válido.';
}

if ($quilometragem !== '' && (!ctype_digit($quilometragem) || (int) $quilometragem < 0)) {
    $erros[] = 'Quilometragem inválida.';
}

// verificação de modelo e marca via api
if ($marca !== '' && $modelo !== '') {
    $marcaValida = false;

    $chMarcas = curl_init('https://fipe.parallelum.com.br/api/v2/cars/brands');
    curl_setopt($chMarcas, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chMarcas, CURLOPT_TIMEOUT, 10);
    $respMarcas = curl_exec($chMarcas);
    $statusMarcas = curl_getinfo($chMarcas, CURLINFO_HTTP_CODE);
    curl_close($chMarcas);

    if ($respMarcas !== false && $statusMarcas === 200) {
        $marcas = json_decode($respMarcas, true) ?? [];
        $marcaEncontrada = null;

        foreach ($marcas as $m) {
            if (mb_strtolower($m['name']) === mb_strtolower($marca)) {
                $marcaEncontrada = $m;
                break;
            }
        }

        if ($marcaEncontrada === null) {
            $erros[] = 'Marca não reconhecida.';
        } else {
            $chModelos = curl_init("https://fipe.parallelum.com.br/api/v2/cars/brands/{$marcaEncontrada['code']}/models");
            curl_setopt($chModelos, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chModelos, CURLOPT_TIMEOUT, 10);
            $respModelos = curl_exec($chModelos);
            $statusModelos = curl_getinfo($chModelos, CURLINFO_HTTP_CODE);
            curl_close($chModelos);

            if ($respModelos !== false && $statusModelos === 200) {
                $modelos = json_decode($respModelos, true) ?? [];
                $modeloValido = false;

                foreach ($modelos as $mo) {
                    if (mb_strtolower($mo['name']) === mb_strtolower($modelo)) {
                        $modeloValido = true;
                        break;
                    }
                }

                if (!$modeloValido) {
                    $erros[] = 'Modelo não reconhecido para essa marca.';
                }
            }
        }
    }
}

$caminhoFoto = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        $erros[] = 'Erro ao enviar a foto. Tente novamente.';
    } else {
        $tiposPermitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $tipoReal = mime_content_type($_FILES['foto']['tmp_name']);

        $tamanhoMaximo = 5 * 1024 * 1024; // 5MB

        if (!isset($tiposPermitidos[$tipoReal])) {
            $erros[] = 'Formato de imagem inválido. Use JPG, PNG ou WEBP.';
        } elseif ($_FILES['foto']['size'] > $tamanhoMaximo) {
            $erros[] = 'A imagem deve ter no máximo 5MB.';
        } else {
            $extensao   = $tiposPermitidos[$tipoReal];
            $nomeArquivo = uniqid('carro_', true) . '.' . $extensao;

            //pasta fisica para salvar a foto
            $pastaDestino = __DIR__ . '/../../img/carros/';

            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0755, true);
            }

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $pastaDestino . $nomeArquivo)) {
                //caminho para salvar no bd
                $caminhoFoto = 'img/carros/' . $nomeArquivo;
            } else {
                $erros[] = 'Não foi possível salvar a foto. Tente novamente.';
            }
        }
    }
}

if (!empty($erros)) {
    echo json_encode(['success' => false, 'errors' => $erros]);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO cars (user_id, marca, modelo, ano, placa, cor, quilometragem, foto)
         VALUES (:user_id, :marca, :modelo, :ano, :placa, :cor, :quilometragem, :foto)"
    );
    $stmt->execute([
        'user_id'        => $_SESSION['usuario'],
        'marca'          => $marca,
        'modelo'         => $modelo,
        'ano'            => (int) $ano,
        'placa'          => $placa !== '' ? $placa : null,
        'cor'            => $cor !== '' ? $cor : null,
        'quilometragem'  => $quilometragem !== '' ? (int) $quilometragem : null,
        'foto'           => $caminhoFoto,
    ]);

    echo json_encode([
        'success'  => true,
        'message'  => 'Carro cadastrado com sucesso!',
        'redirect' => 'index.php?secao=perfil'
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'errors' => ['Erro ao salvar o carro. Tente novamente.']]);
}