<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?code=5');
    exit;
}

require_once 'conexao.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    // ID inválido, redireciona
    header('Location: listar_receitas.php');
    exit;
}

$conn = conectar_banco();

$sql = "DELETE FROM tb_receitas WHERE id = ? AND usuario_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['usuario_id']);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Sucesso na exclusão (opcional: adicionar mensagem via session)
} else {
    // Receita não encontrada ou não pertence ao usuário
    // (opcional: mensagem de erro)
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: listar_receitas.php');
exit;
