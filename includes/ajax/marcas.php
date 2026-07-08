<?php
//busca marcas carros

header('Content-Type: application/json');

$url = 'https://fipe.parallelum.com.br/api/v2/cars/brands';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$resposta = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erroCurl = curl_error($ch);
curl_close($ch);

if ($resposta === false || $statusCode !== 200) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'message' => 'Não foi possível consultar as marcas no momento. Tente novamente.'
    ]);
    exit;
}

$marcas = json_decode($resposta, true);

$resultado = array_map(function ($marca) {
    return [
        'codigo' => $marca['code'],
        'nome'   => $marca['name'],
    ];
}, $marcas ?? []);

echo json_encode(['success' => true, 'marcas' => $resultado]);