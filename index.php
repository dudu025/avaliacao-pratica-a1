<?php
session_start(); // Inicia sessão para controlar o usuário logado
require_once "conexao.php"; // Inclui conexão com banco

$erro = ""; // Variável para armazenar mensagem de erro
$nome = ""; // Variável para armazenar o nome digitado pelo usuário

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega o nome e senha do formulário, removendo espaços em branco
    $nome = trim($_POST["nome"] ?? "");
    $senha = trim($_POST["senha"] ?? "");

    if (empty($nome) || empty($senha)) {
        $erro = "Por favor, preencha nome e senha."; // Verifica campos vazios
    } else {
        $conn = conectar_banco(); // Conecta ao banco de dados

        // Prepara consulta usando nome e senha (texto puro)
        $sql = "SELECT id, senha FROM tb_usuarios WHERE nome = ? AND senha = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Liga os parâmetros para a consulta segura
            mysqli_stmt_bind_param($stmt, "ss", $nome, $senha);
            mysqli_stmt_execute($stmt); // Executa a consulta
            mysqli_stmt_store_result($stmt); // Armazena o resultado

            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Se encontrou usuário, pega os dados
                mysqli_stmt_bind_result($stmt, $id, $senha_bd);
                mysqli_stmt_fetch($stmt);

                // Cria variáveis de sessão para manter usuário logado
                $_SESSION["usuario_id"] = $id;
                $_SESSION["usuario_nome"] = $nome;

                header("Location: home.php"); // Redireciona para a home
                exit;
            } else {
                $erro = "Nome ou senha incorretos."; // Caso não encontre usuário
            }

            mysqli_stmt_close($stmt); // Fecha statement
        } else {
            $erro = "Erro no banco, tente novamente mais tarde."; // Erro na consulta
        }

        mysqli_close($conn); // Fecha conexão
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login - Sistema de Receitas</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <h2 class="mb-4 text-center">Login</h2>

        <?php if (!empty($erro)): ?>
            <!-- Exibe mensagem de erro, se houver -->
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required />
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <p class="mt-3 text-center">
            Não tem cadastro? <a href="cadastro_usuario.php">Clique aqui para se cadastrar</a>
        </p>
    </div>

    <!-- Script do Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
