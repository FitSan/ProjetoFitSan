-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 01-Out-2018 às 03:03
-- Versão do servidor: 5.5.61-0ubuntu0.14.04.1
-- versão do PHP: 5.5.9-1ubuntu4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `FitSan`
--

-- --------------------------------------------------------

--oi
-- Estrutura da tabela `ativ_extras`
--

CREATE TABLE IF NOT EXISTS `ativ_extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `ativ_extras`
--

INSERT INTO `ativ_extras` (`id`, `datahora`, `titulo`, `texto`, `aluno_id`) VALUES
(1, '2018-09-17 23:23:41', 'Caminhada na praia', 'caminhei', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativ_extras_exercicios`
--

CREATE TABLE IF NOT EXISTS `ativ_extras_exercicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ativ_extras_id` int(11) DEFAULT NULL,
  `exercicio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `ativ_extras_exercicios`
--

INSERT INTO `ativ_extras_exercicios` (`id`, `ativ_extras_id`, `exercicio`) VALUES
(1, 1, 'Caminhada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dica`
--

CREATE TABLE IF NOT EXISTS `dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profissional_nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `data_envio` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `dica`
--

INSERT INTO `dica` (`id`, `texto`, `profissional_nome`, `profissional_id`, `data_envio`) VALUES
(1, 'Minha Cara de linda!', 'Karen', 1, '2018-09-17 19:18:33'),
(2, 'Caminhe sempre que puder. ', 'Karen', 1, '2018-09-30 18:41:26'),
(4, 'foto', 'Charles', 4, '2018-09-24 22:11:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais`
--

CREATE TABLE IF NOT EXISTS `informacoes_adicionais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saude` text COLLATE utf8_unicode_ci,
  `medico` text COLLATE utf8_unicode_ci,
  `alergia` text COLLATE utf8_unicode_ci,
  `medicamento` text COLLATE utf8_unicode_ci,
  `gruposangue` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doador` enum('SIM','NAO') COLLATE utf8_unicode_ci DEFAULT NULL,
  `academia_frequentada` text COLLATE utf8_unicode_ci,
  `academia_atual` text COLLATE utf8_unicode_ci,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `informacoes_adicionais`
--

INSERT INTO `informacoes_adicionais` (`id`, `saude`, `medico`, `alergia`, `medicamento`, `gruposangue`, `doador`, `academia_frequentada`, `academia_atual`, `aluno_id`) VALUES
(1, 'Gastrite', 'Gastrite por stress', 'Alergia a Camarão', 'Droxane', 'A+', 'SIM', 'Atletic', 'Podium', 2),
(2, 'Pressão Arterial', 'Retirada de um câncer de pele na orelha, rompimento de tendão do pé.', 'Sulfa', 'Vários', '0+', 'SIM', 'Nunca frequentou', 'Nenhuma.', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais_contatos`
--

CREATE TABLE IF NOT EXISTS `informacoes_adicionais_contatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Extraindo dados da tabela `informacoes_adicionais_contatos`
--

INSERT INTO `informacoes_adicionais_contatos` (`id`, `tipo`, `nome`, `telefone`, `informacoes_adicionais_id`) VALUES
(27, 'Cônjuge', 'Neide Guzzatti Konig', '(48)3626-7585', 2),
(28, 'Filho(a)', 'Karen Guzzatti Konig', '(48)991705657', 2),
(35, 'Cônjuge', 'Karen Guzzatti Konig', '(48)3626-7585', 1),
(36, 'Mãe', 'Elizete Pereira', '(48)0000-0000', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais_exercicios`
--

CREATE TABLE IF NOT EXISTS `informacoes_adicionais_exercicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exercicios` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=125 ;

--
-- Extraindo dados da tabela `informacoes_adicionais_exercicios`
--

INSERT INTO `informacoes_adicionais_exercicios` (`id`, `exercicios`, `informacoes_adicionais_id`) VALUES
(106, 'Natação', 2),
(124, 'Futebol', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais_medidas`
--

CREATE TABLE IF NOT EXISTS `informacoes_adicionais_medidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `altura` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,3) DEFAULT NULL,
  `massa_magra` decimal(5,3) DEFAULT NULL,
  `gordura_corporal` decimal(5,3) DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `informacoes_adicionais_medidas`
