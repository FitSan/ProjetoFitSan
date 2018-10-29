-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 18-Out-2018 às 21:51
-- Versão do servidor: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitsan`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativ_extras`
--

DROP TABLE IF EXISTS `ativ_extras`;
CREATE TABLE IF NOT EXISTS `ativ_extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ativ_extras`
--

INSERT INTO `ativ_extras` (`id`, `datahora`, `titulo`, `texto`, `aluno_id`) VALUES
(1, '2018-10-02 02:59:03', 'Futebol com a galera', 'Joguei uma hora de futebol com  a galera. OBS: sou goleiro.', 6),
(2, '2018-10-02 03:13:45', 'Joguei bola no colégio', 'Hoje joguei volei na escola.', 10),
(3, '2018-10-02 03:14:23', 'Caminhada', 'Caminhei da escola até em casa, e minha casa é longe.', 10),
(4, '2018-10-02 03:14:47', 'Brinquei de pega- pega', 'Brinquei com minhas amigas de pega-pega', 10),
(5, '2018-10-02 03:15:21', 'Dancei na aula de dança', 'Fui para minha aula de dança e dancei por uma hora.', 10),
(6, '2018-10-02 03:16:01', 'Corri até o mercado', 'Hoje corri de casa até o mercado.', 10),
(7, '2018-10-02 03:19:06', 'Festa do pijama', 'Dançamos muito. Umas duas horas direto', 10),
(8, '2018-10-02 03:25:46', 'Fui com a minha mãe até no centro', 'Hoje fomos comprar meu material escolar, fomos caminhando e voltamos com meu pai de carro.', 10),
(9, '2018-10-02 03:26:25', 'Caminhada na praia ', 'Caminhei com minhas amiguinhas pela praia ..', 10),
(10, '2018-10-02 03:26:48', 'Corri na praia ', 'Corri com minhas amiguinhas pela praia...', 10),
(11, '2018-10-02 03:27:44', 'Ping-Pong no colégio ', 'Na educação física fizemos um campeonato. Fiquei em segundo lugar! ', 10),
(12, '2018-10-02 03:58:36', 'Andei de skate ', 'Andei com o \r\nskate do meu irmão', 10),
(13, '2018-10-02 04:35:09', 'Caminhada na praia', 'Caminhei com minhas irmãs na praia', 9),
(14, '2018-10-02 04:35:54', 'Treinei ', 'Treinei basquete na escola.', 9),
(15, '2018-10-08 02:21:12', 'Andando até a escola.', 'Caminhei até a escola onde fui votar ', 6),
(16, '2018-10-14 05:47:42', 'fui correr no bosque', 'Corri 5 horas da policia ', 6),
(17, '2018-10-14 06:03:22', 'asdf', 'asddgg', 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativ_extras_exercicios`
--

DROP TABLE IF EXISTS `ativ_extras_exercicios`;
CREATE TABLE IF NOT EXISTS `ativ_extras_exercicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ativ_extras_id` int(11) DEFAULT NULL,
  `exercicio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ativ_extras_exercicios`
--

INSERT INTO `ativ_extras_exercicios` (`id`, `ativ_extras_id`, `exercicio`) VALUES
(1, 1, 'Futebol'),
(2, 2, 'Outros'),
(3, 3, 'Caminhada'),
(4, 4, 'Outros'),
(5, 5, 'Outros'),
(6, 6, 'Corrida'),
(7, 7, 'Outros'),
(8, 8, 'Caminhada'),
(9, 9, 'Caminhada'),
(10, 10, 'Corrida'),
(11, 11, 'Ping-Pong'),
(13, 12, 'Skate'),
(14, 13, 'Caminhada'),
(15, 14, 'Basquete'),
(16, 15, 'Caminhada'),
(17, 16, 'Corrida'),
(18, 17, 'Skate');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `desempenho` text COLLATE utf8_unicode_ci NOT NULL,
  `frequencia` text COLLATE utf8_unicode_ci NOT NULL,
  `grupo_cumpriu` text COLLATE utf8_unicode_ci NOT NULL,
  `grupo_duvida` text COLLATE utf8_unicode_ci NOT NULL,
  `grupo_dificuldade` text COLLATE utf8_unicode_ci NOT NULL,
  `caso_sim` text COLLATE utf8_unicode_ci NOT NULL,
  `consideracoes` text COLLATE utf8_unicode_ci NOT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `data`, `desempenho`, `frequencia`, `grupo_cumpriu`, `grupo_duvida`, `grupo_dificuldade`, `caso_sim`, `consideracoes`, `profissional_id`, `aluno_id`) VALUES
(29, '2018-10-14 04:04:00', 'bom', 'boa', 'sim', 'sim', 'sim', 'oi', 'oi', 2, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_meta`
--

DROP TABLE IF EXISTS `dados_meta`;
CREATE TABLE IF NOT EXISTS `dados_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_add` date NOT NULL,
  `peso_add` decimal(6,3) NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci,
  `meta_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `dados_meta`
--

INSERT INTO `dados_meta` (`id`, `data_add`, `peso_add`, `descricao`, `meta_id`) VALUES
(1, '2018-10-15', '40.000', NULL, 1),
(2, '2018-10-15', '40.000', NULL, 2),
(3, '2018-10-20', '15.000', NULL, 3),
(4, '2018-10-20', '15.000', NULL, 4),
(5, '2018-11-27', '50.000', '', 4),
(6, '2018-10-24', '80.000', '', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dica`
--

DROP TABLE IF EXISTS `dica`;
CREATE TABLE IF NOT EXISTS `dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `profissional_nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  `data_envio` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `dica`
--

INSERT INTO `dica` (`id`, `texto`, `profissional_nome`, `profissional_id`, `data_envio`) VALUES
(6, '• Rotina de exercícios\r\n\r\nA dica aqui é encarar a prática de exercícios como um compromisso. \r\nSe você tem dificuldade de seguir uma rotina, lembre-se que é tudo questão de prática: \r\numa maneira de encarar o treino com mais vontade é escolher uma modalidade que gosta.', 'Karen', 2, '2018-10-02 01:21:12'),
(7, '• Alimentação equilibrada\r\n\r\nÉ preciso organização para evitar possíveis escorregões na dieta, principalmente com tantas tentações culinária por perto. Sempre dê preferência aos lanches caseiros e evite comida industrializada.\r\n\r\nO maior segredo de comer bem é saber dosar as quantidades e equilibrar as escolhas. Não se prive das delícias culinárias em ocasiões especiais.', 'Karen', 2, '2018-10-02 01:20:26'),
(8, 'CONHEÇA OS BENEFÍCIOS DA BATATA DOCE\r\nParece até mentira que um alimento que leva “batata” e “doce” no nome possa ser saudável. \r\nMas sim, ele é. A batata doce já conquistou espaço na dieta dos marombeiros, das blogueiras e de todos que buscam uma alimentação balanceada. \r\nQuer motivos para entrar nessa onda? Confira:\r\n\r\n– a batata doce é um dos alimentos mais nutritivos do mundo;\r\n– é um carboidrato complexo de baixo índice glicêmico. Por isso, a absorção é mais lenta, aumentando a sensação de saciedade;\r\n– é rica em antioxidantes e excelente fonte das vitaminas A e C;\r\n– tem poder anti-inflamatório, graças à vitamina C, vitamina B6, betacaroteno e manganês;\r\n– é bem menos calórica que a batata normal e o arroz;\r\n– por liberar energia lentamente, é uma ótima opção para antes do treino. Assim, além de manter o estômago forrado, dá aquele gás pra queimar calorias;\r\n– versátil: pode ser assada, cozida e utilizada em pratos doces ou salgados;\r\n– fica gostosa tanto fria quanto quente.\r\n\r\nViu só como a batata doce é o alimento que não pode faltar na sua lista de compras? \r\n\r\nAposte em uma variação no cardápio e delicie-se!', 'Luana ', 3, '2018-10-02 01:30:38'),
(9, 'VAMOS TREINAR EM UM LUGAR MAIS VERDE?\r\n\r\nAcordar cedo e ir treinar dá a maior preguiça, não dá? Quem não pensa em trocar o treino por mais 15 minutinhos de sono de beleza? \r\nPor isso, o treino da manhã tem que ser algo leve, gostoso e muito, muito verde!\r\nTem um parque perto da sua casa? Uma praça? Você tem uma bicicleta? Um tênis de corrida?\r\nEntão, que tal treinar em um ambiente que te coloque em contato com a natureza e relaxe a sua mente enquanto você trabalha o corpo?\r\nO treino ao ar livre é uma maneira mais orgânica de praticar exercícios que te darão mais disposição para o decorrer do dia. Além de entrar em contato com a natureza, \r\nrespirar ar puro e evitar o tumulto da academia, você pode realizar atividades ótimas para o seu bem-estar, e o principal aparelho é o seu próprio corpo!\r\n\r\nAqui está uma lista com alguns dos exercícios que você pode fazer em um treino ao ar livre:\r\n\r\n– correr;\r\n– andar de bicicleta;\r\n– pular corda;\r\n– burpees;\r\n– polichinelos;\r\n– subir e descer escadas;\r\n– variações na barra fixa;\r\n– flexão de braço;\r\n– tríceps nas barras paralelas e no banco;\r\n– agachamento livre;\r\n– step com elevação das pernas;\r\n– variações de abdominal;\r\n– prancha.\r\n\r\nComece os exercícios aquecendo o corpo. Aposte numa corridinha no parque ou em volta de uma praça. Por que não ir até lá de bike?\r\nÉ importante ativar o corpo antes de começar as atividades.\r\nTambém não se esqueça de se manter hidratado durante toda a prática!\r\n\r\nE aí, bora treinar ao ar livre amanhã de manhã?\r\n\r\nLembre-se de fazer os exercícios devagar, com segurança e, se possível, estar acompanhado de um profissional que \r\nprepare um treino específico para você e que fiscalize a execução. Bom treino!', 'Luana ', 3, '2018-10-02 01:30:03'),
(10, 'oi', 'Karen', 2, '2018-10-14 02:59:06'),
(11, 'Aprenda a usar a informática para emagrecer.\r\nCom o FitSan você pode acompanhar  o progresso de seus exercícios \r\nalém de poder ter um acompanhamento profissional de vários especialistas,\r\nentre treinadores, nutricionistas e muitos outros profissionais.\r\nFaça  hoje mesmo um teste inteiramente grátis e veja o que podemos fazer por você.', 'Charles', 14, '2018-10-14 03:35:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais`
--

DROP TABLE IF EXISTS `informacoes_adicionais`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `informacoes_adicionais`
--

INSERT INTO `informacoes_adicionais` (`id`, `saude`, `medico`, `alergia`, `medicamento`, `gruposangue`, `doador`, `academia_frequentada`, `academia_atual`, `aluno_id`) VALUES
(1, 'Gastrite nervosa', 'nenhuma...', 'Camarão', 'nenhum...', 'B-', 'SIM', 'Atletic', 'nenhuma', 6),
(2, 'Tireoide', 'Cirurgia de retirada de amígdala e adenoide.', 'nenhuma...', 'Purant', 'B-', 'NAO', 'nenhuma', 'nenhuma', 10),
(3, 'Nenhum', 'Nenhum', 'Nenhum', 'Nenhum', 'B+', 'SIM', 'Nenhuma', 'Nenhuma', 9),
(4, 'asdfg', 'dfgh', 'sdfggh', 'sdffg', 'B-', 'SIM', 'ssdff', 'asdfg', 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais_contatos`
--

DROP TABLE IF EXISTS `informacoes_adicionais_contatos`;
CREATE TABLE IF NOT EXISTS `informacoes_adicionais_contatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `informacoes_adicionais_contatos`
--

INSERT INTO `informacoes_adicionais_contatos` (`id`, `tipo`, `nome`, `telefone`, `informacoes_adicionais_id`) VALUES
(1, 'Cônjuge', 'Karen Guzzatti Konig', '(48)9917-05657', 1),
(2, 'Irmã', 'Daiane Pereira', '(48)9999-0000', 1),
(3, 'Mãe', 'Daiane Pereira', '(48)9947-05454', 2),
(4, 'Pai', 'Mauro Ponciano', '(48)9833-05354', 2),
(6, 'Mãe', 'Daiane Pereira', '(48)991705657', 3),
(7, 'Pai', 'Mauro Ponciano', '(48)0000-0000', 3),
(10, 'Pai', 'kakakakka', '12345667', 4),
(11, 'Irmão', 'kakakaka', '54322113', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais_exercicios`
--

DROP TABLE IF EXISTS `informacoes_adicionais_exercicios`;
CREATE TABLE IF NOT EXISTS `informacoes_adicionais_exercicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exercicios` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `informacoes_adicionais_exercicios`
--

INSERT INTO `informacoes_adicionais_exercicios` (`id`, `exercicios`, `informacoes_adicionais_id`) VALUES
(1, 'Futebol', 1),
(2, 'Ping-Pong', 2),
(3, 'Dança', 2),
(4, 'Volei', 2),
(7, 'Basquete', 3),
(8, 'Skate', 3),
(24, 'Futebol', 4),
(25, 'Karatê', 4),
(26, 'Basquete', 4),
(27, 'Balé', 4),
(28, 'Jiu-jitsu', 4),
(29, 'Corrida', 4),
(30, 'Caminhada', 4),
(31, 'Ping-Pong', 4),
(32, 'Skate', 4),
(33, 'Natação', 4),
(34, 'Bicicleta', 4),
(35, 'qwer', 4),
(36, '1233', 4),
(37, 'awert', 4),
(38, 'asdsdf', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_adicionais_medidas`
--

DROP TABLE IF EXISTS `informacoes_adicionais_medidas`;
CREATE TABLE IF NOT EXISTS `informacoes_adicionais_medidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `altura` decimal(7,2) DEFAULT NULL,
  `peso` decimal(7,3) DEFAULT NULL,
  `massa_magra` decimal(7,3) DEFAULT NULL,
  `gordura_corporal` decimal(7,3) DEFAULT NULL,
  `informacoes_adicionais_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `informacoes_adicionais_medidas`
--

INSERT INTO `informacoes_adicionais_medidas` (`id`, `altura`, `peso`, `massa_magra`, `gordura_corporal`, `informacoes_adicionais_id`) VALUES
(1, '1.73', '78.000', '30.000', '20.000', 1),
(2, '1.45', '32.000', '10.000', '12.000', 2),
(4, '1.62', '42.000', '17.000', '10.000', 3),
(5, '123.00', '123.000', '123.000', '123.000', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `meta`
--

DROP TABLE IF EXISTS `meta`;
CREATE TABLE IF NOT EXISTS `meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('PERDER','GANHAR','MANTER') COLLATE utf8_unicode_ci NOT NULL,
  `data_inicial` date NOT NULL,
  `data_final` date NOT NULL,
  `peso_inicial` decimal(6,3) NOT NULL,
  `peso_final` decimal(6,3) NOT NULL,
  `status` enum('ativa','finalizada','cancelada') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ativa',
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `meta`
--

INSERT INTO `meta` (`id`, `tipo`, `data_inicial`, `data_final`, `peso_inicial`, `peso_final`, `status`, `usuario_id`) VALUES
(1, 'MANTER', '2018-10-15', '2018-10-17', '40.000', '40.000', 'finalizada', 16),
(2, 'MANTER', '2018-10-15', '2018-10-17', '40.000', '40.000', 'finalizada', 16),
(3, 'GANHAR', '2018-10-20', '2018-10-27', '50.000', '60.000', 'cancelada', 16),
(4, 'GANHAR', '2018-10-20', '2018-11-27', '15.000', '16.000', 'ativa', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

DROP TABLE IF EXISTS `notificacao`;
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `notificacao`
--

INSERT INTO `notificacao` (`id`, `data`, `lido`, `status`, `texto`, `profissional_id`, `aluno_id`, `dados`) VALUES
(1, '2018-10-01 23:52:53', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(2, '2018-10-01 23:53:04', 'N', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 7, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"7\";s:5:\"table\";s:7:\"vinculo\";}'),
(3, '2018-10-01 23:53:06', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 13, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"13\";s:5:\"table\";s:7:\"vinculo\";}'),
(4, '2018-10-01 23:53:15', 'N', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 12, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"12\";s:5:\"table\";s:7:\"vinculo\";}'),
(5, '2018-10-02 00:10:06', 'L', 'INFO', 'Você tem uma nova solicitação de Adryene Pereira Ponciano <br> O que deseja fazer? <a href=\"status_vinculo.php?id=10&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=10&status=negado\">Negar</a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"10\";s:5:\"table\";s:7:\"vinculo\";}'),
(6, '2018-10-02 01:23:45', 'L', 'INFO', 'Você tem uma nova solicitação de Luana  Gabriely Spricigo <br> O que deseja fazer? <a href=\"status_vinculo.php?id=3&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=3&status=negado\">Negar</a>', NULL, 9, 'a:3:{s:15:\"profissional_id\";s:1:\"3\";s:8:\"aluno_id\";s:1:\"9\";s:5:\"table\";s:7:\"vinculo\";}'),
(7, '2018-10-02 01:23:58', 'L', 'INFO', 'Você tem uma nova solicitação de Luana  Gabriely Spricigo <br> O que deseja fazer? <a href=\"status_vinculo.php?id=3&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=3&status=negado\">Negar</a>', NULL, 11, 'a:3:{s:15:\"profissional_id\";s:1:\"3\";s:8:\"aluno_id\";s:2:\"11\";s:5:\"table\";s:7:\"vinculo\";}'),
(8, '2018-10-02 01:24:01', 'L', 'INFO', 'Você tem uma nova solicitação de Luana  Gabriely Spricigo <br> O que deseja fazer? <a href=\"status_vinculo.php?id=3&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=3&status=negado\">Negar</a>', NULL, 10, 'a:3:{s:15:\"profissional_id\";s:1:\"3\";s:8:\"aluno_id\";s:2:\"10\";s:5:\"table\";s:7:\"vinculo\";}'),
(9, '2018-10-04 23:35:31', 'L', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(10, '2018-10-04 23:39:04', 'L', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 8, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:1:\"8\";s:5:\"table\";s:7:\"vinculo\";}'),
(11, '2018-10-04 23:39:06', 'L', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 9, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:1:\"9\";s:5:\"table\";s:7:\"vinculo\";}'),
(12, '2018-10-04 23:39:08', 'L', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 10, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:2:\"10\";s:5:\"table\";s:7:\"vinculo\";}'),
(13, '2018-10-04 23:39:08', 'L', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 11, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:2:\"11\";s:5:\"table\";s:7:\"vinculo\";}'),
(14, '2018-10-05 00:18:29', 'L', 'INFO', 'Você tem uma nova solicitação de Angelina Guzzatti <br> O que deseja fazer? <a href=\"status_vinculo.php?id=13&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=13&status=negado\"><i class=\"fa fa-close \"></i></a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"13\";s:5:\"table\";s:7:\"vinculo\";}'),
(15, '2018-10-05 00:19:40', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<a href=\"status_vinculo.php?id=2&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=2&status=negado\"><i class=\"fa fa-close \"></i></a>', NULL, 13, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"13\";s:5:\"table\";s:7:\"vinculo\";}'),
(16, '2018-10-05 00:24:09', 'L', 'INFO', 'Você tem uma nova solicitação de Angelina Guzzatti <a href=\"status_vinculo.php?id=13&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=13&status=negado\"><i class=\"fa fa-close \"></i></a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"13\";s:5:\"table\";s:7:\"vinculo\";}'),
(17, '2018-10-05 00:25:39', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<a href=\"status_vinculo.php?id=2&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=2&status=negado\"><i class=\"fa fa-close \"></i></a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(18, '2018-10-05 00:32:33', 'L', 'INFO', 'Você tem uma nova solicitação de Diego Pereira <a href=\"status_vinculo.php?id=6&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=6&status=negado\"><i class=\"fa fa-close \"></i></a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(19, '2018-10-05 00:35:17', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<a href=\"status_vinculo.php?id=2&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=2&status=negado\"><i class=\"fa fa-close \"></i></a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(20, '2018-10-05 00:38:28', 'L', 'INFO', 'Você tem uma nova solicitação de Diego Pereira <a href=\"status_vinculo.php?id=6&status=aprovado\"><i class=\"fa fa-check\"></i></a> <a href=\"status_vinculo.php?id=6&status=negado\"><i class=\"fa fa-close \"></i></a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(21, '2018-10-05 00:57:37', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(22, '2018-10-05 00:59:04', 'L', 'INFO', 'Você tem uma nova solicitação de Diego Pereira <br> O que deseja fazer? <a href=\"status_vinculo.php?id=6&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=6&status=negado\">Negar</a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(23, '2018-10-05 00:59:21', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(24, '2018-10-05 01:00:14', 'L', 'INFO', 'Você tem uma nova solicitação de Diego Pereira <br> O que deseja fazer? <a href=\"status_vinculo.php?id=6&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=6&status=negado\">Negar</a>', 2, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(25, '2018-10-05 01:00:42', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(26, '2018-10-05 01:01:32', 'L', 'INFO', 'Você tem uma nova solicitação de Diego Pereira <br> O que deseja fazer? <a href=\"status_vinculo.php?id=6&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=6&status=negado\">Negar</a>', 3, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"3\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(27, '2018-10-05 01:02:04', 'L', 'INFO', 'Você tem uma nova solicitação de Karen Guzzatti Konig<br> O que deseja fazer? <a href=\"status_vinculo.php?id=2&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=2&status=negado\">Negar</a>', NULL, 10, 'a:3:{s:15:\"profissional_id\";s:1:\"2\";s:8:\"aluno_id\";s:2:\"10\";s:5:\"table\";s:7:\"vinculo\";}'),
(28, '2018-10-06 02:54:22', 'N', 'INFO', 'Você tem uma nova solicitação de Diego Pereira <br> O que deseja fazer? <a href=\"status_vinculo.php?id=6&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=6&status=negado\">Negar</a>', 4, NULL, 'a:3:{s:15:\"profissional_id\";s:1:\"4\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(29, '2018-10-09 02:56:21', 'N', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=1\">sua planilha</a>', 6, NULL, NULL),
(30, '2018-10-13 01:27:11', 'L', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=2\">sua planilha</a>', NULL, 6, NULL),
(31, '2018-10-14 03:01:44', 'L', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=3\">sua planilha</a>', NULL, 13, NULL),
(32, '2018-10-14 03:36:29', 'N', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 6, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:1:\"6\";s:5:\"table\";s:7:\"vinculo\";}'),
(33, '2018-10-14 03:36:30', 'L', 'INFO', 'Você tem uma nova solicitação de Charles Konig <br> O que deseja fazer? <a href=\"status_vinculo.php?id=14&status=aprovado\">Aceitar</a> <a href=\"status_vinculo.php?id=14&status=negado\">Negar</a>', NULL, 9, 'a:3:{s:15:\"profissional_id\";s:2:\"14\";s:8:\"aluno_id\";s:1:\"9\";s:5:\"table\";s:7:\"vinculo\";}'),
(34, '2018-10-14 03:43:06', 'N', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=4\">sua planilha</a>', NULL, 8, NULL),
(35, '2018-10-14 03:43:06', 'L', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=4\">sua planilha</a>', NULL, 9, NULL),
(36, '2018-10-14 03:43:06', 'N', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=4\">sua planilha</a>', NULL, 10, NULL),
(37, '2018-10-14 03:43:06', 'N', 'OK', 'Uma planilha foi enviada à você.\nAcesse <a href=\"planilha_aluno.php?id=4\">sua planilha</a>', NULL, 11, NULL),
(38, '2018-10-18 11:54:54', 'L', 'INFO', 'Sua meta foi finalizada na data 17 Oct 2018<br><a href=\"okMetaNot.php\">Ok</a>', NULL, 16, NULL),
(39, '2018-10-18 11:55:13', 'L', 'INFO', 'Sua meta foi finalizada na data 17 Oct 2018<br><a href=\"okMetaNot.php\">Ok</a>', NULL, 16, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha`
--

DROP TABLE IF EXISTS `planilha`;
CREATE TABLE IF NOT EXISTS `planilha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha`
--

INSERT INTO `planilha` (`id`, `titulo`) VALUES
(1, 'Corrida de 20 km'),
(2, 'Circuito de emagrecimento'),
(3, 'teste1'),
(4, 'lista');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_aluno`
--

DROP TABLE IF EXISTS `planilha_aluno`;
CREATE TABLE IF NOT EXISTS `planilha_aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_id` int(11) DEFAULT NULL,
  `planilha_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha_aluno`
--

INSERT INTO `planilha_aluno` (`id`, `aluno_id`, `planilha_id`) VALUES
(1, 6, 2),
(2, 13, 3),
(3, 8, 4),
(4, 9, 4),
(5, 10, 4),
(6, 11, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_aluno_exercicio`
--

DROP TABLE IF EXISTS `planilha_aluno_exercicio`;
CREATE TABLE IF NOT EXISTS `planilha_aluno_exercicio` (
  `planilha_feito_id` int(11) NOT NULL,
  `exercicio` int(11) NOT NULL,
  PRIMARY KEY (`planilha_feito_id`,`exercicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha_aluno_exercicio`
--

INSERT INTO `planilha_aluno_exercicio` (`planilha_feito_id`, `exercicio`) VALUES
(5, 17),
(5, 87),
(6, 9),
(6, 11),
(6, 25),
(6, 58),
(7, 64),
(7, 75),
(7, 85),
(9, 64);

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_aluno_feito`
--

DROP TABLE IF EXISTS `planilha_aluno_feito`;
CREATE TABLE IF NOT EXISTS `planilha_aluno_feito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planilha_aluno_id` int(11) DEFAULT NULL,
  `datahora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha_aluno_feito`
--

INSERT INTO `planilha_aluno_feito` (`id`, `planilha_aluno_id`, `datahora`) VALUES
(5, 2, '2018-10-13 05:06:11'),
(6, 2, '2018-10-14 05:48:14'),
(7, 3, '2018-10-14 06:03:05'),
(9, 4, '2018-10-14 06:45:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_exercicio`
--

DROP TABLE IF EXISTS `planilha_exercicio`;
CREATE TABLE IF NOT EXISTS `planilha_exercicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musculo_cardio_id` int(11) DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profissional_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha_exercicio`
--

INSERT INTO `planilha_exercicio` (`id`, `musculo_cardio_id`, `nome`, `descricao`, `foto`, `profissional_id`) VALUES
(1, 18, 'Remada Baixa Sentado', 'Segure os pegadores presos aos cabos com os braços estendidos à frente.\r\nTracione os pegadores superiormente, na direção do peito, mantendo a coluna vertebral reta.\r\nRetorne os pegadores à posição inicial.', NULL, NULL),
(2, 19, 'Remada Alta com barra', 'Segure a barra com afastamento igual à distância entre os ombros; use uma pegada com o dorso das mãos voltado para cima.\r\nTracione a barra verticalmente para cima até chegar ao queixo; eleve o máximo possível os cotovelos.\r\nAbaixe a barra lentamente, até que os braços fiquem na posição estendida.', NULL, NULL),
(3, 19, 'Encolhimento com Halter', 'Em pé, em uma posição ereta com um halter em cada mão, mãos pendentes aos lados do corpo.\r\nMantendo os braços estendidos, encolha os ombros para cima – até o ponho mais alto possível.\r\nAbaixe os halteres de volta para a posição inicial.\r\n', NULL, NULL),
(4, 19, 'Encolhimento com Barra', 'Segure uma barra com os braços estendidos à frente das coxas, utilizando pegada com distância igual à largura dos ombros e com o dorso das mãos voltado para cima.\r\nMantendo os braços contraídos, encolha os ombros até o ponto mais alto possível, tracionando a barra com um movimento vertical para cima.\r\nAbaixe lentamente a barra até a posição inicial, alongando o trapézio.', NULL, NULL),
(5, 18, 'Ramada Serrador', 'Segure um halter fixo com a palma voltada para dentro. Repouse a outra mão e o joelho sobre um banco, mantendo a coluna vertebral reta e praticamente paralela ao chão.\r\nMovimente o halter verticalmente para cima ao longo do torso, levantando o cotovelo até o nível mais alto possível.\r\nAbaixe o halter até a posição inicial.', NULL, NULL),
(6, 18, 'Remada Curvada', 'Fazendo uma pegada na barra com espaçamento igual à largura dos ombros e com o dorso das mãos voltado para cima, incline o torso para a frente em um ângulo de 45 graus com o chão.\r\nTracione a barra verticalmente para cima, até que ela toque a parte inferior do peito, mantendo a coluna vertebral reta e os joelhos ligeiramente dobrados.\r\nAbaixe a barra até a posição de braços estendidos.', NULL, NULL),
(7, 18, 'Remada Articulada', 'Segure os pegadores com os braços estendidos à frente, apoiando o torso contra a almofada peitoral.\r\nTracione os pegadores na direção da parte superior do abdome, mantendo a coluna vertebral reta.\r\nRetorne o peso à posição inicial.', NULL, NULL),
(8, 18, 'Puxador Frontal Fechado', 'Para executar o Puxador Frontal Fechado:\r\nFaça uma pegada na barra com o dorso das mãos voltado para frente (invertido) com as mãos espaçadas em 15 a 30cm.\r\nTracione a barra para baixo até a parte superior do peito, tensionando os latíssimos.\r\n\r\n', NULL, NULL),
(9, 18, 'Puxador Frontal Aberto', 'Para executar o Puxador Frontal Aberto:\r\nFaça uma pegada na barra com o dorso das mãos voltado para cima; as mãos devem ficar a uma distância 15cm maior que a largura dos ombros.\r\nTracione a barra para baixo, até a parte superior do peito, contraindo os latíssimos.', NULL, NULL),
(10, 18, 'Barra', 'Essas flexões com barras são parecidas com as de puxador.', NULL, NULL),
(11, 17, 'Levantamento Terra', 'Faça uma pegada com afastamento igual à largura dos ombros e com o dorso das mãos voltado para cima; braços estendidos e na posição agachada, dobrando joelhos e quadris.\r\nMantendo a coluna vertebral reta e os cotovelos bloqueados, fique de pé, ereto, levantando a barra até o nível dos quadris.\r\nLentamente, abaixe a barra até o chão.', NULL, NULL),
(12, 17, 'Levantamento Bom Dia', 'Fique em pé em uma posição ereta com uma barra sob os ombros.\r\nMantendo a coluna vertebral reta e os joelhos rígidos (estendidos ou ligeiramente dobrados), incline-se para a frente (use a cintura) até que o torso esteja um pouco acima da posição paralela com relação ao chão.\r\nLevante o torso de volta à posição ereta.', NULL, NULL),
(13, 17, 'Extensão Lombar', 'Fique deitado com o rosto voltado para o chão, com os quadris apoiados no banco e tornozelos fixados sob as almofadas.\r\nComece com o torso pendendo para baixo, com flexão de 90 graus na cintura.\r\nEleve o corpo até que o torso esteja um pouco acima da posição de paralelismo com o chão.', NULL, NULL),
(14, 20, 'Leg Press', 'Sente-se no aparelho de leg press e coloque os pés com afastamento na plataforma igual à largura dos ombros.\r\nLentamente, abaixe o peso até que os joelhos estejam com 90 graus de flexão.', 'http://localhost/FitSan/uploads/exercicios/legpress.png', NULL),
(15, 20, 'Extensão de Perna ', 'Sente-se no aparelho e coloque os pés por baixo dos rolos.\r\nLevante as pernas para cima, até que os joelhos estejam estendidos.\r\nAbaixe as pernas de volta à posição inicial, com os joelhos dobrados em 90 graus.', 'http://localhost/FitSan/uploads/exercicios/extdaspernas.png', NULL),
(16, 20, 'Agachamento Hack', 'Posicione as costas contra o encosto e os ombros por baixo dos rolos almofadados e fique em pé com os pés afastados na largura dos ombros sobre a plataforma, com os dedos apontando para frente.\r\nAbaixe lentamente o peso, flexionando os joelhos até 90 graus.\r\n\r\n', 'http://localhost/FitSan/uploads/exercicios/agachamentoh.png', NULL),
(17, 20, 'Agachamento Livre', 'Em pé com a barra apoiada nos ombros e os pés afastados em distância igual à largura dos ombros.\r\nFlexione lentamente os joelhos até que as coxas fiquem paralelas ao chão.\r\nEstenda as pernas para retornar à posição inicial (em pé).', NULL, NULL),
(18, 20, 'Afundo', 'Em pé com os pés afastados na largura dos ombros; segure dois halteres fixos com os braços estendidos ao lado do corpo.\r\nDê um passo para frente e flexione o joelho até que a coxa da perna que avançou esteja paralela com o chão.\r\n\r\n', 'http://localhost/FitSan/uploads/exercicios/afundo.png', NULL),
(19, 21, 'Panturrilha em Pé', 'Para executar o Panturrilha em pé:\r\nFique em pé com os dedos dos pés sobre a plataforma e os ombros por baixo das almofadas; abaixe os calcanhares o máximo possível, para obtenção de um alongamento completo.\r\nLevante o peso elevando os calcanhares até onde for possível, mantendo as pernas estendidas.', NULL, NULL),
(20, 21, 'Panturrilha Sentado', 'Coloque as bolas dos pés na plataforma, posicione as almofadas transversalmente à parte inferior das coxas e abaixe os calcanhares o máximo possível.\r\nLevante o peso elevando os calcanhares até o ponto mais elevado possível\r\nAbaixe lentamente os calcanhares até a posição inicial.', NULL, NULL),
(21, 21, 'Panturrilha no Leg Press', 'Para executar o Panturrilha no leg press:\r\nColoque as bolas dos pés sobre a borda da plataforma (como em um aparelho de leg press) e abaixe o peso o máximo possível.\r\nEmpurre o peso para cima até onde puder, contraindo os músculos da panturrilha.\r\nAbaixe lentamente o peso até a posição inicial.', NULL, NULL),
(22, 21, 'Elevação na ponta dos pés', 'Coloque os dedos dos pés sobre um bloco, incline-se para a frente e apoie o torso no banco; abaixe os calcanhares o máximo possível.\r\nLevante o peso pela elevação dos calcanhares o máximo possível, mantendo as pernas estendidas.\r\nAbaixe lentamente os calcanhares até a posição inicial.', NULL, NULL),
(23, 22, 'Levantamento Stiff', 'Fique em pé e mantenha o corpo ereto, com os pés diretamente abaixo dos quadris, segurando uma barra com os braços estendidos.\r\nIncline-se para a frente (use a cintura) abaixando o peso, mas mantendo as pernas estendidas.\r\nPare antes que o peso toque o chão e volte a levantá-lo.', NULL, NULL),
(24, 22, 'Flexão de Pernas em Pé', 'Para executar o Flexão de pernas em pé:\r\nColoque um calcanhar por baixo do rolo almofadado e apoie o peso com a outra perna.\r\nLevante o peso dobrando o joelho e elevando o calcanhar na direção da nádega.\r\nAbaixe o peso de volta a posição inicial.', NULL, NULL),
(25, 22, 'Flexão de Pernas Deitado', 'Deite-se de bruços sobre o aparelho e enganche os calcanhares por baixo dos rolos almofadados.\r\nLevante o peso dobrando os joelhos e eleve os calcanhares na direção das nádegas.\r\nAbaixe o peso de volta à posição inicial.', NULL, NULL),
(26, 23, 'Supino inclinado com halter', 'Na posição sentada em um banco inclinado, comece com os halteres fixos no nível do tórax, \r\ncom as palmas das mãos voltadas para a frente.\r\nImpulsione os halteres verticalmente, até que ocorra bloqueio dos cotovelos.', NULL, NULL),
(27, 23, 'Supino inclinado', 'Na posição sentada em um banco inclinado, faça uma pegada na barra com as palmas das \r\nmãos voltadas para cima e com afastamento na mesma distância dos ombros.\r\nAbaixe lentamente o peso, até que a barra toque a parte superior do tórax.\r\nEmpurre a barra diretamente para cima, até que os cotovelos fiquem estendidos.\r\n', NULL, NULL),
(28, 23, 'Crucifixo inclinado', 'Sentado em um banco inclinado, comece com os halteres diretamente acima do tórax, com as palmas das mãos voltadas para dentro.\r\nAbaixe os halteres para fora, dobrando ligeiramente os cotovelos enquanto os pesos descem até o nível do tórax.\r\nLevante os halteres de volta, unindo-os na parte superior do exercício.', NULL, NULL),
(29, 23, 'Crucifixo com cabo', 'Em cada mão, segure o pegador preso a polias baixas, fique em pé, em posição ereta.\r\nLevante as mãos em um arco para frente até que os pegadores se encontrem na altura da cabeça.', NULL, NULL),
(31, 24, 'Supino reto com halter', 'Deitado em um banco horizontal, comece com os halteres no nível do tórax, palmas das mãos voltadas para a frente.\r\nImpulsione verticalmente os halteres, até que ocorra a extensão total dos cotovelos.', NULL, NULL),
(32, 24, 'Supino reto com barra', 'Na posição deitada em um banco plano, faça uma pegada na barra com o dorso das mãos voltado para cima e o afastamento entre elas igual à distância entre os ombros.\r\nAbaixe lentamente o peso até tocar a parte média do tórax.\r\nEmpurre a barra diretamente para cima, até que ocorra bloqueio dos cotovelos.', NULL, NULL),
(33, 24, 'Crucifixo reto', 'Deitado em um banco horizontal, comece com os halteres diretamente acima do tórax médio, com as palmas das mãos voltadas para dentro.\r\nAbaixe os halteres com um amplo movimento de abertura (para fora), dobrando ligeiramente os cotovelos durante a descida dos pesos até o nível do tórax.\r\nLevante os halteres em um movimento simultâneo, fazendo arco ascendente, em retorno à posição vertical.', NULL, NULL),
(34, 24, 'Voador', 'Segure os pegadores verticais, com os cotovelos ligeiramente dobrados.\r\nTracione simultaneamente os pegadores até que se toquem à frente de seu tórax.', NULL, NULL),
(35, 25, 'Supino declinado', 'Deite-se em um banco declinado e faça uma pegada na barra com o dorso das mãos voltado para cima e com afastamento igual à distância entre os ombros.\r\nAbaixe lentamente o peso até tocar a parte inferior do tórax.\r\nEmpurre a barra diretamente para cima, até que ocorra extensão total dos cotovelos.', NULL, NULL),
(36, 25, 'Paralela', 'Agarre as barras paralelas, sustentando o corpo com os cotovelos estendidos e bloqueados.\r\nDobre os cotovelos, baixando o torso até que os braços fiquem paralelos ao chão.\r\nEmpurre o corpo de volta a posição inicial, isto é, até que seus cotovelos fiquem novamente estendidos.\r\n', NULL, NULL),
(37, 25, 'Crossover', 'Na posição em pé, segure os pegadores presos às polias altas de um aparelho de cabos.\r\nTracione simultaneamente para baixo os pegadores, até que as mãos se toquem a frente da cintura; mantenha os cotovelos ligeiramente dobrados.\r\nLentamente, retorne à posição inicial com as mãos no nível dos ombros.\r\n', NULL, NULL),
(38, 25, 'Crucifixo declinado', 'Deitado em um banco declinado, comece com os halteres diretamente acima de seu tórax, com as palmas das mãos voltadas para dentro.\r\nAbaixe os halteres com um movimento de abertura (para fora), dobrando ligeiramente os cotovelos durante a descida dos pesos até o nível do tórax.\r\nLeva simultaneamente os halteres de volta à posição inicial, até se tocarem.', NULL, NULL),
(39, 26, 'Abdominal', 'Coloque os pés embaixo da almofada e sente no banco declinado com o torso ereto.\r\nAbaixe o torso para trás até que fique praticamente paralelo ao chão.\r\nRetorna a posição vertical, dobrando na cintura.', '', NULL),
(40, 26, 'Abdominal grupado', 'Deite-se de costas no chão, com os quadris dobrados a 90 graus e as mãos atrás da cabeça.\r\nEleve os ombros do chão, comprimindo o peito para frente e mantendo a região lombar em contato com o chão.\r\nAbaixe os ombros de volta à posição inicial.\r\n', NULL, NULL),
(41, 26, 'Abdominal grupado com corda', 'Ajoelhe no chão embaixo de uma polia alta e segure a corda com as duas mãos, atrás da cabeça.\r\nPuxe o peso para baixo, encurvando o torso e inclinando a cintura.\r\nRetorne a posição inicial.', NULL, NULL),
(42, 26, 'Abdominal grupado com aparelho', 'Para realizar o Abdominal grupado com aparelho:\r\nSente-se no assento, segure os pegadores e coloque os pés sob os rolos de tornozelo.\r\nFaça o abdominal inclinando o torso na direção dos joelhos.\r\nRetorne a posição vertical.', NULL, NULL),
(43, 27, 'Pullover', 'Deite-se com a parte superior das costas repousando transversalmente em um banco horizontal; segure um halter fixo diretamente acima de seu tórax.\r\nMovimente o halter para baixo e para trás, até atingir o nível do banco, inspirando profundamente e alongando o gradil costal.', NULL, NULL),
(44, 27, 'Inclinação Lateral com halter', 'Fique em pé, segurando um halter na mão esquerda; coloque a mão direita atrás da cabeça.\r\nDobre o torso para o lado esquerdo, abaixando o halter na direção do joelho.\r\nFaça com que o torso fique novamente ereto, contraindo os músculos oblíquos direitos.', NULL, NULL),
(45, 27, 'Abdominal grupado oblíquo', 'Deite-se sobre o lado esquerdo, joelhos dobrados e juntos, mão direita atrás da cabeça.\r\nLevante lentamente o torso, contraindo os oblíquos do lado direito.\r\nAbaixe o torso até a posição inicial.', NULL, NULL),
(46, 27, 'Abdominal grupado oblíquo com cabo ', 'Segure um pegador preso à polia alta de um aparelho de cabo.\r\nFaça o abdominal para baixo, direcionando o cotovelo para o joelho oposto.\r\nRetorne lentamente à posição inicial.', NULL, NULL),
(47, 27, 'Abdominal com giro', 'Para fazer o abdominal com giro, sente-se no banco inclinado, enganche os pés por baixo da almofada, incline-se para trás e posicione as mãos atrás da cabeça.\r\nAo fazer o abdominal, torça seu torso, direcionando o cotovelo direito ao joelho esquerdo.\r\nAbaixe de volta para a posição inicial\r\nDurante a próxima repetição, direcione o cotovelo esquerdo para o joelho direito.', NULL, NULL),
(48, 28, 'Elevação de pernas corpo inclinado', 'Deite-se de costas em um banco abdominal inclinado, com as pernas para baixo.\r\nLevante as pernas (nos quadris) e impulsione as coxas na direção do peito, mantendo os joelhos ligeiramente dobrados.\r\nAbaixe lentamente as pernas de volta à posição inicial.', NULL, NULL),
(49, 28, 'Elevação de pernas na barra', 'Pendure-se com as mãos em uma barra, ou coloque os cotovelos em um par de AB Slings (protetores que se prendem à barra para sustentar o peso do corpo); as pernas ficam livremente pendentes.\r\nLevante simultaneamente os joelhos, ligeiramente dobrados, na direção do peito.\r\nAbaixe lentamente as pernas de volta à posição inicial, sem balançar.\r\n', NULL, NULL),
(50, 28, 'Elevação de joelhos', 'Sente-se na extremidade de um banco horizontal, com as pernas pendendo e os joelhos ligeiramente dobrados, e agarre o banco atrás de você.\r\nLevante os joelhos na direção do peito, mantendo as pernas juntas.\r\nAbaixe as pernas, até que os calcanhares praticamente toquem o chão.', NULL, NULL),
(51, 28, 'Abdominal grupado invertido', 'Para executar o Abdominal grupado invertido, deite-se em um banco horizontal, posicione os pés de modo a fazer 90 graus com os joelhos e quadris e agarre o banco atrás da cabeça para apoio.\r\nLevante a pelve (afastando-a do banco) até que os pés apontem para o teto.\r\nAbaixe as pernas de volta para posição inicial.', NULL, NULL),
(52, 8, 'Rosca martelo', 'Segure um halter fixo em cada mão com as palmas voltadas para dentro (polegares apontando para frente).\r\nLevante um halter de cada vez até o ombro, mantendo as palmas das mãos voltadas para dentro.\r\nAbaixe o halter de volta à posição de braço estendido e repita com o outro braço.\r\n', NULL, NULL),
(53, 8, 'Rosca invertida', 'Segure a barra do halter com os braços estendidos; use uma pegada com o dorso das mãos voltados para cima e com afastamento igual à distância entre os ombros.\r\nEleve a barra até o nível dos ombros, rosqueando os punhos para cima e para trás enquanto flexiona os cotovelos.\r\nAbaixe a barra até a posição de braços estendidos, deixando que os punhos “caiam”.', NULL, NULL),
(54, 8, 'Rosca punho', 'Sentado na extremidade do banco, faça a pegada na barra com o dorso das mãos voltado para baixo, mãos afastadas na distância entre os ombros e repouse a parte dorsal dos antebraços nas coxas.\r\nAbaixe a barra dobrando os punhos para baixo, na direção do chão.\r\nFaça a rosca (peso para cima) utilizando o movimento dos punhos.\r\n', NULL, NULL),
(55, 8, 'Rosca punho invertida', 'Pegue a barra usando pegada com o dorso das mãos voltado para cima e repouse os antebraços no alto das coxas ou na borda do banco.\r\nAbaixe a barra dobrando os punhos na direção do chão.\r\nLevante o peso utilizando o movimento dos punhos.', NULL, NULL),
(56, 6, 'Rosca Scott', 'Sente-se com os braços repousando no banco de Scott e faça a pegada na barra com o dorso das mãos voltado para baixo e na mesma distancia dos ombros; braços retos, voltados para fora.\r\nFlexionando os cotovelos, movimente a barra na direção dos ombros.\r\nAbaixe o peso de volta à posição com os braços estendidos.', NULL, NULL),
(57, 6, 'Rosca no aparelho', 'Segure a barra usando uma pegada com o dorso das mãos voltado para baixo e na largura dos ombros, com os cotovelos repousando na almofada e braços retos, voltados para fora.\r\nTracione a barra na direção dos ombros, flexionando os cotovelos\r\nRetorne a barra à posição de braços estendidos', NULL, NULL),
(58, 6, 'Rosca direta com halter', 'Segure um par de halteres à distancia do braços estendido, um de cada lado do corpo, com os polegares apontando para frente.\r\nMovimentando um braço de cada vez, movimente o halter para cima, na direção do ombro, girando a mão de modo que a palma fique voltada para cima.\r\nAbaixe o halter e repita com o outro braço.', NULL, NULL),
(59, 6, 'Rosca direta com barra', 'Segure a barra com os braços estendidos; pegada com afastamento igual à distancia entre os ombros e com o dorso das mãos voltado para baixo.\r\nLeve a barra até o nível dos ombros; para tanto, flexione os cotovelos.\r\nAbaixe a barra de volta à posição inicial, com os braços na posição estendida.', NULL, NULL),
(60, 6, 'Rosca concentrada', 'Posição sentada na extremidade do banco. Segure o halter fixo com o braço estendido; apoie o braço contra a parte interna da coxa.\r\nFaça o exercício de rosca com halter na direção do ombro, flexionando o cotovelo.\r\nAbaixe o halter de volta a posição inicial.\r\n', NULL, NULL),
(61, 6, 'Rosca com cabo', 'Segure a barra curta presa a uma polia baixa, utilizando uma pegada com o dorso das mãos voltado para baixo e com os braços estendidos.\r\nLevante a barra na direção dos ombros, flexionando os cotovelos.\r\nAbaixe o peso de volta à posição inicial, braços na posição estendida.', NULL, NULL),
(63, 7, 'Tríceps puxador', 'Faça a pegada com o dorso das mãos voltado para cima e na largura dos ombros em uma barra curta presa a uma polia alta.\r\nComece com a barra no nível do peito, cotovelos dobrados um pouco mais do que 90 graus.\r\nMantendo os braços estendidos, tracione a barra para baixo até que os cotovelos fiquem bloqueados. \r\n', NULL, NULL),
(64, 7, 'Tríceps francês', 'Sente-se com o torso ereto, segurando uma barra nas duas mãos com os braços estendidos acima da cabeça; use uma pegada fechada com o dorso das mãos voltado para cima.\r\nFlexione os cotovelos e abaixe a barra por trás da cabeça.\r\nImpulsione a barra para cima até que ocorra extensão total dos cotovelos.\r\n', NULL, NULL),
(65, 7, 'Tríceps testa', 'Deitado em um banco horizontal, segure uma barra com os braços estendidos acima de seu peito; use pegada fechada, com o dorso das mãos voltado para cima, e com as mãos afastadas em aproximadamente 15 cm.\r\nFlexione os cotovelos e abaixe a barra até tocar a testa.\r\nImpulsione a barra para cima, até que ocorra extensão total dos cotovelos.', NULL, NULL),
(66, 7, 'Tríceps coice', 'Pegue o halter com uma mão, encurve-se para frente (use a cintura), e sustente o torso pousando a mão livre em um banco, ou no joelho.\r\nComece com o braço paralelo ao chão e com o cotovelo dobrado em 90 graus.\r\nMovimente para cima o halter, estendendo o braço até que ocorra total extensão do cotovelo. \r\n', NULL, NULL),
(67, 7, 'Tríceps supinado', 'Para executar o Tríceps Supinado:\r\nUse pegada fechada (cerca de 15 cm) na barra, com o dorso das mãos voltado para cima.\r\nAbaixe o peso lentamente, até tocar na parte media do peito.', NULL, NULL),
(68, 29, 'Levantamento frontal com cabo ', 'Com uma das mãos, segure o pegador preso a uma polia baixa, utilizando uma pegada pronada (palma das mãos para baixo).\r\nVirado de costas para a pilha de pesos, levante o cabo em um arco ascendente até o nível do ombro, mantendo o cotovelo rígido.\r\nAbaixe o cabo de volta até o nível da cintura.', 'http://localhost/FitSan/uploads/exercicios/frontl.png', NULL),
(69, 29, 'Levantamento frontal com barra', 'Utilizando uma pegada com o dorso das mãos voltado para cima e na largura dos ombros, segure um halter de barra á frente das coxas com os braços estendidos.\r\nLevante o halter para a frente e para cima até o nível dos olhos, mantendo os cotovelos rígidos.\r\nAbaixe o halter de volta às coxas.', 'http://localhost/FitSan/uploads/exercicios/lev.png', NULL),
(70, 29, 'Elevação frontal com halter', 'Sentado com as costas eretas na extremidade de um banco de exercício, segure um par de halteres fixos aos lados do corpo com os braços estendidos; os polegares devem estar apontando para a frente.\r\nLevante um haltere para a frente até o nível do ombro, mantendo o cotovelo rígido.\r\nAbaixe o peso de volta para a posição inicial e repita com o outro halter.', 'http://localhost/FitSan/uploads/exercicios/front.png', NULL),
(71, 29, 'Desenvolvimento com barra', 'Sentado num banco, faça a pegada na barra com afastamento das mãos igual à largura dos ombros; palmas das mãos voltadas para frente.\r\nAbaixe lentamente o peso (à frente), até que toque a parte superior do tórax.\r\nImpulsione verticalmente para cima até que ocorra bloqueio dos cotovelos. \r\n', 'http://localhost/FitSan/uploads/exercicios/senvolvibarra.png', NULL),
(72, 29, 'Desenvolvimento Harnold', 'Sentado em um banco, comece com os halteres fixos no nível do ombro, palmas das mãos voltadas para frente.\r\nImpulsione verticalmente para cima os halteres, até que ocorra bloqueio dos cotovelos.\r\n\r\n', 'http://localhost/FitSan/uploads/exercicios/ombro.png', NULL),
(73, 30, 'Remada Alta', 'Segure o halter comi os braços estendidos; use uma pegada com o dorso das mãos voltado para cima, braços afastados na largura dos ombros.\r\nTracione a barra do haltere verticalmente para cima, levantando os cotovelos até a altura do ombro.', 'http://localhost/FitSan/uploads/exercicios/remalt.png', NULL),
(74, 30, 'Elevação lateral Halter', 'Na posição em pé ereta, segure os halters com os braços estendidos.\r\nLevante os braços para fora e para os lados do corpo, até que os halteres atinjam o nível dos ombros.\r\nAbaixe os halteres de volta para os quadris.', 'http://localhost/FitSan/uploads/exercicios/elehalt.png', NULL),
(75, 30, 'Elevação lateral com cabo', 'Com uma das mãos, agarre o pegador preso a uma polia baixa.\r\nLevante a mão para fora, fazendo um arco amplo, até o nível do ombro, mantendo o cotovelo rígido.\r\nAbaixe o cabo de volta no nível da cintura', 'http://localhost/FitSan/uploads/exercicios/cavb.png', NULL),
(76, 30, 'Elevação lateral no aparelho', 'Para executar a elevação lateral aparelho:\r\nSente-se no aparelho com os cotovelos contra as almofadas protetoras e agarre os pegadores.\r\nLevante os cotovelos até o nível do ombro, braços paralelos ao chão.\r\nAbaixe os cotovelos de volta aos lados do corpo.', 'http://localhost/FitSan/uploads/exercicios/apah.png', NULL),
(77, 31, 'Elevação lateral com halter inclinado', 'Segurando dois halteres com os braços estendidos, incline o corpo para a frente usando a cintura, mantendo as costas retas e a cabeça levantada.\r\nCom as palmas das mãos voltadas para dentro, levante os halteres para cima até o nível das orelhas, mantendo os cotovelos ligeiramente dobrados.\r\nAbaixe os halteres de volta à posição inicial.', 'http://localhost/FitSan/uploads/exercicios/hatkfix.png', NULL),
(78, 31, 'Elevação lateral com cabo  -  inclinado', 'Com o pegador esquerdo na mão direita, e o direito na mão esquerda, fique em pé no meio, e em seguida, incline o corpo para a frente usando a cintura, com as costas retas e paralelas ao chão.\r\nLevante as mãos para cima em um arco até o nível dos ombros, de tal modelo que os cabos se cruzem.', NULL, NULL),
(79, 31, 'Crossover invertido', 'Utilizando uma pegada com os polegares apontando para cima, segure os pegadores presos a duas polias altas (pegador esquerdo na mão direita, pegador direito na mão esquerda), fique de pé em posição central, com as polias à sua frente. (Atenção: durante o cruzamento dos cabos para o tórax, as polias ficam atrás de seu corpo.)\r\nImpulsione as mãos para trás (e ligeiramente para baixo) em um arco, com os braços praticamente paralelos ao chão até que as mãos estejam alinhadas com os ombros (formando um T).\r\nRetorne os pegadores de volta à posição inicial, de modo que a mão direita fique diretamente à frente do ombro esquerdo, e a mão esquerda diretamente à frente do ombro direito.', NULL, NULL),
(80, 31, 'Crucifixo invertido no aparelho', 'Para executar o Crucifixo invertido aparelho:\r\nSente-se de frente para o aparelho com o peito contra o encosto do banco e pegue os pegadores com o braço estendido ao nível do ombro.\r\nPuxe os pegadores para trás no arco mais distante possível, mantendo os cotovelos elevados e braços paralelos ao chão.', 'http://localhost/FitSan/uploads/exercicios/ccccc.png', NULL),
(81, 32, 'Rotação interna ', 'Fique de pé, posicionado de lado com relação a uma polia de cabo ajustada à altura da cintura; agarre o pegador com a mão “de dentro” e com o polegar apontando para cima.\r\nCom o cotovelo mantido firmemente contra a cintura, puxe o pegador para dentro, passando à frente do seu corpo e mantendo o antebraço paralelo ao chão.\r\nRetorne lentamente o pegador de volta a posição inicial.', NULL, NULL),
(82, 32, 'Rotação externa ', 'Fique de pé, posicionado de lado com relação a uma polia de cabo ajustada à altura da cintura; agarre o pegador com a mão “de fora” e com o polegar apontando para cima.\r\nCom o cotovelo mantido firmemente contra a cintura, movimente o pegador em um arco para fora, afastando-o do corpo e mantendo o antebraço paralelo ao chão.\r\nRetorne lentamente o pegador à posição inicial, em frente ao umbigo\r\n', NULL, NULL),
(83, 32, 'Elevação lateral apoiado', 'Para executar a Elevação lateral apoiado:\r\nDeite-se de lado sobre um banco com o torso inclinado em 45 graus, apoiado pelo braço que está abaixo do corpo.\r\nUsando uma pegada com o dorso da mão voltado para cima, levante o halter até a altura da cabeça, mantendo o cotovelo bloqueado.', NULL, NULL),
(84, 16, 'Esteira', 'Saber como pisar na esteira é fundamental, pois o movimento começa pelo calcanhar, passando pela sola até atingir os pés. O calcanhar tem a função de amortecer o impacto da atividade aeróbica. Ao pisar corretamente, você garante o desempenho do exercício e protege os músculos que serão movimentados.', NULL, NULL),
(85, 16, 'Bicicleta ergométrica', 'Uma bicicleta ergométrica lhe permite realizar um exercício cardiovascular simulando um passeio de bicicleta.', NULL, NULL),
(86, 16, 'Eliptico', 'Suba no aparelho, virado para o monitor.\r\nComece a pedalar para ativar o aparelho. \r\nComece a pedalar em um ritmo estável. \r\nNão trave os joelhos. \r\nAumente a resistência. \r\nMude a direção dos pedais. \r\nUse os braços do aparelho. \r\nAumente a inclinação e a resistência enquanto treina.', NULL, NULL),
(87, 8, 'Flexão de braço (apoio)', 'O primeiro passo é ficar de joelhos; \r\naí você apoia as mãos logo abaixo do ombro, levemente mais abertas; \r\ncoloca os pés juntos para trás, ficando na ponta dos dedos; \r\ne estica o corpo, deixando as costas retas.\r\nContraindo o abdômen, você desce com o tronco até o peitoral encostar no chão ou ficar próximo dele;\r\ne volta para a posição inicial. ', NULL, NULL),
(88, 7, 'Tríceps no banco', 'Nesse exercício de musculação para o tríceps você vai precisar para colocar um banco atrás das costas.\r\nCom o banco perpendicular ao seu corpo, apoie suas mãos em sua borda com as mãos totalmente estendidos, separados na largura dos ombros.\r\nAs pernas serão estendidas para frente, dobrada na cintura e perpendicular ao seu tronco. \r\nAbaixe lentamente o seu corpo como dobrando os cotovelos até que eles fiquem em um ângulo ligeiramente menor do que 90 graus entre o braço e o antebraço.\r\n', NULL, NULL),
(91, 6, 'mermao', 'mermao', NULL, 14),
(93, 27, 'Flexão lateral com barra', 'Em pé, com o corpo reto, segurar uma barra que deve estar posicionada na parte de trás dos ombros, logo abaixo do pescoço, como na primeira imagem. Os pés devem estar separados em uma distância equivalente à largura dos ombros. \r\n', 'http://localhost/FitSan/uploads/exercicios/15bboaforma.jpg', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_grupomuscucardio`
--

DROP TABLE IF EXISTS `planilha_grupomuscucardio`;
CREATE TABLE IF NOT EXISTS `planilha_grupomuscucardio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha_grupomuscucardio`
--

INSERT INTO `planilha_grupomuscucardio` (`id`, `nome`) VALUES
(6, 'Biceps'),
(7, 'Tríceps'),
(8, 'AnteBraço'),
(16, 'Cárdio'),
(17, 'Costa(Lombar)'),
(18, 'Costa(Dorsal)'),
(19, 'Costa(Trapézio)'),
(20, 'Perna(Quadriceps)'),
(21, 'Perna(Panturrilha)'),
(22, 'Perna(Posterior da Coxa)'),
(23, 'Peitoral Superior '),
(24, 'Peitoral Médio'),
(25, 'Peitoral Inferior'),
(26, 'Superior '),
(27, 'Oblíquo'),
(28, 'Inferior'),
(29, 'Deltoide Superior'),
(30, 'Deltoide Lateral'),
(31, 'Deltoide Posterior'),
(32, 'Manguito Rotador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planilha_tabela`
--

DROP TABLE IF EXISTS `planilha_tabela`;
CREATE TABLE IF NOT EXISTS `planilha_tabela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `musculo_cardio_id` int(11) NOT NULL,
  `exercicio_id` int(11) NOT NULL,
  `series` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `repeticoes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carga` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intervalo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tempo` int(11) DEFAULT NULL,
  `profissional_id` int(11) NOT NULL,
  `planilha_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `planilha_tabela`
--

INSERT INTO `planilha_tabela` (`id`, `grupo`, `musculo_cardio_id`, `exercicio_id`, `series`, `repeticoes`, `carga`, `intervalo`, `tempo`, `profissional_id`, `planilha_id`) VALUES
(10, 'Ciclo #1', 20, 17, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(11, 'Ciclo #1', 8, 87, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(12, 'Ciclo #1', 26, 40, '3X', '20', NULL, 'Sem Intervalo', NULL, 2, 2),
(13, 'Ciclo #1', 7, 65, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(14, 'Ciclo #2', 17, 11, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(15, 'Ciclo #2', 18, 9, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(16, 'Ciclo #2', 22, 25, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(17, 'Ciclo #2', 6, 58, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(18, 'Ciclo #3', 20, 14, '3X', '12 - 15', '45 graus', 'Sem Intervalo', NULL, 2, 2),
(19, 'Ciclo #3', 24, 31, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(20, 'Ciclo #3', 28, 51, '3X', '20', NULL, 'Sem Intervalo', NULL, 2, 2),
(21, 'Ciclo #3', 7, 88, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(22, 'Ciclo #4', 22, 23, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(23, 'Ciclo #4', 18, 6, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(24, 'Ciclo #4', 21, 19, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(25, 'Ciclo #4', 8, 52, '3X', '12 - 15', NULL, 'Sem Intervalo', NULL, 2, 2),
(26, 'grupo 1', 7, 64, '1', '1', '1', '1', NULL, 2, 3),
(27, 'grupo 1', 16, 85, NULL, NULL, NULL, NULL, 1, 2, 3),
(28, 'grupo 1', 30, 75, '1', '1', '1', '1', NULL, 2, 3),
(29, 'Grupo 1', 20, 15, '2', '1', '1', '1', NULL, 14, 4),
(30, 'Grupo 1', 7, 64, '1', '3', '2', '5', NULL, 14, 4),
(31, 'A', 7, 64, '50', '50', '70', '2', 60, 17, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

DROP TABLE IF EXISTS `upload_dica`;
CREATE TABLE IF NOT EXISTS `upload_dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_arq` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `dica_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `upload_dica`
--

INSERT INTO `upload_dica` (`id`, `nome_arq`, `tipo`, `dica_id`) VALUES
(5, 'f8270e3ed74d515e11bd14b0634aaf1fjpg', 'img', 7),
(6, '1639ca5e138e8cfd792b4526978c7f39jpg', 'img', 6),
(7, '443f060686448ffcfa472b42d805d848jpg', 'img', 8),
(8, '0a96e048f66f5fa6cd6d33817c8e8b97jpg', 'img', 9),
(9, '0842e2bb460d8a499c2991091614cae6jpg', 'img', 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
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
  `status` enum('ativado','desativado','excluido') COLLATE utf8_unicode_ci DEFAULT 'ativado',
  `codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `datahora`, `nome`, `sobrenome`, `datanasc`, `sexo`, `foto`, `senha`, `email`, `tipo_id`, `status`, `codigo`) VALUES
(1, '2018-10-02 02:05:07', 'Administrador', 'Geral', NULL, NULL, NULL, '$2y$10$v2UXi34ZLW0BCwunjyc6TORT9XAr2wM303D5at6t/405Z3QhpNI9e', 'admin@admin', NULL, 'ativado', NULL),
(2, '2018-10-02 02:07:01', 'Karen', 'Guzzatti Konig', '1988-08-14', 'feminino', 'http://localhost/FitSan/uploads/img_5113.jpg', '$2y$10$R/CXtAoYykcwHSO4poq3/uIK7P0e/nCtTHixz6aKVN7q/P5j1nkWi', 'karen.gk@aluno.ifsc.edu.br', 2, 'ativado', '5bb777e262d8b'),
(3, '2018-10-02 02:09:43', 'Luana ', 'Gabriely Spricigo ', NULL, 'feminino', 'http://localhost/FitSan/uploads/image-1.jpg', '$2y$10$D2XMip1qrwDv8bc8YhriTeZQS1PbrNA4ZUDGoq4V0eKj8hqOtP6XK', 'luana@luana', 2, 'ativado', NULL),
(4, '2018-10-02 02:10:31', 'Gabriel', 'Henrique Pessanha  ', NULL, NULL, NULL, '$2y$10$o5JrL22SL9Fs/c35rmJlqOYBK7agg5L0GI0ihfQh4QniNAep.HNny', 'gabriel@gabriel', 2, 'ativado', NULL),
(5, '2018-10-02 02:10:58', 'Sandro ', 'Matias Cunha ', NULL, NULL, NULL, '$2y$10$HTtTkFOIK7g/dfOO6oBZ0.RPAFlxp85UVY7cvB9FIT3YZaQd6X3Ey', 'sandro@sandro', 1, 'ativado', NULL),
(6, '2018-10-02 02:11:21', 'Diego', 'Pereira ', '1986-08-06', 'masculino', 'http://localhost/FitSan/uploads/image.jpeg', '$2y$10$i29vOQLqCrFdjsAo5NhhS.PgKTLhrKR64ThtUQGvf0yHuavxGmVkG', 'diego@diego', 1, 'desativado', NULL),
(7, '2018-10-02 02:11:47', 'Neide', 'Guzzatti Konig ', NULL, NULL, NULL, '$2y$10$ifxnyqyle5wztgKX2tikCexQx22VbPqmG2YFURBUfa3cVhjMBls..', 'neide@neide', 1, 'ativado', NULL),
(8, '2018-10-02 02:12:17', 'Nicoly', 'Pereira Ponciano ', NULL, NULL, NULL, '$2y$10$Y3ORaqNLGpyaA4B1Se3BZu0Z226W18/S5SdGEm4YJG7Y9Iv8LMi6u', 'ni@ni', 1, 'ativado', NULL),
(9, '2018-10-02 02:12:43', 'Nathaly', 'Pereira Ponciano ', '2004-06-22', 'feminino', 'http://localhost/FitSan/uploads/images.jpeg', '$2y$10$fyFDUU6to3i5iMemsyEXV.30C.QseDiRKwNH5z6Q8S6qKoO1hyr56', 'tata@tata', 1, 'ativado', NULL),
(10, '2018-10-02 02:13:05', 'Adryene', 'Pereira Ponciano ', '2008-05-16', 'feminino', 'http://localhost/FitSan/uploads/image_1_.jpeg', '$2y$10$ayWs3oAexRTDvmpYJ.AdyuTWRbv.Y5QHskbwNXjb6rMMhDOj22z2C', 'dy@dy', 1, 'ativado', NULL),
(11, '2018-10-02 02:13:25', 'Adryan', 'Pereira Ponciano ', NULL, NULL, NULL, '$2y$10$u6ThhEyMoPiTV2m0g0mGcObq2hZ9y2OuWA/YGv.optidG1XedDf46', 'ady@ady', 1, 'ativado', NULL),
(12, '2018-10-02 02:14:42', 'Gerson', 'Konig ', NULL, NULL, NULL, '$2y$10$zhLkyra0AmyXcWYUSjNgmOggJ0lVgMOnIemsx2o.wzoNnV0YNCr3S', 'gerson@gerson', 1, 'ativado', NULL),
(13, '2018-10-02 02:15:12', 'Angelina', 'Guzzatti ', NULL, NULL, NULL, '$2y$10$qRxoYvURV75ckP7MpoH8EOcAY1N58bPPk8k67ajA7Rm7pEdQecvf6', 'angelina@angelina', 1, 'ativado', NULL),
(14, '2018-10-02 02:15:45', 'Charles', 'Konig ', '1919-01-22', 'masculino', 'http://localhost/FitSan/uploads/image.jpg', '$2y$10$1nKoC.5VYFm5dO6MGLR7PurkIriasL1mczbhcBeGHhR/9wj6dH2FS', 'charles@charles', 2, 'ativado', NULL),
(15, '2018-10-02 02:17:50', 'Isadora', 'Cachoeira ', NULL, NULL, NULL, '$2y$10$4nYTOxaMpzj9/PteNbXVW.XLnwPeKIPwgeitKpUl5eb2tm4tw8XvC', 'isa@isa', 1, 'ativado', NULL),
(16, '2018-10-18 14:53:35', 'Lua', 'Lua ', NULL, NULL, NULL, '$2y$10$Z2mKOeDceV4cDiVMjBXH.Oa2oD3zgld9XPbL.Bmy8W/MA9351JgHu', 'lua@g', 1, 'ativado', NULL),
(17, '2018-10-18 14:57:19', 'Profissional1', 'Pro ', NULL, NULL, NULL, '$2y$10$iJBrtHLRqRhs8d5Ai1VJiOe0uq.nU9zgDc3vTcE4PzIXRJsR2stT2', 'pro@1', 2, 'ativado', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vinculo`
--

DROP TABLE IF EXISTS `vinculo`;
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
(6, 2, 'profissional', 'aprovado'),
(6, 4, 'aluno', 'espera'),
(6, 14, 'profissional', 'espera'),
(7, 2, 'profissional', 'espera'),
(8, 14, 'profissional', 'aprovado'),
(9, 3, 'profissional', 'aprovado'),
(9, 14, 'profissional', 'aprovado'),
(10, 2, 'profissional', 'aprovado'),
(10, 3, 'profissional', 'aprovado'),
(10, 14, 'profissional', 'aprovado'),
(11, 3, 'profissional', 'aprovado'),
(11, 14, 'profissional', 'aprovado'),
(12, 2, 'profissional', 'espera'),
(13, 2, 'aluno', 'aprovado');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
