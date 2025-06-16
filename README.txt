Tema escolhido:
Sistema de cadastro e gerenciamento de receitas com autenticação de usuários.

Resumo do funcionamento:
Este sistema permite que usuários façam login, cadastrem novos usuários, além de cadastrar,
visualizar, editar e excluir suas receitas pessoais.
Cada usuário possui sua própria lista de receitas protegida por autenticação.
A interface utiliza Bootstrap para estilização básica.

Após cadastrar um novo usuário, é necessário voltar para a tela de login
para acessar o sistema com o usuário recém-criado.

Usuários para teste:
- Usuário: Eduardo
  Senha: edu123
- Usuário: Fulano
  Senha: fulano123

Passos para instalação do banco de dados:
1. Abra o phpMyAdmin pelo XAMPP.
2. Crie um banco de dados chamado db_sistema_receitas.
3. Importe o arquivo SQL fornecido para criar as tabelas e inserir dados de teste.
4. Caso necessário, ajuste as credenciais no arquivo conexao.php.
