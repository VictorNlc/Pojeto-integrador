-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Dez-2024 às 21:11
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotos_feed`
--

CREATE TABLE `fotos_feed` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `caminho_foto` varchar(255) DEFAULT NULL,
  `descricao` text NOT NULL,
  `data_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `fotos_feed`
--

INSERT INTO `fotos_feed` (`id`, `usuario_id`, `caminho_foto`, `descricao`, `data_upload`) VALUES
(23, 25, 'uploads/feed/integracao3.jpg', 'teste', '2024-12-01 14:53:00'),
(24, 25, 'uploads/feed/WhatsApp Image 2024-10-28 at 09.38.48.jpeg', 'jkbjkbui', '2024-12-01 14:59:16'),
(25, 26, 'uploads/feed/cat.jpg', 'testando, os id dos usuarios de sessão e editar12', '2024-12-01 18:02:03'),
(26, 26, 'uploads/feed/integracao5.jpg', 'dcvxv', '2024-12-01 18:52:29'),
(27, 26, 'uploads/feed/corporacao (1).png', 'etcfb', '2024-12-01 19:02:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `login` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(40) DEFAULT NULL,
  `descricao` text NOT NULL,
  `foto_perfil` varchar(225) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`ID`, `login`, `email`, `senha`, `descricao`, `foto_perfil`) VALUES
(0000000024, 'victor', 'ADMIN', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', ''),
(0000000025, 'te', 'te@gmail.com', '33e9505d12942e8259a3c96fb6f88ed325b95797', '', 'uploads/perfil/WhatsApp Image 2024-10-28 at 09.38.48.jpeg'),
(0000000026, 'te1', 'te1@gmail.com', 'c3ff95b2f90c77ee4c0ce59ab63e450e94c3f5a0', '', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `fotos_feed`
--
ALTER TABLE `fotos_feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fotos_feed`
--
ALTER TABLE `fotos_feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
