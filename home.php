<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?code=5');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Home - Sistema de Receitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="mb-4">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h2>

        <div class="list-group">
            <a href="cadastro_receita.php" class="list-group-item list-group-item-action">Cadastrar Receita</a>
            <a href="listar_receitas.php" class="list-group-item list-group-item-action">Listar Receitas</a>
            <a href="logout.php" class="list-group-item list-group-item-action text-danger">Sair</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
