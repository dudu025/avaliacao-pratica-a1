-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/06/2025 às 08:19
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_sistema_receitas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_receitas`
--

CREATE TABLE `tb_receitas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_receitas`
--

INSERT INTO `tb_receitas` (`id`, `usuario_id`, `titulo`, `descricao`, `data_criacao`) VALUES
(1, 1, 'ovo frito', '1 ovo\r\n\r\nSal a gosto\r\n\r\n1 colher de sopa de óleo ou manteiga\r\n\r\nModo de Preparo:\r\n\r\nAqueça o óleo ou a manteiga em uma frigideira.\r\n\r\nQuebre o ovo cuidadosamente na frigideira.\r\n\r\nTempere com sal a gosto.\r\n\r\nFrite até que a clara esteja firme e a gema no ponto desejado.\r\n\r\nRetire da frigideira e sirva quente.', '2025-06-16 05:31:29'),
(2, 2, 'brigadeiro', 'Ingredientes:\r\n\r\n1 lata de leite condensado\r\n\r\n2 colheres de sopa de chocolate em pó (ou achocolatado)\r\n\r\n1 colher de sopa de manteiga\r\n\r\nModo de Preparo:\r\n\r\nEm uma panela, misture o leite condensado, o chocolate em pó e a manteiga.\r\n\r\nLeve ao fogo médio, mexendo sempre para não queimar.\r\n\r\nCozinhe até a mistura começar a desgrudar do fundo da panela (aproximadamente 10 minutos).\r\n\r\nDesligue o fogo e deixe esfriar um pouco antes de servir.', '2025-06-16 05:34:15'),
(3, 1, 'Miojo', 'Ingredientes:\r\n1 pacote de miojo\r\n500 ml de água\r\nTempero que vem no pacote\r\n\r\nModo de Preparo:\r\nFerva 500 ml de água em uma panela.\r\nQuando a água estiver fervendo, adicione o macarrão instantâneo.\r\nCozinhe por cerca de 3 minutos, mexendo de vez em quando para soltar os blocos de macarrão.\r\nDesligue o fogo e adicione o tempero que vem no pacote. Misture bem.', '2025-06-16 06:12:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`id`, `nome`, `senha`, `email`) VALUES
(1, 'Eduardo', 'edu123', 'eduardo@gmail.com'),
(2, 'Fulano', 'fulano123', 'fulano@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_receitas`
--
ALTER TABLE `tb_receitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`nome`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_receitas`
--
ALTER TABLE `tb_receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_receitas`
--
ALTER TABLE `tb_receitas`
  ADD CONSTRAINT `tb_receitas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
