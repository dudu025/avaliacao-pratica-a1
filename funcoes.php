<?php
// funcoes.php

// Verifica se o formulário foi enviado via POST
function form_nao_enviado() {
    return $_SERVER['REQUEST_METHOD'] !== 'POST';
}

// Verifica se os campos usuário ou senha estão vazios
function form_em_branco() {
    return empty($_POST['usuario']) || empty($_POST['senha']);
}

// Verifica se o campo tarefa está vazio
function tarefa_em_branco() {
    return empty($_POST['tarefa']);
}

// Exibe mensagens de erro baseadas no código enviado via GET
function tratar_erros() {
    if (!isset($_GET['code'])) {
        return;
    }

    $code = (int)$_GET['code'];
    $erro = "";

    switch($code) {
        case 0: 
            $erro = '<h3>Você não tem permissão para acessar a página de destino</h3>';
            break;
        case 1:
            $erro = '<h3>Usuário ou senha inválidos. Tente novamente</h3>';
            break;
        case 2:
            $erro = '<h2>Por favor, preencha todos os campos do formulário</h2>';
            break;
        case 3:
            $erro = '<h3>Erro ao executar consulta ao banco de dados. Tente novamente mais tarde, ou contate o suporte</h3>';
            break;
        default:
            $erro = "";
            break;
    }

    echo $erro;
}
?>
