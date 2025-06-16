<?php
// Inicia a sessão para verificar o usuário logado
session_start();

// Se não estiver logado, redireciona para login com código de erro
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?code=5');
    exit;
}

// Inclui a conexão com o banco de dados
require_once 'conexao.php';

// Inicializa variáveis para mensagens
$erro = "";
$sucesso = "";

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os dados enviados, eliminando espaços em branco
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    // Valida os campos obrigatórios
    if (empty($titulo) || empty($descricao)) {
        $erro = "Preencha todos os campos.";
    } else {
        // Conecta ao banco
        $conn = conectar_banco();

        // Prepara a query para inserir a receita
        $sql = "INSERT INTO tb_receitas (titulo, descricao, usuario_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $titulo, $descricao, $_SESSION['usuario_id']);

        // Executa e verifica sucesso
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Receita cadastrada com sucesso!";
        } else {
            $erro = "Erro ao cadastrar receita.";
        }

        // Fecha statement e conexão
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Cadastrar Receita</title>
<!-- Inclui CSS do Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Cadastrar Receita</h2>

    <!-- Exibe mensagem de erro, se houver -->
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>

    <!-- Exibe mensagem de sucesso, se houver -->
    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
    <?php endif; ?>

    <!-- Formulário para cadastro da receita -->
    <form method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" id="titulo" name="titulo" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Botões para enviar e voltar -->
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="home.php" class="btn btn-secondary ms-2">Voltar</a>
    </form>
</div>

<!-- Script do Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
