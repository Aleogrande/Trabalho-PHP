
<?php
session_start();
$logado = isset($_SESSION["usuario"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <?php if ($logado): ?>
          <li class="nav-item"><a class="nav-link" href="protegido.php">Cadastre seu Destino </a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
      <?php if ($logado): ?>
        <span class="navbar-text text-white me-2">Olá, <?= $_SESSION["usuario"] ?>!</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h1 class="h2 mb-4">Login</h1>
                  <form method="POST" action="verifica_login.php" class="mx-auto" style="max-width: 400px;">
                  <div class="mb-3">
                     <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" required></div>
                  <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                  </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar
                    </button>
                  <div class="text-center mt-3">
                    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p></div>
                  </form>
                  <?php if (isset($_GET["erro"])): ?>
                    <div class="alert alert-danger mt-3">Usuário ou senha inválidos.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container flex-grow-1"></div>
  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">Aventure-se com a gente &copy; <?= date('Y') ?> - Todos os direitos reservados.</p>
  </footer>
</body>

</html>
