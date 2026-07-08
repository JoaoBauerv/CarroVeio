<?php
// busca modelos carros
header('Content-Type: application/json');

$codigoMarca = trim($_GET['marca'] ?? '');

if ($codigoMarca === '' || !ctype_digit($codigoMarca)) {
    echo json_encode(['success' => false, 'message' => 'Marca inválida.']);
    exit;
}

$url = "https://fipe.parallelum.com.br/api/v2/cars/brands/{$codigoMarca}/models";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$resposta = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($resposta === false || $statusCode !== 200) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'message' => 'Não foi possível consultar os modelos no momento. Tente novamente.'
    ]);
    exit;
}

$modelos = json_decode($resposta, true);

$resultado = array_map(function ($modelo) {
    return [
        'codigo' => $modelo['code'],
        'nome'   => $modelo['name'],
    ];
}, $modelos ?? []);

echo json_encode(['success' => true, 'modelos' => $resultado]);