--

INSERT INTO `informacoes_adicionais_medidas` (`id`, `altura`, `peso`, `massa_magra`, `gordura_corporal`, `informacoes_adicionais_id`) VALUES
(14, 1.73, 90.000, 50.000, 40.000, 2),
(18, 1.73, 76.500, 30.400, 40.900, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `lido` enum('N','L') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('OK','ERRO','INFO') COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `dados` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `notificacao`
--

INSERT INTO `notificacao` (`id`, `data`, `lido`, `status`, `texto`, `profissional_id`, `aluno_id`, `dados`) VALUES
(1, '2018-09-17 21:42:04', 'L', 'INFO', 'Você tem uma nova solicitação de Diego  Pereira <br> O que deseja fazer? <a href="status_vinculo.php?id=2&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id=2&status=negado">Negar</a>', 1, NULL, 'a:3:{s:15:"profissional_id";s:1:"1";s:8:"aluno_id";s:1:"2";s:5:"table";s:7:"vinculo";}'),
(2, '2018-09-23 22:09:44', 'N', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig <br> O que deseja fazer? <a href="status_vinculo.php?id=1&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id=1&status=negado">Negar</a>', NULL, 3, 'a:3:{s:15:"profissional_id";s:1:"1";s:8:"aluno_id";s:1:"3";s:5:"table";s:7:"vinculo";}'),
(3, '2018-09-24 21:45:22', 'N', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href="status_vinculo.php?id=4&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id=4&status=negado">Negar</a>', NULL, 4, 'a:3:{s:15:"profissional_id";s:1:"4";s:8:"aluno_id";s:1:"4";s:5:"table";s:7:"vinculo";}'),
(4, '2018-09-24 21:54:33', 'N', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href="status_vinculo.php?id=4&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id=4&status=negado">Negar</a>', NULL, 1, 'a:3:{s:15:"profissional_id";s:1:"4";s:8:"aluno_id";s:1:"1";s:5:"table";s:7:"vinculo";}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha`
--

CREATE TABLE IF NOT EXISTS `planilha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `musculo_cardio_id` int(11) NOT NULL,
  `exercicio_id` int(11) NOT NULL,
  `repeticoes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carga` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intervalo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tempo` int(11) DEFAULT NULL,
  `profissional_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_exercicio`
--

CREATE TABLE IF NOT EXISTS `planilha_exercicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musculo_cardio_id` int(11) DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `planilha_exercicio`
--

INSERT INTO `planilha_exercicio` (`id`, `musculo_cardio_id`, `nome`, `descricao`, `foto`) VALUES
(1, 1, 'Rosca Alternada', 'Fique em pé, com os pés ligeiramente afastados, joelhos levemente flexionados, e abdominal contraído. Segure um halter em cada mão, mantendo a palma da mão para frente. Fixe a posição dos cotovelos na lateral de seu tronco e mantenha os pesos em frente à sua coxa.', NULL),
(2, 10, 'Glúteo em pé', 'Vou procurar', 'http://localhost/FitSan/uploads/exercicios/42639533_1863429377075184_3921901450212409344_o.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_grupoMuscuCardio`
--

CREATE TABLE IF NOT EXISTS `planilha_grupoMuscuCardio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `planilha_grupoMuscuCardio`
--

INSERT INTO `planilha_grupoMuscuCardio` (`id`, `nome`) VALUES
(1, 'Trapézio'),
(3, 'Ombro(esp)'),
(4, 'Ombro(clá/Acr)'),
(5, 'Costa'),
(6, 'Peito'),
(7, 'Biceps'),
(8, 'Tríceps'),
(9, 'AnteBraço'),
(10, 'Glúteo'),
(11, 'Abdutor'),
(12, 'Adutor'),
(16, 'Coxa(Ant)'),
(17, 'Coxa(Pos)'),
(18, 'Perna'),
(20, 'Abdominal'),
(21, 'Cárdio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo`) VALUES
(1, 'aluno'),
(2, 'profissional');

-- --------------------------------------------------------

--
-- Estrutura da tabela `upload_dica`
--

CREATE TABLE IF NOT EXISTS `upload_dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_arq` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `dica_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `upload_dica`
--

INSERT INTO `upload_dica` (`id`, `nome_arq`, `tipo`, `dica_id`) VALUES
(1, '3f38eb5de08a8a719188f96440c34bcdjpg', 'img', 0),
(2, '13f7a1d4f98c71d968f851ad951b51bbjpg', 'img', 1),
(5, 'cc925c40d0a019d4fda488d9482fdaa6jpg', 'img', 4),
(6, '71ade5c75f9c34a1edb65eee9ec0c274jpg', 'img', 4),
(7, '813005f63811db1a4a1b5eb323be7e4djpg', 'img', 4),
(8, 'e23dfc0011dd0399adecdfcff1f6886fjpeg', 'img', 4),
(9, '99f83255e9397060b65c2bf1e9436036jpg', 'img', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sobrenome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datanasc` date DEFAULT NULL,
  `sexo` enum('masculino','feminino') COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `datahora`, `nome`, `sobrenome`, `datanasc`, `sexo`, `foto`, `senha`, `email`, `tipo_id`, `codigo`) VALUES
(1, '2018-09-17 21:32:36', 'Karen', 'Guzzatti Konig ', '1988-08-14', 'feminino', 'http://localhost/FitSan/uploads/img_5113.jpg', '$2y$10$1Hv5TSETg2DMCtJuOSves.NclePxal7x4FN/KVOk.n1g9O400zqsW', 'karen.gk@aluno.ifsc.edu.br', 2, '5ba962d109181'),
(2, '2018-09-17 23:23:20', 'Diego ', 'Pereira ', '1986-08-06', 'masculino', 'http://localhost/FitSan/uploads/image.jpeg', '$2y$10$R/vz5peVnbm5wwovBdKX1O5lJzhccG67c4N/.IsXKNWlhjjRAjR7G', 'diego@diego', 1, NULL),
(3, '2018-09-24 00:37:33', 'Gerson', 'Konig ', '1960-11-17', 'masculino', 'http://localhost/FitSan/uploads/image.jpeg', '$2y$10$kbMNd26jK3YNYeWVamEu5u5if0ZEnDwuwdVR4LF0iUo92GELfBFNG', 'gerson@gerson', 1, NULL),
(4, '2018-09-25 00:39:56', 'Charles', 'Konig ', '1998-09-07', 'masculino', 'http://localhost/FitSan/uploads/21231596_1989303684692687_3895177490879221215_n.jpg', '$2y$10$fl9hOBi92HpH8NLSy8DVk.KANG9vtykzLCBNYcEDjYawL2RLq2uWK', 'charles@charles', 2, NULL),
(7, '2018-10-01 02:52:56', 'Administrador', 'Geral', NULL, NULL, NULL, '$2y$10$Vc2glFBT3NkkWRnvJepJEu54mBlSpS3JKPK4MMP83gUSJYoBCkWOC', 'admin@admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vinculo`
--

CREATE TABLE IF NOT EXISTS `vinculo` (
  `aluno_id` int(11) NOT NULL DEFAULT '0',
  `profissional_id` int(11) NOT NULL DEFAULT '0',
  `solicitante` enum('aluno','profissional') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('espera','aprovado','negado') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`aluno_id`,`profissional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `vinculo`
--

INSERT INTO `vinculo` (`aluno_id`, `profissional_id`, `solicitante`, `status`) VALUES
(1, 4, 'profissional', 'espera'),
(2, 1, 'aluno', 'aprovado'),
(3, 1, 'profissional', 'espera'),
(4, 4, 'profissional', 'espera');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/*select * from `usuario` where id ='9';*/;

/*select * from usuario join vinculo on usuario.id=vinculo.aluno_id where profissional_id=8;*/;