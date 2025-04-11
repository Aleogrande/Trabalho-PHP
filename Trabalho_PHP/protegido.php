<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $preco = $_POST['preco'];

  $novo = [
    "id" => time(),
    "nome" => $_POST['nome'],
    "localizacao" => $_POST['localizacao'],
    "categoria" => $_POST['categoria'],
    'preco' => 'R$ ' . $preco,
    "descricao" => $_POST['descricao'],
    "detalhes" => $_POST['detalhes'],
    'imagem' => $_POST['imagem'],
    "usuario" => $_SESSION['usuario']
  ];

  $arquivo = "dados/destinos.json";
  $destinos = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

  $destinos[] = $novo;

  file_put_contents($arquivo, json_encode($destinos, JSON_PRETTY_PRINT));

  header('Location: protegido.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Seu Destino</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Destinos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
        <li class="nav-item"><a class="nav-link" href="protegido.php">Cadastre seu Destino</a></li>
      </ul>
      <span class="navbar-text text-white me-2">Olá, <?= $_SESSION["usuario"] ?>!</span>
    </div>
  </div>
</nav>

<div class="container mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-primary">Adicione um novo destino</h2>
    <a href="protegido.php?logout=1" class="btn btn-danger">Sair</a>
  </div>

  <p class="lead text-center">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']); ?>!</p>

  <form method="post" class="row g-4 justify-content-center">
    <div class="col-md-6">
      <label class="form-label">Nome do Destino</label>
      <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Localização</label>
      <input type="text" name="localizacao" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Categoria</label>
      <input type="text" name="categoria" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Preço</label>
      <div class="input-group">
        <span class="input-group-text">R$</span>
        <input type="text" name="preco" class="form-control" placeholder="0,00" required>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label">Descrição</label>
      <textarea name="descricao" class="form-control" required></textarea>
    </div>
    <div class="col-12">
      <label class="form-label">Detalhes</label>
      <textarea name="detalhes" class="form-control" required></textarea>
    </div>
    <div class="col-12">
      <label for="imagem" class="form-label">URL da Imagem</label>
      <input type="text" name="imagem" id="imagem" class="form-control" required>
    </div>
    <div class="col-md-6">
      <button class="btn btn-success w-100" type="submit">
        <i class="fas fa-plus-circle"></i> Cadastrar
      </button>
    </div>
  </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-auto">
  <p class="mb-0">Aventure-se com a gente &copy; <?= date('Y') ?> - Todos os direitos reservados.</p>
</footer>

</body>
</html>
