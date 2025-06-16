<?php
// Função responsável por realizar a conexão com o banco de dados
function conectar_banco() {
   
    $servidor = 'localhost';  
    $usuario  = 'root';        
    $senha    = '';            
    $banco    = 'db_sistema_receitas'; 

    // Tenta realizar a conexão
    $conn = mysqli_connect($servidor, $usuario, $senha, $banco);

    // Se ocorrer algum erro na conexão, o sistema exibe a mensagem e para tudo
    if (!$conn) {
        exit("Erro na conexão: " . mysqli_connect_error());
    }

    // Se deu certo, retorna a conexão para ser utilizada em outros arquivos
    return $conn;
}
?>
