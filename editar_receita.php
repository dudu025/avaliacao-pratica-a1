<?php
session_start();

// Verifica se o usuário está logado; se não, redireciona para login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?code=5');
    exit;
}

require_once 'conexao.php'; // Inclui conexão com o banco

$conn = conectar_banco(); // Abre conexão

// Pega o ID da receita da URL (GET), converte para inteiro
$id = intval($_GET['id'] ?? 0);

$erro = "";
$sucesso = "";

// Busca a receita pelo ID e do usuário logado
$sql = "SELECT titulo, descricao FROM tb_receitas WHERE id = ? AND usuario_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['usuario_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $titulo, $descricao);

// Se a receita não existe ou não pertence ao usuário, redireciona para lista
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: listar_receitas.php');
    exit;
}
mysqli_stmt_close($stmt);

// Se enviou o formulário (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novo_titulo = trim($_POST['titulo'] ?? '');
    $nova_descricao = trim($_POST['descricao'] ?? '');

    // Validação dos campos
    if (empty($novo_titulo) || empty($nova_descricao)) {
        $erro = "Preencha todos os campos.";
    } else {
        // Atualiza a receita no banco
        $sql = "UPDATE tb_receitas SET titulo = ?, descricao = ? WHERE id = ? AND usuario_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssii', $novo_titulo, $nova_descricao, $id, $_SESSION['usuario_id']);

        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Receita atualizada com sucesso!";
            // Atualiza as variáveis para mostrar no formulário
            $titulo = $novo_titulo;
            $descricao = $nova_descricao;
        } else {
            $erro = "Erro ao atualizar receita.";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn); // Fecha conexão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Editar Receita - Sistema de Receitas</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Editar Receita</h2>

    <!-- Exibe mensagens de erro ou sucesso -->
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
    <?php endif; ?>

    <!-- Formulário de edição -->
    <form method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlspecialchars($titulo); ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" class="form-control" required><?php echo htmlspecialchars($descricao); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="listar_receitas.php" class="btn btn-secondary ms-2">Voltar</a>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
