-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 17/05/2025 às 14:31
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
-- Banco de dados: `controle_estoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `qtde_estoque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome_produto`, `qtde_estoque`) VALUES
(1, 'Teclado Gamer', 52),
(2, 'Mouse sem fio', 10),
(3, 'Monitor Full HD', 8);

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto_previsao_estoque_usuarios`
--

CREATE TABLE `projeto_previsao_estoque_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `projeto_previsao_estoque_usuarios`
--

INSERT INTO `projeto_previsao_estoque_usuarios` (`id`, `usuario`, `senha`) VALUES
(1, 'admin', '$2y$10$Q4Fy5o.H30nn7S8xdY/lCelchnqoPmlnM2G2bJzTAfC83d5pkP69y');

-- --------------------------------------------------------

--
-- Estrutura para tabela `relatorio_reposicao`
--

CREATE TABLE `relatorio_reposicao` (
  `id_produto` int(11) NOT NULL,
  `qtde_vend_3meses` int(11) DEFAULT NULL,
  `qtde_estoque` int(11) DEFAULT NULL,
  `qtde_arepor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
(1, 'admin', '$2y$10$EM8OfiM0FAf8WC8qUPjwW.0tc21qSYZeM8B0GuRLpWkkfYHKd.5My');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `qtde_vendida` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `data_venda` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `nome_produto`, `qtde_vendida`, `id_produto`, `data_venda`) VALUES
(1, 'Teclado Gamer', 15, NULL, '2024-12-01'),
(2, 'Mouse sem fio', 10, NULL, '2024-12-01'),
(3, 'Monitor Full HD', 5, NULL, '2024-12-01'),
(4, 'Teclado Gamer', 5, 1, '2024-12-01'),
(5, 'Mouse sem fio', 10, 2, '2024-12-01'),
(6, 'Mouse sem fio', 10, 2, '0000-00-00'),
(7, 'Mouse sem fio', 1, 2, '0000-00-00'),
(8, 'Mouse sem fio', 1, 2, '2025-03-10'),
(9, 'Monitor Full HD', 5, 3, '2025-03-09'),
(10, 'Mouse sem fio', 22, 2, '2025-03-09'),
(11, 'Mouse sem fio', 7, 2, '2025-03-09'),
(12, 'Mouse sem fio', 10, 2, '2024-12-20'),
(13, 'Monitor Full HD', 12, 3, '2024-12-22'),
(14, 'Mouse sem fio', 2, 2, '2024-12-20'),
(15, 'Mouse sem fio', 1, 2, '2025-03-09'),
(16, 'Mouse sem fio', 40, 2, '2025-04-01'),
(17, 'controle lg', 5, 4, '2025-04-04'),
(18, 'Mouse sem fio', 1, 2, '2025-04-04'),
(19, 'controle lg', 2, 4, '2025-04-04'),
(20, 'controle lg', 2, 4, '2025-04-04');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `projeto_previsao_estoque_usuarios`
--
ALTER TABLE `projeto_previsao_estoque_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices de tabela `relatorio_reposicao`
--
ALTER TABLE `relatorio_reposicao`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `projeto_previsao_estoque_usuarios`
--
ALTER TABLE `projeto_previsao_estoque_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
