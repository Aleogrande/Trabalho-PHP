<?php
session_start();

$usuario = $_POST["usuario"] ?? "";
$senha = $_POST["senha"] ?? "";

$usuarios = json_decode(file_get_contents("dados/usuarios.json"), true);

if (isset($usuarios[$usuario]) && password_verify($senha, $usuarios[$usuario])) {
    $_SESSION["usuario"] = $usuario;
    header("Location: protegido.php");
    exit();
} else {
    header("Location: login.php?erro=1");
    exit();
}
