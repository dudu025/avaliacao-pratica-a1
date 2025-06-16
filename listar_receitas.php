<?php
session_start();

// Verifica se o usuário está logado, se não, redireciona para login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?code=5');
    exit;
}

require_once 'conexao.php'; // Inclui arquivo de conexão

$conn = conectar_banco(); // Conecta ao banco

// Busca todas as receitas do usuário logado
$sql = "SELECT id, titulo, descricao FROM tb_receitas WHERE usuario_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['usuario_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Minhas Receitas - Sistema de Receitas</title>
<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 900px;">
    <h2 class="mb-4">Minhas Receitas</h2>

    <!-- Botões de navegação -->
    <div class="mb-3">
        <a href="cadastro_receita.php" class="btn btn-success me-2">Cadastrar Nova Receita</a>
        <a href="home.php" class="btn btn-secondary">Home</a>
    </div>

    <!-- Tabela de receitas -->
    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th style="width: 150px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['descricao'])); ?></td>

                    <td>
                        <a href="editar_receita.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="excluir_receita.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Tem certeza que deseja excluir esta receita?');">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Nenhuma receita cadastrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fecha a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
