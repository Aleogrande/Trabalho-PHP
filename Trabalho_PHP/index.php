<?php

session_start();

// Carregar destinos do arquivo JSON
$arquivo = 'dados/destinos.json';
$destinos = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

// Se logado, mostrar destinos do usuário + públicos
if (isset($_SESSION['usuario'])) {
  $usuario = $_SESSION['usuario'];
  $destinos = array_filter($destinos, fn($d) => $d['usuario'] === $usuario || $d['usuario'] === 'publico');
} else {
  // Se não logado, mostrar apenas os públicos
  $destinos = array_filter($destinos, fn($d) => $d['usuario'] === 'publico');
}

// Filtro por categoria
$categoriaSelecionada = $_GET['categoria'] ?? '';
$categorias = array_unique(array_column($destinos, 'categoria'));

if (!empty($categoriaSelecionada)) {
  $destinos = array_filter($destinos, fn($d) => $d['categoria'] === $categoriaSelecionada);
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8">
 <title>Destinos Turísticos</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 <style>
  body {
   background-color: #f8f9fa;
  }
  .custom-img {
   height: 200px;
   object-fit: cover;
   transition: transform 0.3s ease;
  }
  .custom-img:hover {
   transform: scale(1.03);
  }
  .card {
   border: none;
   border-radius: 12px;
   transition: box-shadow 0.3s ease;
  }
  .card:hover {
   box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }
  .card-title {
   font-weight: 600;
  }
  .filter-bar {
   margin-top: 30px;
  }
 </style>
</head>
<body class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Destinos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item"><a class="nav-link active" href="index.php">Início</a></li>
              <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="protegido.php">Cadastre seu Destino</a></li>
            </ul>
          </div>
    </div>
  </nav>

<div class="container text-center">
 <h1 class="text-primary fw-bold">Destinos Turísticos</h1>
 <p class="lead">Explore lugares incríveis para viajar!</p>
</div>

<div class="container filter-bar d-flex justify-content-end">
 <form method="GET" class="d-flex align-items-center">
  <label for="categoria" class="me-2 mb-0"><strong>Categoria:</strong></label>
  <select name="categoria" id="categoria" class="form-select me-2" style="width: 200px;">
   <option value="">Todas</option>

   <?php

    foreach ($categorias as $cat) {
     $selected = ($categoriaSelecionada === $cat) ? 'selected' : '';
     echo "<option value=\"$cat\" $selected>$cat</option>";
    }

   ?>
  </select>
  <button type="submit" class="btn btn-outline-primary">
   <i class="fas fa-filter"></i> Filtrar
  </button>

 </form>
</div>



<div class="container py-5">
 <div class="row">
  <?php foreach ($destinos as $destino): ?>
   <div class="col-md-4 mb-4">
    <div class="card h-100">
     <?php
      $imagem = $destino['imagem'];

      $src = (str_starts_with($imagem, 'http')) ? $imagem : "imagens/$imagem";
     ?>

     <img src="<?= $src ?>" class="card-img-top img-fluid custom-img" alt="<?= $destino['nome'] ?>">
     <div class="card-body">
      <h5 class="card-title"><?= $destino['nome'] ?></h5>
      <p><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= $destino['localizacao'] ?></p>
      <p><strong>Categoria:</strong> <?= $destino['categoria'] ?></p>
      <p><strong>Preço:</strong> <?= $destino['preco'] ?></p>
      <button class="btn btn-primary btn-vermais w-100" data-id="<?= $destino['id'] ?>">
       <i class="fas fa-eye"></i> Ver mais
      </button>
     </div>
    </div>
   </div>
  <?php endforeach; ?>
 </div>
</div>


<div class="modal fade" id="detalhesModal" tabindex="-1" aria-labelledby="detalhesModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal-dialog-scrollable">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="detalhesModalLabel">Detalhes do Destino</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
   </div>
   <div class="modal-body" id="conteudo-detalhes">

    Carregando...

   </div>
  </div>
 </div>
</div>



<script>

document.querySelectorAll('.btn-vermais').forEach(btn => {
 btn.addEventListener('click', function () {
  const id = this.getAttribute('data-id');
  fetch(`detalhes.php?id=${id}`)
   .then(res => res.text())
   .then(html => {
    document.getElementById('conteudo-detalhes').innerHTML = html;
    new bootstrap.Modal(document.getElementById('detalhesModal')).show();
   });
 });
});

</script>


<footer class="bg-dark text-white text-center py-3 mt-auto">
 <p class="mb-0">Aventure-se com a gente &copy; <?= date('Y') ?> - Todos os direitos reservados.</p>
</footer>

</body>
</html>

