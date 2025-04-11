<?php
session_start();

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($usuario) && !empty($senha)) {
        $usuarios = [];

        // Lê o arquivo se já existir
        if (file_exists('dados/usuarios.json')) {
            $usuarios = json_decode(file_get_contents('dados/usuarios.json'), true);
        }

        // Verifica se o usuário já existe
        if (array_key_exists($usuario, $usuarios)) {
            $mensagem = "Usuário já cadastrado!";
        } else {
            // Salva com hash seguro
            $usuarios[$usuario] = password_hash($senha, PASSWORD_DEFAULT);
            file_put_contents('dados/usuarios.json', json_encode($usuarios, JSON_PRETTY_PRINT));
            $mensagem = "Cadastro realizado com sucesso!";
        }
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Destinos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
    <h2 class="h2 mb-4 text-center">Cadastro de Usuário</h2>

    <?php if (!empty($mensagem)): ?>
      <div class="alert alert-info"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="POST" class="mx-auto" style="max-width: 400px;">
      <div class="mb-3">
        <label for="usuario" class="form-label">Nome de Usuário</label>
        <input type="text" name="usuario" id="usuario" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" name="senha" id="senha" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
      <a href="login.php" class="d-block mt-3 text-center">Já tem uma conta? Faça login</a>
    </form>
  </div>
</body>
</html>
