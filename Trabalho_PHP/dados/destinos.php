<?php

session_start();
$usuarioLogado = $_SESSION['usuario'] ?? null;
$destinos = [];

if (file_exists('dados/destinos.json')) {
    $todos = json_decode(file_get_contents('dados/destinos.json'), true);

    if ($usuarioLogado) {
        // Mostra os destinos do usuário logado + os públicos
        foreach ($todos as $d) {
            if ($d['usuario'] === $usuarioLogado || $d['usuario'] === 'publico') {
                $destinos[] = $d;
            }
        }
    } else {
        // Usuário não logado, mostra apenas os destinos públicos
        foreach ($todos as $d) {
            if ($d['usuario'] === 'publico') {
                $destinos[] = $d;
            }
        }
    }
}
?>
