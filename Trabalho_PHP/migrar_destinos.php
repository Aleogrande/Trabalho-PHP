<?php
include 'dados/destinos.php'; 

$destinosComUsuario = [];


foreach ($destinos as $destino) {
    $destino['usuario'] = 'publico';
    $destinosComUsuario[] = $destino;
}

file_put_contents('dados/destinos.json', json_encode($destinosComUsuario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Destinos migrados com sucesso para destinos.json!";
