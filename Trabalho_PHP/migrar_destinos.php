<?php
// Carrega os destinos do arquivo destinos.php (padrão da aplicação)
include 'dados/destinos.php'; // Isso define $destinos com os dados iniciais

$destinosComUsuario = [];

// Adiciona a chave "usuario" => "publico" em todos os destinos
foreach ($destinos as $destino) {
    $destino['usuario'] = 'publico';
    $destinosComUsuario[] = $destino;
}

// Salva no arquivo destinos.json
file_put_contents('dados/destinos.json', json_encode($destinosComUsuario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Destinos migrados com sucesso para destinos.json!";
