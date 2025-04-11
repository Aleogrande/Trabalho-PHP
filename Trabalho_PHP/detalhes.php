<?php
include 'dados/destinos.php';
include 'funcoes.php';

$id = $_GET['id'] ?? null;
$destino = buscarDestinoPorId($destinos, $id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Destino</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body class="bg-light">




    <div class="container py-5">
        <?php if ($destino): ?>
          <div class="card mb-5 shadow-sm">
          <?php
      $imagem = $destino['imagem'];
      $src = (str_starts_with($imagem, 'http')) ? $imagem : "imagens/$imagem";
    ?>
    <img src="<?= $src ?>" class="card-img-top" alt="<?= $destino['nome'] ?>">
    <div class="card-body">
        <h1 class="card-title"><?php echo $destino['nome']; ?></h1>
        <p><strong>Localização:</strong> <?php echo $destino['localizacao']; ?></p>
        <p><strong>Categoria:</strong> <?php echo $destino['categoria']; ?></p>
        <p><strong>Preço:</strong> <?php echo $destino['preco']; ?></p>
        <p class="card-text"><?php echo $destino['detalhes']; ?></p>
    </div>
</div>


            <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
        <?php else: ?>
            <h1 class="mb-4">Destino não encontrado.</h1>
            <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
        <?php endif; ?>
    </div>
</body>
</html>
