<?php
require_once 'funcoes.php';

// Verifica se o formulário foi enviado via POST
if (form_nao_enviado()) {
    header('Location: index.php?code=0'); // Acesso direto não permitido
    exit;
}

// Verifica se algum campo está em branco
if (form_em_branco()) {
    header('Location: index.php?code=2'); // Campos vazios
    exit;
}

// Pega os dados do formulário
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Conecta ao banco de dados
require_once 'conexao.php';
$conn = conectar_banco();

// Prepara a consulta para buscar usuário com usuário e senha exatos
$query = "SELECT id, usuario, senha, email FROM tb_usuarios WHERE usuario = ? AND senha = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    header('Location: index.php?code=3'); // Erro na preparação da query
    exit;
}

mysqli_stmt_bind_param($stmt, 'ss', $usuario, $senha);

// Executa a consulta
if (!mysqli_stmt_execute($stmt)) {
    header('Location: index.php?code=4'); // Erro na execução da query
    exit;
}

mysqli_stmt_store_result($stmt);
$linhas = mysqli_stmt_num_rows($stmt);

// Se não encontrou usuário, login inválido
if ($linhas <= 0) {
    header('Location: index.php?code=1'); // Usuário ou senha inválidos
    exit;
}

// Se encontrou, pega os dados do usuário
mysqli_stmt_bind_result($stmt, $id, $usuario, $senha, $email);
mysqli_stmt_fetch($stmt);

// Inicia sessão e armazena os dados do usuário
session_start();
$_SESSION['id'] = $id;
$_SESSION['usuario'] = $usuario;
$_SESSION['senha'] = $senha;
$_SESSION['email'] = $email;

// Redireciona para a página principal (home)
header('Location: home.php');
exit;
?>
