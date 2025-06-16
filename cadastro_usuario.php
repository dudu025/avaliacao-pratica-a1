<?php
require_once "conexao.php"; // Inclui conexão com banco

$erro = ""; // Mensagem de erro
$sucesso = ""; // Mensagem de sucesso
$nome = ""; // Guarda o nome digitado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega dados do formulário e tira espaços em branco
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = trim($_POST["senha"] ?? "");
    $senha_confirma = trim($_POST["senha_confirma"] ?? "");

    // Verifica campos vazios e se as senhas são iguais
    if (empty($nome) || empty($email) || empty($senha) || empty($senha_confirma)) {
        $erro = "Preencha todos os campos.";
    } elseif ($senha !== $senha_confirma) {
        $erro = "As senhas não coincidem.";
    } else {
        $conn = conectar_banco(); // Conecta ao banco

        // Verifica se já existe usuário com o mesmo nome
        $sql_check = "SELECT id FROM tb_usuarios WHERE nome = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $nome);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $erro = "Esse nome já está em uso."; // Nome já cadastrado
        } else {
            // Insere novo usuário (senha em texto puro conforme pedido)
            $sql_insert = "INSERT INTO tb_usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sss", $nome, $email, $senha);

            if (mysqli_stmt_execute($stmt_insert)) {
                $sucesso = "Cadastro realizado com sucesso! Volte para a tela de login e acesse sua conta.";
                $nome = "";
                $email = "";
            } else {
                $erro = "Erro ao cadastrar, tente novamente.";
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);
        mysqli_close($conn); // Fecha conexão
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro - Sistema de Receitas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 480px;">
    <h2 class="mb-4">Cadastro de Usuário</h2>

    <?php if (!empty($erro)): ?>
        <!-- Exibe mensagem de erro -->
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <!-- Exibe mensagem de sucesso -->
        <div class="alert alert-success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <div class="mb-3">
            <label for="senha_confirma" class="form-label">Confirme a Senha</label>
            <input type="password" class="form-control" id="senha_confirma" name="senha_confirma" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
    </form>

    <p class="mt-3 text-center">
        <a href="index.php">Voltar ao Login</a>
    </p>
</div>

<!-- Bootstrap JS Bundle (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
