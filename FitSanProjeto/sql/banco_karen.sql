-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `ativ_extras`;
CREATE TABLE `ativ_extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` datetime NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `visualizacao` enum('PUBLICO','PRIVADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PRIVADO',
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `ativ_extras`;
INSERT INTO `ativ_extras` (`id`, `datahora`, `titulo`, `texto`, `visualizacao`, `aluno_id`) VALUES
(1,	'2018-10-23 01:13:44',	'Corrida de 20 km',	'corri',	'PRIVADO',	3),
(2,	'2018-10-23 01:13:46',	'iuiuiui',	'hggfds',	'PUBLICO',	3),
(3,	'2018-10-23 09:25:31',	'testando ',	'12345',	'PRIVADO',	4),
(43,	'2018-10-15 01:08:29',	'1',	'1',	'PRIVADO',	9),
(44,	'2018-10-16 01:08:40',	'2',	'2',	'PRIVADO',	9),
(45,	'2018-10-17 01:08:51',	'3',	'3',	'PRIVADO',	9),
(46,	'2018-10-29 01:11:26',	'4',	'4',	'PUBLICO',	9),
(47,	'2018-10-19 01:09:16',	'5',	'5',	'PRIVADO',	9),
(48,	'2018-10-20 01:09:30',	'6',	'6',	'PRIVADO',	9),
(49,	'2018-10-21 01:09:44',	'7',	'7',	'PRIVADO',	9),
(50,	'2018-10-22 01:10:01',	'8',	'8',	'PRIVADO',	9),
(51,	'2018-10-29 01:11:24',	'9',	'9',	'PUBLICO',	9),
(52,	'2018-10-29 02:34:39',	'10',	'10',	'PUBLICO',	9),
(53,	'2018-10-29 02:34:52',	'11',	'11',	'PUBLICO',	9);

DROP TABLE IF EXISTS `ativ_extras_exercicios`;
CREATE TABLE `ativ_extras_exercicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ativ_extras_id` int(11) DEFAULT NULL,
  `exercicio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `ativ_extras_exercicios`;
INSERT INTO `ativ_extras_exercicios` (`id`, `ativ_extras_id`, `exercicio`) VALUES
(1,	1,	'Corrida'),
(2,	2,	'Karatê'),
(3,	2,	'Basquete'),
(4,	3,	'Caminhada'),
(44,	43,	'Futebol'),
(45,	44,	'Caminhada'),
(46,	45,	'Karatê'),
(47,	46,	'Ping-Pong'),
(48,	47,	'Basquete'),
(49,	48,	'Skate'),
(50,	49,	'Balé'),
(51,	50,	'Natação'),
(52,	51,	'Jiu-jitsu'),
(53,	52,	'Bicicleta'),
(54,	53,	'Corrida');

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE `avaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `desempenho` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequencia` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `grupo_cumpriu` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `grupo_duvida` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `grupo_dificuldade` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `caso_sim` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `consideracoes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `avaliacao`;
INSERT INTO `avaliacao` (`id`, `data`, `desempenho`, `frequencia`, `grupo_cumpriu`, `grupo_duvida`, `grupo_dificuldade`, `caso_sim`, `consideracoes`, `profissional_id`, `aluno_id`) VALUES
(29,	'2018-10-22 20:23:28',	'bom',	'boa',	'sim',	'sim',	'sim',	'kkkk',	'kkkk',	2,	3),
(30,	'2018-10-22 20:45:52',	'bom',	'boa',	'sim',	'não',	'sim',	'kkkk',	'kkk',	2,	3),
(31,	'2018-10-22 20:51:05',	'bom',	'boa',	'sim',	'sim',	'sim',	'hgfd',	'kjhg',	2,	3),
(32,	'2018-10-22 20:54:31',	'médio',	'média',	'as vezes',	'não',	'sim',	'lllll',	'kkk',	2,	3),
(33,	'2018-10-22 20:55:14',	'bom',	'boa',	'sim',	'não',	'sim',	'allalalaa',	'lalalalaa',	2,	3),
(34,	'2018-10-22 20:56:48',	'médio',	'boa',	'sim',	'sim',	'não',	'ssss',	'kkkk',	2,	3);

DROP TABLE IF EXISTS `contato`;
CREATE TABLE `contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assunto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensagem` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `contato`;

DROP TABLE IF EXISTS `dados_meta`;
CREATE TABLE `dados_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_add` date NOT NULL,
  `peso_add` decimal(6,3) NOT NULL,
  `descricao` mediumtext COLLATE utf8mb4_unicode_ci,
  `meta_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `dados_meta`;
INSERT INTO `dados_meta` (`id`, `data_add`, `peso_add`, `descricao`, `meta_id`) VALUES
(1,	'2018-10-19',	66.000,	NULL,	1),
(2,	'2018-10-22',	67.000,	'',	1),
(3,	'2018-11-07',	64.000,	'',	1),
(4,	'2018-10-20',	54.000,	NULL,	2),
(5,	'2018-10-23',	57.000,	'',	2),
(6,	'2018-10-30',	59.000,	'',	2),
(7,	'2018-10-20',	50.000,	NULL,	3),
(8,	'2018-10-22',	51.000,	'',	3),
(9,	'2018-10-24',	52.000,	'',	3),
(10,	'2018-10-31',	53.000,	'',	3),
(11,	'2018-11-02',	54.000,	'',	3),
(12,	'2018-11-06',	55.000,	'',	3),
(13,	'2018-11-22',	58.000,	'quase la',	3),
(14,	'2018-10-20',	59.000,	NULL,	4),
(15,	'2018-10-22',	58.000,	'',	4),
(16,	'2018-10-24',	57.000,	'',	4),
(17,	'2018-10-27',	55.000,	'',	4),
(18,	'2018-10-20',	90.000,	NULL,	5),
(19,	'2018-10-23',	92.000,	'',	5);

DROP TABLE IF EXISTS `dica`;
CREATE TABLE `dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `profissional_nome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `data_envio` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `dica`;
INSERT INTO `dica` (`id`, `texto`, `profissional_nome`, `profissional_id`, `data_envio`) VALUES
(1,	'Beber bastante água\r\nCerca de 70% do corpo humano é composto por água, logo, ela é fundamental do ponto de vista fisiológico. \r\n\"Todas as células do nosso organismo precisam de água. \r\nEla não tem energia, não produz calorias, mas é essencial para o funcionamento do corpo. \r\nE quando digo que é importante beber água quero dizer exatamente isso, \r\ne não líquidos no geral. Suco é fruta no estado líquido, isso não é água\", \r\ndiz Andrea Bottoni, especialista em nutrologia e medicina do esporte do Hospital Alemão Oswaldo Cruz.\r\n',	'Karen',	2,	'2018-10-22 19:43:01'),
(2,	'Aprenda a usar a informática para emagrecer.\r\nCom o FitSan você pode acompanhar  o progresso de seus exercícios \r\nalém de poder ter um acompanhamento profissional de vários especialistas,\r\nentre treinadores, nutricionistas e muitos outros profissionais.\r\nFaça  hoje mesmo um teste inteiramente grátis e veja o que podemos fazer por você.',	'Charles',	7,	'2018-10-14 03:35:25');

DROP TABLE IF EXISTS `informacoes_adicionais`;
CREATE TABLE `informacoes_adicionais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saude` mediumtext COLLATE utf8mb4_unicode_ci,
  `medico` mediumtext COLLATE utf8mb4_unicode_ci,
  `alergia` mediumtext COLLATE utf8mb4_unicode_ci,
  `medicamento` mediumtext COLLATE utf8mb4_unicode_ci,
  `gruposangue` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doador` enum('SIM','NAO') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academia_frequentada` mediumtext COLLATE utf8mb4_unicode_ci,
  `academia_atual` mediumtext COLLATE utf8mb4_unicode_ci,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `informacoes_adicionais`;
INSERT INTO `informacoes_adicionais` (`id`, `saude`, `medico`, `alergia`, `medicamento`, `gruposangue`, `doador`, `academia_frequentada`, `academia_atual`, `aluno_id`) VALUES
(1,	'Gastrite Nervosa ',	'Nenhuma ',	'Camarão',	'Nenhum',	'A-',	'SIM',	'Athelic',	'nenhuma',	3),
(2,	'Não',	'Não',	'Não',	'Não',	'B-',	'SIM',	'vital, atletic',	'podium',	9);

DROP TABLE IF EXISTS `informacoes_adicionais_contatos`;
CREATE TABLE `informacoes_adicionais_contatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `informacoes_adicionais_contatos`;
INSERT INTO `informacoes_adicionais_contatos` (`id`, `tipo`, `nome`, `telefone`, `informacoes_adicionais_id`) VALUES
(1,	'Cônjuge',	'Karen',	'(48)99170-5657 / (48)3626-7585',	1),
(2,	'Filho(a)',	'Alguém',	'12345678',	2);

DROP TABLE IF EXISTS `informacoes_adicionais_exercicios`;
CREATE TABLE `informacoes_adicionais_exercicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exercicios` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `informacoes_adicionais_exercicios`;
INSERT INTO `informacoes_adicionais_exercicios` (`id`, `exercicios`, `informacoes_adicionais_id`) VALUES
(1,	'Futebol',	1),
(2,	'Futebol',	2),
(3,	'Karatê',	2),
(4,	'Basquete',	2),
(5,	'Jiu-jitsu',	2),
(6,	'Corrida',	2),
(7,	'Caminhada',	2),
(8,	'Ping-Pong',	2),
(9,	'Skate',	2),
(10,	'Natação',	2),
(11,	'Bicicleta',	2),
(12,	'Rapel',	2),
(13,	'surf',	2),
(14,	'paraquedismo',	2);

DROP TABLE IF EXISTS `informacoes_adicionais_medidas`;
CREATE TABLE `informacoes_adicionais_medidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `altura` decimal(7,2) DEFAULT NULL,
  `peso` decimal(7,3) DEFAULT NULL,
  `massa_magra` decimal(7,3) DEFAULT NULL,
  `gordura_corporal` decimal(7,3) DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `informacoes_adicionais_medidas`;
INSERT INTO `informacoes_adicionais_medidas` (`id`, `altura`, `peso`, `massa_magra`, `gordura_corporal`, `informacoes_adicionais_id`) VALUES
(1,	1.73,	73.000,	20.000,	30.000,	1),
(2,	1.90,	99.000,	80.000,	30.000,	2);

DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('PERDER','GANHAR','MANTER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_inicial` date NOT NULL,
  `data_final` date NOT NULL,
  `peso_inicial` decimal(6,3) NOT NULL,
  `peso_final` decimal(6,3) NOT NULL,
  `status` enum('ativa','finalizada','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativa',
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `meta`;
INSERT INTO `meta` (`id`, `tipo`, `data_inicial`, `data_final`, `peso_inicial`, `peso_final`, `status`, `usuario_id`) VALUES
(1,	'PERDER',	'2018-10-19',	'2018-11-30',	66.000,	54.000,	'cancelada',	3),
(2,	'GANHAR',	'2018-10-20',	'2018-11-30',	54.000,	60.000,	'cancelada',	3),
(3,	'GANHAR',	'2018-10-20',	'2018-11-30',	50.000,	60.000,	'cancelada',	3),
(4,	'PERDER',	'2018-10-20',	'2018-10-27',	59.000,	55.000,	'cancelada',	3),
(5,	'GANHAR',	'2018-10-20',	'2018-12-31',	90.000,	100.000,	'ativa',	9);

DROP TABLE IF EXISTS `notificacao`;
CREATE TABLE `notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `lido` enum('N','L') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OK','ERRO','INFO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `dados` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `notificacao`;
INSERT INTO `notificacao` (`id`, `data`, `lido`, `status`, `texto`, `profissional_id`, `aluno_id`, `dados`) VALUES
(1,	'2018-10-24 11:41:07',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=4\"></a>',	NULL,	9,	NULL),
(2,	'2018-10-24 11:41:57',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=4\">Teste 123</a>',	NULL,	9,	NULL),
(3,	'2018-10-24 18:41:09',	'L',	'INFO',	'Sua meta foi finalizada na data 30 Nov 1999<br><a href=\"okMetaNot.php\">Ok</a>',	NULL,	NULL,	NULL),
(4,	'2018-10-24 18:41:09',	'L',	'INFO',	'Sua meta foi finalizada na data 30 Nov 1999<br><a href=\"okMetaNot.php\">Ok</a>',	NULL,	NULL,	NULL),
(5,	'2018-10-24 21:38:20',	'L',	'INFO',	'Sua meta foi finalizada na data 30 Nov 1999<br><a href=\"okMetaNot.php\">Ok</a>',	NULL,	NULL,	NULL),
(6,	'2018-10-24 21:38:20',	'L',	'INFO',	'Sua meta foi finalizada na data 30 Nov 1999<br><a href=\"okMetaNot.php\">Ok</a>',	NULL,	NULL,	NULL),
(7,	'2018-10-25 01:09:05',	'L',	'INFO',	'Você tem uma nova solicitação de Can Divit <br> O que deseja fazer? <a href=\"status_vinculo.php?id=9&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=9&status=negado\">Negar</a>',	7,	NULL,	'a:3:{s:15:\"profissional_id\";s:1:\"7\";s:8:\"aluno_id\";s:1:\"9\";s:5:\"table\";s:7:\"vinculo\";}'),
(8,	'2018-10-25 01:09:46',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=5\">Planilha1</a>',	NULL,	9,	NULL),
(9,	'2018-10-26 01:14:08',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=6\">Treino leve</a>',	NULL,	9,	NULL),
(10,	'2018-10-26 01:19:53',	'N',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=6\">test</a>',	NULL,	3,	NULL),
(11,	'2018-10-26 01:20:26',	'N',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=7\">test</a>',	NULL,	11,	NULL),
(12,	'2018-10-27 22:46:43',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=8\">Testando </a>',	NULL,	9,	NULL),
(13,	'2018-10-27 22:59:44',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=9\">Teste1</a>',	NULL,	9,	NULL),
(14,	'2018-10-27 23:04:38',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=10\">teste 2</a>',	NULL,	9,	NULL),
(15,	'2018-10-28 00:40:32',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=11\">teste121</a>',	NULL,	9,	NULL),
(16,	'2018-10-28 00:41:49',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=12\">teste 2</a>',	NULL,	9,	NULL),
(17,	'2018-10-28 01:36:37',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=1\">1</a>',	NULL,	9,	NULL),
(18,	'2018-10-28 01:38:10',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=2\">2</a>',	NULL,	9,	NULL),
(19,	'2018-10-28 02:06:22',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=3\">cc</a>',	NULL,	9,	NULL),
(20,	'2018-10-28 02:14:50',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=1\">Basquete com o irmão</a>',	NULL,	9,	NULL),
(21,	'2018-10-28 02:35:58',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=2\">Corrida de 20 km</a>',	NULL,	9,	NULL),
(22,	'2018-10-28 02:59:47',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=1\">Corrida de 20 km</a>',	NULL,	9,	NULL),
(23,	'2018-10-28 03:05:50',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=2\">Corrida de 20 km</a>',	NULL,	9,	NULL),
(24,	'2018-10-28 13:49:16',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=1\">Treino Intermediario</a>',	NULL,	9,	NULL),
(25,	'2018-10-28 17:36:33',	'L',	'OK',	'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=2\">teste 2</a>',	NULL,	9,	NULL),
(26,	'2018-10-29 02:25:19',	'N',	'INFO',	'Você tem uma nova solicitação de Lua Ana <br> O que deseja fazer? <a href=\"status_vinculo.php?id=12&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=12&status=negado\">Negar</a>',	NULL,	9,	'a:3:{s:15:\"profissional_id\";s:2:\"12\";s:8:\"aluno_id\";s:1:\"9\";s:5:\"table\";s:7:\"vinculo\";}');

DROP TABLE IF EXISTS `planilha`;
CREATE TABLE `planilha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datahora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha`;
INSERT INTO `planilha` (`id`, `titulo`, `datahora`) VALUES
(1,	'Treino Intermediario',	'2018-10-28 16:49:16'),
(2,	'teste 2',	'2018-10-28 20:36:33');

DROP TABLE IF EXISTS `planilha_aluno`;
CREATE TABLE `planilha_aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_id` int(11) DEFAULT NULL,
  `planilha_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha_aluno`;
INSERT INTO `planilha_aluno` (`id`, `aluno_id`, `planilha_id`) VALUES
(1,	9,	1),
(2,	9,	2);

DROP TABLE IF EXISTS `planilha_aluno_exercicio`;
CREATE TABLE `planilha_aluno_exercicio` (
  `planilha_feito_id` int(11) NOT NULL,
  `planilha_tabela_id` int(11) NOT NULL,
  `exercicio` int(11) NOT NULL,
  PRIMARY KEY (`planilha_feito_id`,`planilha_tabela_id`,`exercicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha_aluno_exercicio`;
INSERT INTO `planilha_aluno_exercicio` (`planilha_feito_id`, `planilha_tabela_id`, `exercicio`) VALUES
(22,	24,	37),
(22,	25,	3),
(22,	26,	16),
(22,	27,	40),
(22,	28,	12),
(23,	1,	84),
(23,	2,	85),
(23,	3,	86),
(23,	7,	56),
(23,	8,	63),
(23,	9,	52),
(23,	10,	11),
(23,	11,	1),
(23,	12,	68),
(23,	13,	81),
(23,	14,	73),
(23,	15,	23),
(23,	16,	35),
(24,	29,	85),
(24,	30,	36),
(24,	31,	3),
(25,	4,	84),
(25,	5,	85),
(25,	6,	86),
(25,	17,	83),
(25,	18,	76),
(25,	19,	47),
(25,	20,	42),
(25,	21,	25),
(25,	22,	4),
(25,	23,	87),
(26,	32,	11);

DROP TABLE IF EXISTS `planilha_aluno_feito`;
CREATE TABLE `planilha_aluno_feito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planilha_aluno_id` int(11) DEFAULT NULL,
  `datahora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha_aluno_feito`;
INSERT INTO `planilha_aluno_feito` (`id`, `planilha_aluno_id`, `datahora`) VALUES
(22,	2,	'2018-10-23 17:40:03'),
(23,	1,	'2018-10-24 17:40:33'),
(24,	2,	'2018-10-25 17:41:19'),
(25,	1,	'2018-10-26 17:41:37'),
(26,	2,	'2018-10-27 17:42:02');

DROP TABLE IF EXISTS `planilha_exercicio`;
CREATE TABLE `planilha_exercicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musculo_cardio_id` int(11) DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha_exercicio`;
INSERT INTO `planilha_exercicio` (`id`, `musculo_cardio_id`, `nome`, `descricao`, `foto`, `profissional_id`) VALUES
(1,	18,	'Remada Baixa Sentado',	'Segure os pegadores presos aos cabos com os braços estendidos à frente.\r\nTracione os pegadores superiormente, na direção do peito, mantendo a coluna vertebral reta.\r\nRetorne os pegadores à posição inicial.',	NULL,	NULL),
(2,	19,	'Remada Alta com barra',	'Segure a barra com afastamento igual à distância entre os ombros; use uma pegada com o dorso das mãos voltado para cima.\r\nTracione a barra verticalmente para cima até chegar ao queixo; eleve o máximo possível os cotovelos.\r\nAbaixe a barra lentamente, até que os braços fiquem na posição estendida.',	NULL,	NULL),
(3,	19,	'Encolhimento com Halter',	'Em pé, em uma posição ereta com um halter em cada mão, mãos pendentes aos lados do corpo.\r\nMantendo os braços estendidos, encolha os ombros para cima – até o ponho mais alto possível.\r\nAbaixe os halteres de volta para a posição inicial.\r\n',	NULL,	NULL),
(4,	19,	'Encolhimento com Barra',	'Segure uma barra com os braços estendidos à frente das coxas, utilizando pegada com distância igual à largura dos ombros e com o dorso das mãos voltado para cima.\r\nMantendo os braços contraídos, encolha os ombros até o ponto mais alto possível, tracionando a barra com um movimento vertical para cima.\r\nAbaixe lentamente a barra até a posição inicial, alongando o trapézio.',	NULL,	NULL),
(5,	18,	'Ramada Serrador',	'Segure um halter fixo com a palma voltada para dentro. Repouse a outra mão e o joelho sobre um banco, mantendo a coluna vertebral reta e praticamente paralela ao chão.\r\nMovimente o halter verticalmente para cima ao longo do torso, levantando o cotovelo até o nível mais alto possível.\r\nAbaixe o halter até a posição inicial.',	NULL,	NULL),
(6,	18,	'Remada Curvada',	'Fazendo uma pegada na barra com espaçamento igual à largura dos ombros e com o dorso das mãos voltado para cima, incline o torso para a frente em um ângulo de 45 graus com o chão.\r\nTracione a barra verticalmente para cima, até que ela toque a parte inferior do peito, mantendo a coluna vertebral reta e os joelhos ligeiramente dobrados.\r\nAbaixe a barra até a posição de braços estendidos.',	NULL,	NULL),
(7,	18,	'Remada Articulada',	'Segure os pegadores com os braços estendidos à frente, apoiando o torso contra a almofada peitoral.\r\nTracione os pegadores na direção da parte superior do abdome, mantendo a coluna vertebral reta.\r\nRetorne o peso à posição inicial.',	NULL,	NULL),
(8,	18,	'Puxador Frontal Fechado',	'Para executar o Puxador Frontal Fechado:\r\nFaça uma pegada na barra com o dorso das mãos voltado para frente (invertido) com as mãos espaçadas em 15 a 30cm.\r\nTracione a barra para baixo até a parte superior do peito, tensionando os latíssimos.\r\n\r\n',	NULL,	NULL),
(9,	18,	'Puxador Frontal Aberto',	'Para executar o Puxador Frontal Aberto:\r\nFaça uma pegada na barra com o dorso das mãos voltado para cima; as mãos devem ficar a uma distância 15cm maior que a largura dos ombros.\r\nTracione a barra para baixo, até a parte superior do peito, contraindo os latíssimos.',	NULL,	NULL),
(10,	18,	'Barra',	'Essas flexões com barras são parecidas com as de puxador.',	NULL,	NULL),
(11,	17,	'Levantamento Terra',	'Faça uma pegada com afastamento igual à largura dos ombros e com o dorso das mãos voltado para cima; braços estendidos e na posição agachada, dobrando joelhos e quadris.\r\nMantendo a coluna vertebral reta e os cotovelos bloqueados, fique de pé, ereto, levantando a barra até o nível dos quadris.\r\nLentamente, abaixe a barra até o chão.',	NULL,	NULL),
(12,	17,	'Levantamento Bom Dia',	'Fique em pé em uma posição ereta com uma barra sob os ombros.\r\nMantendo a coluna vertebral reta e os joelhos rígidos (estendidos ou ligeiramente dobrados), incline-se para a frente (use a cintura) até que o torso esteja um pouco acima da posição paralela com relação ao chão.\r\nLevante o torso de volta à posição ereta.',	NULL,	NULL),
(13,	17,	'Extensão Lombar',	'Fique deitado com o rosto voltado para o chão, com os quadris apoiados no banco e tornozelos fixados sob as almofadas.\r\nComece com o torso pendendo para baixo, com flexão de 90 graus na cintura.\r\nEleve o corpo até que o torso esteja um pouco acima da posição de paralelismo com o chão.',	NULL,	NULL),
(14,	20,	'Leg Press',	'Sente-se no aparelho de leg press e coloque os pés com afastamento na plataforma igual à largura dos ombros.\r\nLentamente, abaixe o peso até que os joelhos estejam com 90 graus de flexão.',	'http://localhost/FitSan/uploads/exercicios/legpress.png',	NULL),
(15,	20,	'Extensão de Perna ',	'Sente-se no aparelho e coloque os pés por baixo dos rolos.\r\nLevante as pernas para cima, até que os joelhos estejam estendidos.\r\nAbaixe as pernas de volta à posição inicial, com os joelhos dobrados em 90 graus.',	'http://localhost/FitSan/uploads/exercicios/extdaspernas.png',	NULL),
(16,	20,	'Agachamento Hack',	'Posicione as costas contra o encosto e os ombros por baixo dos rolos almofadados e fique em pé com os pés afastados na largura dos ombros sobre a plataforma, com os dedos apontando para frente.\r\nAbaixe lentamente o peso, flexionando os joelhos até 90 graus.\r\n\r\n',	'http://localhost/FitSan/uploads/exercicios/agachamentoh.png',	NULL),
(17,	20,	'Agachamento Livre',	'Em pé com a barra apoiada nos ombros e os pés afastados em distância igual à largura dos ombros.\r\nFlexione lentamente os joelhos até que as coxas fiquem paralelas ao chão.\r\nEstenda as pernas para retornar à posição inicial (em pé).',	NULL,	NULL),
(18,	20,	'Afundo',	'Em pé com os pés afastados na largura dos ombros; segure dois halteres fixos com os braços estendidos ao lado do corpo.\r\nDê um passo para frente e flexione o joelho até que a coxa da perna que avançou esteja paralela com o chão.\r\n\r\n',	'http://localhost/FitSan/uploads/exercicios/afundo.png',	NULL),
(19,	21,	'Panturrilha em Pé',	'Para executar o Panturrilha em pé:\r\nFique em pé com os dedos dos pés sobre a plataforma e os ombros por baixo das almofadas; abaixe os calcanhares o máximo possível, para obtenção de um alongamento completo.\r\nLevante o peso elevando os calcanhares até onde for possível, mantendo as pernas estendidas.',	NULL,	NULL),
(20,	21,	'Panturrilha Sentado',	'Coloque as bolas dos pés na plataforma, posicione as almofadas transversalmente à parte inferior das coxas e abaixe os calcanhares o máximo possível.\r\nLevante o peso elevando os calcanhares até o ponto mais elevado possível\r\nAbaixe lentamente os calcanhares até a posição inicial.',	NULL,	NULL),
(21,	21,	'Panturrilha no Leg Press',	'Para executar o Panturrilha no leg press:\r\nColoque as bolas dos pés sobre a borda da plataforma (como em um aparelho de leg press) e abaixe o peso o máximo possível.\r\nEmpurre o peso para cima até onde puder, contraindo os músculos da panturrilha.\r\nAbaixe lentamente o peso até a posição inicial.',	NULL,	NULL),
(22,	21,	'Elevação na ponta dos pés',	'Coloque os dedos dos pés sobre um bloco, incline-se para a frente e apoie o torso no banco; abaixe os calcanhares o máximo possível.\r\nLevante o peso pela elevação dos calcanhares o máximo possível, mantendo as pernas estendidas.\r\nAbaixe lentamente os calcanhares até a posição inicial.',	NULL,	NULL),
(23,	22,	'Levantamento Stiff',	'Fique em pé e mantenha o corpo ereto, com os pés diretamente abaixo dos quadris, segurando uma barra com os braços estendidos.\r\nIncline-se para a frente (use a cintura) abaixando o peso, mas mantendo as pernas estendidas.\r\nPare antes que o peso toque o chão e volte a levantá-lo.',	NULL,	NULL),
(24,	22,	'Flexão de Pernas em Pé',	'Para executar o Flexão de pernas em pé:\r\nColoque um calcanhar por baixo do rolo almofadado e apoie o peso com a outra perna.\r\nLevante o peso dobrando o joelho e elevando o calcanhar na direção da nádega.\r\nAbaixe o peso de volta a posição inicial.',	NULL,	NULL),
(25,	22,	'Flexão de Pernas Deitado',	'Deite-se de bruços sobre o aparelho e enganche os calcanhares por baixo dos rolos almofadados.\r\nLevante o peso dobrando os joelhos e eleve os calcanhares na direção das nádegas.\r\nAbaixe o peso de volta à posição inicial.',	NULL,	NULL),
(26,	23,	'Supino inclinado com halter',	'Na posição sentada em um banco inclinado, comece com os halteres fixos no nível do tórax, \r\ncom as palmas das mãos voltadas para a frente.\r\nImpulsione os halteres verticalmente, até que ocorra bloqueio dos cotovelos.',	NULL,	NULL),
(27,	23,	'Supino inclinado',	'Na posição sentada em um banco inclinado, faça uma pegada na barra com as palmas das \r\nmãos voltadas para cima e com afastamento na mesma distância dos ombros.\r\nAbaixe lentamente o peso, até que a barra toque a parte superior do tórax.\r\nEmpurre a barra diretamente para cima, até que os cotovelos fiquem estendidos.\r\n',	NULL,	NULL),
(28,	23,	'Crucifixo inclinado',	'Sentado em um banco inclinado, comece com os halteres diretamente acima do tórax, com as palmas das mãos voltadas para dentro.\r\nAbaixe os halteres para fora, dobrando ligeiramente os cotovelos enquanto os pesos descem até o nível do tórax.\r\nLevante os halteres de volta, unindo-os na parte superior do exercício.',	NULL,	NULL),
(29,	23,	'Crucifixo com cabo',	'Em cada mão, segure o pegador preso a polias baixas, fique em pé, em posição ereta.\r\nLevante as mãos em um arco para frente até que os pegadores se encontrem na altura da cabeça.',	NULL,	NULL),
(31,	24,	'Supino reto com halter',	'Deitado em um banco horizontal, comece com os halteres no nível do tórax, palmas das mãos voltadas para a frente.\r\nImpulsione verticalmente os halteres, até que ocorra a extensão total dos cotovelos.',	NULL,	NULL),
(32,	24,	'Supino reto com barra',	'Na posição deitada em um banco plano, faça uma pegada na barra com o dorso das mãos voltado para cima e o afastamento entre elas igual à distância entre os ombros.\r\nAbaixe lentamente o peso até tocar a parte média do tórax.\r\nEmpurre a barra diretamente para cima, até que ocorra bloqueio dos cotovelos.',	NULL,	NULL),
(33,	24,	'Crucifixo reto',	'Deitado em um banco horizontal, comece com os halteres diretamente acima do tórax médio, com as palmas das mãos voltadas para dentro.\r\nAbaixe os halteres com um amplo movimento de abertura (para fora), dobrando ligeiramente os cotovelos durante a descida dos pesos até o nível do tórax.\r\nLevante os halteres em um movimento simultâneo, fazendo arco ascendente, em retorno à posição vertical.',	NULL,	NULL),
(34,	24,	'Voador',	'Segure os pegadores verticais, com os cotovelos ligeiramente dobrados.\r\nTracione simultaneamente os pegadores até que se toquem à frente de seu tórax.',	NULL,	NULL),
(35,	25,	'Supino declinado',	'Deite-se em um banco declinado e faça uma pegada na barra com o dorso das mãos voltado para cima e com afastamento igual à distância entre os ombros.\r\nAbaixe lentamente o peso até tocar a parte inferior do tórax.\r\nEmpurre a barra diretamente para cima, até que ocorra extensão total dos cotovelos.',	NULL,	NULL),
(36,	25,	'Paralela',	'Agarre as barras paralelas, sustentando o corpo com os cotovelos estendidos e bloqueados.\r\nDobre os cotovelos, baixando o torso até que os braços fiquem paralelos ao chão.\r\nEmpurre o corpo de volta a posição inicial, isto é, até que seus cotovelos fiquem novamente estendidos.\r\n',	NULL,	NULL),
(37,	25,	'Crossover',	'Na posição em pé, segure os pegadores presos às polias altas de um aparelho de cabos.\r\nTracione simultaneamente para baixo os pegadores, até que as mãos se toquem a frente da cintura; mantenha os cotovelos ligeiramente dobrados.\r\nLentamente, retorne à posição inicial com as mãos no nível dos ombros.\r\n',	NULL,	NULL),
(38,	25,	'Crucifixo declinado',	'Deitado em um banco declinado, comece com os halteres diretamente acima de seu tórax, com as palmas das mãos voltadas para dentro.\r\nAbaixe os halteres com um movimento de abertura (para fora), dobrando ligeiramente os cotovelos durante a descida dos pesos até o nível do tórax.\r\nLeva simultaneamente os halteres de volta à posição inicial, até se tocarem.',	NULL,	NULL),
(39,	26,	'Abdominal',	'Coloque os pés embaixo da almofada e sente no banco declinado com o torso ereto.\r\nAbaixe o torso para trás até que fique praticamente paralelo ao chão.\r\nRetorna a posição vertical, dobrando na cintura.',	'',	NULL),
(40,	26,	'Abdominal grupado',	'Deite-se de costas no chão, com os quadris dobrados a 90 graus e as mãos atrás da cabeça.\r\nEleve os ombros do chão, comprimindo o peito para frente e mantendo a região lombar em contato com o chão.\r\nAbaixe os ombros de volta à posição inicial.\r\n',	NULL,	NULL),
(41,	26,	'Abdominal grupado com corda',	'Ajoelhe no chão embaixo de uma polia alta e segure a corda com as duas mãos, atrás da cabeça.\r\nPuxe o peso para baixo, encurvando o torso e inclinando a cintura.\r\nRetorne a posição inicial.',	NULL,	NULL),
(42,	26,	'Abdominal grupado com aparelho',	'Para realizar o Abdominal grupado com aparelho:\r\nSente-se no assento, segure os pegadores e coloque os pés sob os rolos de tornozelo.\r\nFaça o abdominal inclinando o torso na direção dos joelhos.\r\nRetorne a posição vertical.',	NULL,	NULL),
(43,	27,	'Pullover',	'Deite-se com a parte superior das costas repousando transversalmente em um banco horizontal; segure um halter fixo diretamente acima de seu tórax.\r\nMovimente o halter para baixo e para trás, até atingir o nível do banco, inspirando profundamente e alongando o gradil costal.',	NULL,	NULL),
(44,	27,	'Inclinação Lateral com halter',	'Fique em pé, segurando um halter na mão esquerda; coloque a mão direita atrás da cabeça.\r\nDobre o torso para o lado esquerdo, abaixando o halter na direção do joelho.\r\nFaça com que o torso fique novamente ereto, contraindo os músculos oblíquos direitos.',	NULL,	NULL),
(45,	27,	'Abdominal grupado oblíquo',	'Deite-se sobre o lado esquerdo, joelhos dobrados e juntos, mão direita atrás da cabeça.\r\nLevante lentamente o torso, contraindo os oblíquos do lado direito.\r\nAbaixe o torso até a posição inicial.',	NULL,	NULL),
(46,	27,	'Abdominal grupado oblíquo com cabo ',	'Segure um pegador preso à polia alta de um aparelho de cabo.\r\nFaça o abdominal para baixo, direcionando o cotovelo para o joelho oposto.\r\nRetorne lentamente à posição inicial.',	NULL,	NULL),
(47,	27,	'Abdominal com giro',	'Para fazer o abdominal com giro, sente-se no banco inclinado, enganche os pés por baixo da almofada, incline-se para trás e posicione as mãos atrás da cabeça.\r\nAo fazer o abdominal, torça seu torso, direcionando o cotovelo direito ao joelho esquerdo.\r\nAbaixe de volta para a posição inicial\r\nDurante a próxima repetição, direcione o cotovelo esquerdo para o joelho direito.',	NULL,	NULL),
(48,	28,	'Elevação de pernas corpo inclinado',	'Deite-se de costas em um banco abdominal inclinado, com as pernas para baixo.\r\nLevante as pernas (nos quadris) e impulsione as coxas na direção do peito, mantendo os joelhos ligeiramente dobrados.\r\nAbaixe lentamente as pernas de volta à posição inicial.',	NULL,	NULL),
(49,	28,	'Elevação de pernas na barra',	'Pendure-se com as mãos em uma barra, ou coloque os cotovelos em um par de AB Slings (protetores que se prendem à barra para sustentar o peso do corpo); as pernas ficam livremente pendentes.\r\nLevante simultaneamente os joelhos, ligeiramente dobrados, na direção do peito.\r\nAbaixe lentamente as pernas de volta à posição inicial, sem balançar.\r\n',	NULL,	NULL),
(50,	28,	'Elevação de joelhos',	'Sente-se na extremidade de um banco horizontal, com as pernas pendendo e os joelhos ligeiramente dobrados, e agarre o banco atrás de você.\r\nLevante os joelhos na direção do peito, mantendo as pernas juntas.\r\nAbaixe as pernas, até que os calcanhares praticamente toquem o chão.',	NULL,	NULL),
(51,	28,	'Abdominal grupado invertido',	'Para executar o Abdominal grupado invertido, deite-se em um banco horizontal, posicione os pés de modo a fazer 90 graus com os joelhos e quadris e agarre o banco atrás da cabeça para apoio.\r\nLevante a pelve (afastando-a do banco) até que os pés apontem para o teto.\r\nAbaixe as pernas de volta para posição inicial.',	NULL,	NULL),
(52,	8,	'Rosca martelo',	'Segure um halter fixo em cada mão com as palmas voltadas para dentro (polegares apontando para frente).\r\nLevante um halter de cada vez até o ombro, mantendo as palmas das mãos voltadas para dentro.\r\nAbaixe o halter de volta à posição de braço estendido e repita com o outro braço.\r\n',	NULL,	NULL),
(53,	8,	'Rosca invertida',	'Segure a barra do halter com os braços estendidos; use uma pegada com o dorso das mãos voltados para cima e com afastamento igual à distância entre os ombros.\r\nEleve a barra até o nível dos ombros, rosqueando os punhos para cima e para trás enquanto flexiona os cotovelos.\r\nAbaixe a barra até a posição de braços estendidos, deixando que os punhos “caiam”.',	NULL,	NULL),
(54,	8,	'Rosca punho',	'Sentado na extremidade do banco, faça a pegada na barra com o dorso das mãos voltado para baixo, mãos afastadas na distância entre os ombros e repouse a parte dorsal dos antebraços nas coxas.\r\nAbaixe a barra dobrando os punhos para baixo, na direção do chão.\r\nFaça a rosca (peso para cima) utilizando o movimento dos punhos.\r\n',	NULL,	NULL),
(55,	8,	'Rosca punho invertida',	'Pegue a barra usando pegada com o dorso das mãos voltado para cima e repouse os antebraços no alto das coxas ou na borda do banco.\r\nAbaixe a barra dobrando os punhos na direção do chão.\r\nLevante o peso utilizando o movimento dos punhos.',	NULL,	NULL),
(56,	6,	'Rosca Scott',	'Sente-se com os braços repousando no banco de Scott e faça a pegada na barra com o dorso das mãos voltado para baixo e na mesma distancia dos ombros; braços retos, voltados para fora.\r\nFlexionando os cotovelos, movimente a barra na direção dos ombros.\r\nAbaixe o peso de volta à posição com os braços estendidos.',	NULL,	NULL),
(57,	6,	'Rosca no aparelho',	'Segure a barra usando uma pegada com o dorso das mãos voltado para baixo e na largura dos ombros, com os cotovelos repousando na almofada e braços retos, voltados para fora.\r\nTracione a barra na direção dos ombros, flexionando os cotovelos\r\nRetorne a barra à posição de braços estendidos',	NULL,	NULL),
(58,	6,	'Rosca direta com halter',	'Segure um par de halteres à distancia do braços estendido, um de cada lado do corpo, com os polegares apontando para frente.\r\nMovimentando um braço de cada vez, movimente o halter para cima, na direção do ombro, girando a mão de modo que a palma fique voltada para cima.\r\nAbaixe o halter e repita com o outro braço.',	NULL,	NULL),
(59,	6,	'Rosca direta com barra',	'Segure a barra com os braços estendidos; pegada com afastamento igual à distancia entre os ombros e com o dorso das mãos voltado para baixo.\r\nLeve a barra até o nível dos ombros; para tanto, flexione os cotovelos.\r\nAbaixe a barra de volta à posição inicial, com os braços na posição estendida.',	NULL,	NULL),
(60,	6,	'Rosca concentrada',	'Posição sentada na extremidade do banco. Segure o halter fixo com o braço estendido; apoie o braço contra a parte interna da coxa.\r\nFaça o exercício de rosca com halter na direção do ombro, flexionando o cotovelo.\r\nAbaixe o halter de volta a posição inicial.\r\n',	NULL,	NULL),
(61,	6,	'Rosca com cabo',	'Segure a barra curta presa a uma polia baixa, utilizando uma pegada com o dorso das mãos voltado para baixo e com os braços estendidos.\r\nLevante a barra na direção dos ombros, flexionando os cotovelos.\r\nAbaixe o peso de volta à posição inicial, braços na posição estendida.',	NULL,	NULL),
(63,	7,	'Tríceps puxador',	'Faça a pegada com o dorso das mãos voltado para cima e na largura dos ombros em uma barra curta presa a uma polia alta.\r\nComece com a barra no nível do peito, cotovelos dobrados um pouco mais do que 90 graus.\r\nMantendo os braços estendidos, tracione a barra para baixo até que os cotovelos fiquem bloqueados. \r\n',	NULL,	NULL),
(64,	7,	'Tríceps francês',	'Sente-se com o torso ereto, segurando uma barra nas duas mãos com os braços estendidos acima da cabeça; use uma pegada fechada com o dorso das mãos voltado para cima.\r\nFlexione os cotovelos e abaixe a barra por trás da cabeça.\r\nImpulsione a barra para cima até que ocorra extensão total dos cotovelos.\r\n',	NULL,	NULL),
(65,	7,	'Tríceps testa',	'Deitado em um banco horizontal, segure uma barra com os braços estendidos acima de seu peito; use pegada fechada, com o dorso das mãos voltado para cima, e com as mãos afastadas em aproximadamente 15 cm.\r\nFlexione os cotovelos e abaixe a barra até tocar a testa.\r\nImpulsione a barra para cima, até que ocorra extensão total dos cotovelos.',	NULL,	NULL),
(66,	7,	'Tríceps coice',	'Pegue o halter com uma mão, encurve-se para frente (use a cintura), e sustente o torso pousando a mão livre em um banco, ou no joelho.\r\nComece com o braço paralelo ao chão e com o cotovelo dobrado em 90 graus.\r\nMovimente para cima o halter, estendendo o braço até que ocorra total extensão do cotovelo. \r\n',	NULL,	NULL),
(67,	7,	'Tríceps supinado',	'Para executar o Tríceps Supinado:\r\nUse pegada fechada (cerca de 15 cm) na barra, com o dorso das mãos voltado para cima.\r\nAbaixe o peso lentamente, até tocar na parte media do peito.',	NULL,	NULL),
(68,	29,	'Levantamento frontal com cabo ',	'Com uma das mãos, segure o pegador preso a uma polia baixa, utilizando uma pegada pronada (palma das mãos para baixo).\r\nVirado de costas para a pilha de pesos, levante o cabo em um arco ascendente até o nível do ombro, mantendo o cotovelo rígido.\r\nAbaixe o cabo de volta até o nível da cintura.',	'http://localhost/FitSan/uploads/exercicios/frontl.png',	NULL),
(69,	29,	'Levantamento frontal com barra',	'Utilizando uma pegada com o dorso das mãos voltado para cima e na largura dos ombros, segure um halter de barra á frente das coxas com os braços estendidos.\r\nLevante o halter para a frente e para cima até o nível dos olhos, mantendo os cotovelos rígidos.\r\nAbaixe o halter de volta às coxas.',	'http://localhost/FitSan/uploads/exercicios/lev.png',	NULL),
(70,	29,	'Elevação frontal com halter',	'Sentado com as costas eretas na extremidade de um banco de exercício, segure um par de halteres fixos aos lados do corpo com os braços estendidos; os polegares devem estar apontando para a frente.\r\nLevante um haltere para a frente até o nível do ombro, mantendo o cotovelo rígido.\r\nAbaixe o peso de volta para a posição inicial e repita com o outro halter.',	'http://localhost/FitSan/uploads/exercicios/front.png',	NULL),
(71,	29,	'Desenvolvimento com barra',	'Sentado num banco, faça a pegada na barra com afastamento das mãos igual à largura dos ombros; palmas das mãos voltadas para frente.\r\nAbaixe lentamente o peso (à frente), até que toque a parte superior do tórax.\r\nImpulsione verticalmente para cima até que ocorra bloqueio dos cotovelos. \r\n',	'http://localhost/FitSan/uploads/exercicios/senvolvibarra.png',	NULL),
(72,	29,	'Desenvolvimento Harnold',	'Sentado em um banco, comece com os halteres fixos no nível do ombro, palmas das mãos voltadas para frente.\r\nImpulsione verticalmente para cima os halteres, até que ocorra bloqueio dos cotovelos.\r\n\r\n',	'http://localhost/FitSan/uploads/exercicios/ombro.png',	NULL),
(73,	30,	'Remada Alta',	'Segure o halter comi os braços estendidos; use uma pegada com o dorso das mãos voltado para cima, braços afastados na largura dos ombros.\r\nTracione a barra do haltere verticalmente para cima, levantando os cotovelos até a altura do ombro.',	'http://localhost/FitSan/uploads/exercicios/remalt.png',	NULL),
(74,	30,	'Elevação lateral Halter',	'Na posição em pé ereta, segure os halters com os braços estendidos.\r\nLevante os braços para fora e para os lados do corpo, até que os halteres atinjam o nível dos ombros.\r\nAbaixe os halteres de volta para os quadris.',	'http://localhost/FitSan/uploads/exercicios/elehalt.png',	NULL),
(75,	30,	'Elevação lateral com cabo',	'Com uma das mãos, agarre o pegador preso a uma polia baixa.\r\nLevante a mão para fora, fazendo um arco amplo, até o nível do ombro, mantendo o cotovelo rígido.\r\nAbaixe o cabo de volta no nível da cintura',	'http://localhost/FitSan/uploads/exercicios/cavb.png',	NULL),
(76,	30,	'Elevação lateral no aparelho',	'Para executar a elevação lateral aparelho:\r\nSente-se no aparelho com os cotovelos contra as almofadas protetoras e agarre os pegadores.\r\nLevante os cotovelos até o nível do ombro, braços paralelos ao chão.\r\nAbaixe os cotovelos de volta aos lados do corpo.',	'http://localhost/FitSan/uploads/exercicios/apah.png',	NULL),
(77,	31,	'Elevação lateral com halter inclinado',	'Segurando dois halteres com os braços estendidos, incline o corpo para a frente usando a cintura, mantendo as costas retas e a cabeça levantada.\r\nCom as palmas das mãos voltadas para dentro, levante os halteres para cima até o nível das orelhas, mantendo os cotovelos ligeiramente dobrados.\r\nAbaixe os halteres de volta à posição inicial.',	'http://localhost/FitSan/uploads/exercicios/hatkfix.png',	NULL),
(78,	31,	'Elevação lateral com cabo  -  inclinado',	'Com o pegador esquerdo na mão direita, e o direito na mão esquerda, fique em pé no meio, e em seguida, incline o corpo para a frente usando a cintura, com as costas retas e paralelas ao chão.\r\nLevante as mãos para cima em um arco até o nível dos ombros, de tal modelo que os cabos se cruzem.',	NULL,	NULL),
(79,	31,	'Crossover invertido',	'Utilizando uma pegada com os polegares apontando para cima, segure os pegadores presos a duas polias altas (pegador esquerdo na mão direita, pegador direito na mão esquerda), fique de pé em posição central, com as polias à sua frente. (Atenção: durante o cruzamento dos cabos para o tórax, as polias ficam atrás de seu corpo.)\r\nImpulsione as mãos para trás (e ligeiramente para baixo) em um arco, com os braços praticamente paralelos ao chão até que as mãos estejam alinhadas com os ombros (formando um T).\r\nRetorne os pegadores de volta à posição inicial, de modo que a mão direita fique diretamente à frente do ombro esquerdo, e a mão esquerda diretamente à frente do ombro direito.',	NULL,	NULL),
(80,	31,	'Crucifixo invertido no aparelho',	'Para executar o Crucifixo invertido aparelho:\r\nSente-se de frente para o aparelho com o peito contra o encosto do banco e pegue os pegadores com o braço estendido ao nível do ombro.\r\nPuxe os pegadores para trás no arco mais distante possível, mantendo os cotovelos elevados e braços paralelos ao chão.',	'http://localhost/FitSan/uploads/exercicios/ccccc.png',	NULL),
(81,	32,	'Rotação interna ',	'Fique de pé, posicionado de lado com relação a uma polia de cabo ajustada à altura da cintura; agarre o pegador com a mão “de dentro” e com o polegar apontando para cima.\r\nCom o cotovelo mantido firmemente contra a cintura, puxe o pegador para dentro, passando à frente do seu corpo e mantendo o antebraço paralelo ao chão.\r\nRetorne lentamente o pegador de volta a posição inicial.',	NULL,	NULL),
(82,	32,	'Rotação externa ',	'Fique de pé, posicionado de lado com relação a uma polia de cabo ajustada à altura da cintura; agarre o pegador com a mão “de fora” e com o polegar apontando para cima.\r\nCom o cotovelo mantido firmemente contra a cintura, movimente o pegador em um arco para fora, afastando-o do corpo e mantendo o antebraço paralelo ao chão.\r\nRetorne lentamente o pegador à posição inicial, em frente ao umbigo\r\n',	NULL,	NULL),
(83,	32,	'Elevação lateral apoiado',	'Para executar a Elevação lateral apoiado:\r\nDeite-se de lado sobre um banco com o torso inclinado em 45 graus, apoiado pelo braço que está abaixo do corpo.\r\nUsando uma pegada com o dorso da mão voltado para cima, levante o halter até a altura da cabeça, mantendo o cotovelo bloqueado.',	NULL,	NULL),
(84,	16,	'Esteira',	'Saber como pisar na esteira é fundamental, pois o movimento começa pelo calcanhar, passando pela sola até atingir os pés. O calcanhar tem a função de amortecer o impacto da atividade aeróbica. Ao pisar corretamente, você garante o desempenho do exercício e protege os músculos que serão movimentados.',	NULL,	NULL),
(85,	16,	'Bicicleta ergométrica',	'Uma bicicleta ergométrica lhe permite realizar um exercício cardiovascular simulando um passeio de bicicleta.',	NULL,	NULL),
(86,	16,	'Eliptico',	'Suba no aparelho, virado para o monitor.\r\nComece a pedalar para ativar o aparelho. \r\nComece a pedalar em um ritmo estável. \r\nNão trave os joelhos. \r\nAumente a resistência. \r\nMude a direção dos pedais. \r\nUse os braços do aparelho. \r\nAumente a inclinação e a resistência enquanto treina.',	NULL,	NULL),
(87,	8,	'Flexão de braço (apoio)',	'O primeiro passo é ficar de joelhos; \r\naí você apoia as mãos logo abaixo do ombro, levemente mais abertas; \r\ncoloca os pés juntos para trás, ficando na ponta dos dedos; \r\ne estica o corpo, deixando as costas retas.\r\nContraindo o abdômen, você desce com o tronco até o peitoral encostar no chão ou ficar próximo dele;\r\ne volta para a posição inicial. ',	NULL,	NULL),
(88,	7,	'Tríceps no banco',	'Nesse exercício de musculação para o tríceps você vai precisar para colocar um banco atrás das costas.\r\nCom o banco perpendicular ao seu corpo, apoie suas mãos em sua borda com as mãos totalmente estendidos, separados na largura dos ombros.\r\nAs pernas serão estendidas para frente, dobrada na cintura e perpendicular ao seu tronco. \r\nAbaixe lentamente o seu corpo como dobrando os cotovelos até que eles fiquem em um ângulo ligeiramente menor do que 90 graus entre o braço e o antebraço.\r\n',	NULL,	NULL),
(91,	6,	'mermao',	'mermao',	NULL,	14);

DROP TABLE IF EXISTS `planilha_grupoMuscuCardio`;
CREATE TABLE `planilha_grupoMuscuCardio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha_grupoMuscuCardio`;
INSERT INTO `planilha_grupoMuscuCardio` (`id`, `nome`) VALUES
(6,	'Biceps'),
(7,	'Tríceps'),
(8,	'AnteBraço'),
(16,	'Cárdio'),
(17,	'Costa(Lombar)'),
(18,	'Costa(Dorsal)'),
(19,	'Costa(Trapézio)'),
(20,	'Perna(Quadriceps)'),
(21,	'Perna(Panturrilha)'),
(22,	'Perna(Posterior da Coxa)'),
(23,	'Peitoral Superior '),
(24,	'Peitoral Médio'),
(25,	'Peitoral Inferior'),
(26,	'Superior '),
(27,	'Oblíquo'),
(28,	'Inferior'),
(29,	'Deltoide Superior'),
(30,	'Deltoide Lateral'),
(31,	'Deltoide Posterior'),
(32,	'Manguito Rotador');

DROP TABLE IF EXISTS `planilha_tabela`;
CREATE TABLE `planilha_tabela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `musculo_cardio_id` int(11) NOT NULL,
  `exercicio_id` int(11) NOT NULL,
  `series` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repeticoes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intervalo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempo` int(11) DEFAULT NULL,
  `profissional_id` int(11) NOT NULL,
  `planilha_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `planilha_tabela`;
INSERT INTO `planilha_tabela` (`id`, `grupo`, `musculo_cardio_id`, `exercicio_id`, `series`, `repeticoes`, `carga`, `intervalo`, `tempo`, `profissional_id`, `planilha_id`) VALUES
(1,	'Grupo A',	16,	84,	NULL,	NULL,	NULL,	NULL,	30,	2,	1),
(2,	'Grupo A',	16,	85,	NULL,	NULL,	NULL,	NULL,	30,	2,	1),
(3,	'Grupo A',	16,	86,	NULL,	NULL,	NULL,	NULL,	30,	2,	1),
(4,	'Grupo B',	16,	84,	NULL,	NULL,	NULL,	NULL,	30,	2,	1),
(5,	'Grupo B',	16,	85,	NULL,	NULL,	NULL,	NULL,	30,	2,	1),
(6,	'Grupo B',	16,	86,	NULL,	NULL,	NULL,	NULL,	30,	2,	1),
(7,	'Grupo A',	6,	56,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(8,	'Grupo A',	7,	63,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(9,	'Grupo A',	8,	52,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(10,	'Grupo A',	17,	11,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(11,	'Grupo A',	18,	1,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(12,	'Grupo A',	29,	68,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(13,	'Grupo A',	32,	81,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(14,	'Grupo A',	30,	73,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(15,	'Grupo A',	22,	23,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(16,	'Grupo A',	25,	35,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(17,	'Grupo B',	32,	83,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(18,	'Grupo B',	30,	76,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(19,	'Grupo B',	27,	47,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(20,	'Grupo B',	26,	42,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(21,	'Grupo B',	22,	25,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(22,	'Grupo B',	19,	4,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(23,	'Grupo B',	8,	87,	'11',	'3',	'10',	'15',	NULL,	2,	1),
(24,	'Grupo A',	25,	37,	'1',	'1',	'1',	'1',	NULL,	7,	2),
(25,	'Grupo A',	19,	3,	'1',	'1',	'1',	'1',	NULL,	7,	2),
(26,	'Grupo A',	20,	16,	'1',	'1',	'11',	'1',	NULL,	7,	2),
(27,	'Grupo A',	26,	40,	'1',	'1',	'1',	'1',	NULL,	7,	2),
(28,	'Grupo A',	17,	12,	'1',	'1',	'1',	'1',	NULL,	7,	2),
(29,	'Grupo B',	16,	85,	NULL,	NULL,	NULL,	NULL,	1,	7,	2),
(30,	'Grupo B',	25,	36,	'1',	'1',	'1',	'1',	NULL,	7,	2),
(31,	'Grupo B',	19,	3,	'1',	'1',	'1',	'1',	NULL,	7,	2),
(32,	'Grupo C',	17,	11,	'1',	'1',	'1',	'1',	NULL,	7,	2);

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `tipo_usuario`;
INSERT INTO `tipo_usuario` (`id`, `tipo`) VALUES
(1,	'aluno'),
(2,	'profissional');

DROP TABLE IF EXISTS `upload_dica`;
CREATE TABLE `upload_dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_arq` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dica_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `upload_dica`;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` datetime NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sobrenome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datanasc` date DEFAULT NULL,
  `sexo` enum('masculino','feminino') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `status` enum('ativado','desativado','excluido') COLLATE utf8mb4_unicode_ci DEFAULT 'ativado',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `usuario`;
INSERT INTO `usuario` (`id`, `datahora`, `nome`, `sobrenome`, `datanasc`, `sexo`, `foto`, `senha`, `email`, `tipo_id`, `status`) VALUES
(1,	'2018-10-22 21:19:08',	'Administrador',	'Geral',	NULL,	NULL,	NULL,	'$2y$10$F4o1IGnrLVcWQaibszv.9O18QcUQ0cES8XYr6Hqv0lqiic00dC8vC',	'admin@admin',	NULL,	'ativado'),
(2,	'2018-10-22 21:20:25',	'Karen',	'Guzzatti Konig ',	'1988-08-14',	'feminino',	'http://localhost/FitSan/uploads/captura_de_tela_2018-10-19_a_s_12.50.31_pm.png',	'$2y$10$F4o1IGnrLVcWQaibszv.9O18QcUQ0cES8XYr6Hqv0lqiic00dC8vC',	'karen@karen',	2,	'ativado'),
(3,	'2018-10-22 21:44:12',	'Diego ',	'Pereira ',	'1986-08-06',	'masculino',	'http://localhost/FitSan/uploads/captura_de_tela_2018-10-19_s_12.41.18_pm.png',	'$2y$10$DC/xIWpYGoulWnSjMvirfe.iXCbphU2Gu/kNdoXs3r74j01VXEJDK',	'diego@diego',	1,	'ativado'),
(4,	'2018-10-22 22:56:06',	'Adryan',	'Pereira Ponciano ',	NULL,	'masculino',	'http://localhost/FitSan/uploads/image.jpg',	'$2y$10$bACF5IUZFecjk8yf/IRttOYbErqqhDn3L3fMnOrHztFKwsrLKeUmO',	'ady@ady',	1,	'ativado'),
(5,	'2018-10-23 02:59:41',	'Neide',	'Guzzatti Konig   ',	NULL,	NULL,	NULL,	'$2y$10$A2rXzBZoLvm93mZC1n/4ae0goY8hCU85H4wgZi1pqGKKSlogtnopO',	'neide@neide',	1,	'ativado'),
(6,	'2018-10-23 03:00:10',	'Gerson',	'Konig ',	NULL,	NULL,	NULL,	'$2y$10$nAlkVRBq2m1mtzbXhSt0I.qAraPUksKTv2oYHBG87hjRQa1yaAdYu',	'gerson@gerson',	1,	'ativado'),
(7,	'2018-10-23 03:00:49',	'Charles',	'Konig ',	NULL,	NULL,	NULL,	'$2y$10$UBROJJf9c8nFSQYIEevlRuM9EUK/KM8dt5htlVeucllueByMRqNXG',	'charles@charles',	2,	'ativado'),
(8,	'2018-10-23 13:13:20',	'Sanem',	'Aydin ',	NULL,	'feminino',	'http://localhost/FitSan/uploads/4g7s1pr892x_erkenci-kus-pa_ssaro-madrugador-5.jpg',	'$2y$10$I1Dwn7vXMPteuqeXMFzTdevrmjAGCY5LQp8wLaXXx4Kb.RtRhVkqS',	'san@san',	1,	'ativado'),
(9,	'2018-10-23 13:15:29',	'Can',	'Divit ',	'1989-11-08',	'masculino',	'http://localhost/FitSan/uploads/dbb0c5002e1ded8cb966c693e0c83fc4.jpg',	'$2y$10$6Qupknhthq6yUezblxyOau4xpopuUyVPCLzwC5gxEU3f94SlyGThW',	'can@can',	1,	'ativado'),
(10,	'2018-10-23 13:43:47',	'Adryene',	'Pereira Ponciano ',	'2006-04-16',	NULL,	'http://localhost/FitSan/uploads/image-1.jpg',	'$2y$10$dNiegeFy4tn3ljH9dIdZjOTwFmSmw7goNpW2QZfX9RnXaJy8fRg8K',	'dy@dy',	1,	'ativado'),
(11,	'2018-10-23 13:45:12',	'Nathaly',	'Pereira Ponciano ',	'2006-05-20',	'feminino',	'http://localhost/FitSan/uploads/images.jpeg',	'$2y$10$9I50u2yuYWIN7FaLfsyOOe2ERWZZ/uHasJA35kq4lWmOn.wC6rWWW',	'tata@tata',	1,	'ativado'),
(12,	'2018-10-28 21:27:47',	'Lua',	'Ana ',	NULL,	NULL,	NULL,	'$2y$10$1QCGX81RJhXt9OgqVfiXSO9u06MsI12xh1h/bdsMYXcm59gse0H.C',	'luana@luana',	2,	'ativado');

DROP TABLE IF EXISTS `vinculo`;
CREATE TABLE `vinculo` (
  `aluno_id` int(11) NOT NULL,
  `profissional_id` int(11) NOT NULL,
  `solicitante` enum('aluno','profissional') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('espera','aprovado','negado') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`aluno_id`,`profissional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `vinculo`;
INSERT INTO `vinculo` (`aluno_id`, `profissional_id`, `solicitante`, `status`) VALUES
(3,	2,	'aluno',	'aprovado'),
(4,	2,	'profissional',	'aprovado'),
(5,	2,	'profissional',	'aprovado'),
(6,	2,	'profissional',	'aprovado'),
(8,	2,	'aluno',	'aprovado'),
(9,	2,	'aluno',	'aprovado'),
(9,	7,	'aluno',	'aprovado'),
(9,	12,	'profissional',	'espera'),
(10,	2,	'aluno',	'aprovado'),
(11,	2,	'aluno',	'aprovado');

-- 2018-10-29 06:02:54
