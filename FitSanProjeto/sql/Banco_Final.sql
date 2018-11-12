create table `tipo_usuario`(
 `id` int primary key auto_increment,
`tipo` varchar(100) not null
);

create table `usuario`(
`id` int primary key auto_increment,
`datahora` datetime not null default now(),
`nome` varchar(255) not null,
`sobrenome` varchar(255) not null,
`datanasc` date,
`sexo` enum('masculino', 'feminino'),
`foto` varchar(255),
`senha` varchar(255) not null,
`email` varchar(255) not null unique,
`tipo_id` integer references tipo_usuario(id),
`status` enum('ativado', 'desativado', 'excluido') default 'ativado'
`codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
);

create table `vinculo`(
 `aluno_id` int references `usuario`(`id`),
 `profissional_id` int references `usuario`(`id`),
 `solicitante` enum('aluno', 'profissional') not null,
 `status` enum('espera', 'aprovado','negado') not null,
primary key (`aluno_id`, `profissional_id`)
);


create table `dica`(
`id` int primary key auto_increment,
`texto` TEXT not null,
`profissional_nome` varchar(255),
`profissional_id` int references `usuario`(`id`),
`data_envio` varchar(20)
);

create table `upload_dica`(
 `id` int primary key auto_increment,
`nome_arq` varchar(40) not null,
`tipo` char(3) not null, 
`dica_id` int references `dica`(`id`)
);

CREATE TABLE `notificacao`(
`id` INT primary key AUTO_INCREMENT,
`data` datetime NOT NULL,
`lido` ENUM('N', 'L') NOT NULL,
`status` ENUM('OK', 'ERRO', 'INFO') NOT NULL,
`texto` TEXT NOT NULL,
`profissional_id` int references `usuario`(`id`),
`aluno_id` int references `usuario`(`id`),
`dados` TEXT
);

create table `ativ_extras`(
`id` int primary key auto_increment,
`datahora` datetime not null,
`titulo` varchar(255) not null,
`texto` text not null,
`visualizacao` ENUM('PUBLICO','PRIVADO') not null default 'PRIVADO',
`aluno_id` int references `usuario`(`id`)
);

create table `ativ_extras_exercicios`(
`id` int primary key auto_increment,
`ativ_extras_id` int references `ativ_extra`(`id`),
`exercicio` varchar(255) not null
);

create table `informacoes_adicionais`(
`id` int primary key auto_increment,
`saude` text,
`medico` text,
`alergia` text,
`medicamento` text,
`gruposangue` varchar(3),
`doador` ENUM('SIM', 'NAO'),
`academia_frequentada` text,
`academia_atual` text,
`aluno_id` int references `usuario`(`id`)
);

create table `informacoes_adicionais_contatos`(
`id` int primary key auto_increment,
`tipo` varchar(255),
`nome` varchar(255),
`telefone` varchar(255),
`informacoes_adicionais_id` int references `informacoes_adicionais`(`id`)
);

create table `informacoes_adicionais_medidas`(
`id` int primary key auto_increment,
`altura` decimal(7,2),
`peso` decimal(7,3),
`massa_magra` decimal(7,3),
`gordura_corporal` decimal(7,3),
`informacoes_adicionais_id` int references `informacoes_adicionais`(`id`)
);

create table `informacoes_adicionais_exercicios`(
`id` int primary key auto_increment,
`exercicios` varchar(255),
`informacoes_adicionais_id` int references `informacoes_adicionais`(`id`)
);

create table `planilha`(
`id` int not null primary key auto_increment,
`titulo` varchar(255) not null,
`datahora` datetime not null default now()
);

create table `planilha_tabela`(
`id` int not null primary key auto_increment,
`grupo` varchar(255) not null,
`musculo_cardio_id` int not null references `planilha_grupoMuscuCardio`(`id`),
`exercicio_id` int not null references `planilha_exercicio`(`id`),
`series` varchar(255),
`repeticoes` varchar(255),
`carga` varchar(255),
`intervalo` varchar(255),
`tempo` int,
`profissional_id` int not null references `usuario`(`id`),
`planilha_id` int references `planilha`(`id`)
);

create table `planilha_grupoMuscuCardio`(
`id` int primary key auto_increment,
`nome` varchar(255) not null
);

create table `planilha_exercicio`(
`id` int primary key auto_increment,
`musculo_cardio_id` int references `planilha_grupoMuscuCardio`(`id`),
`nome` varchar(255) not null,
`descricao` text not null,
`foto` varchar(255),
`profissional_id` int references `usuario`(`id`)
);

create table `planilha_aluno`(
`id` int primary key auto_increment,
`aluno_id` int references `usuario`(`id`),
`planilha_id` int references `planilha`(`id`)
);

create table `planilha_aluno_feito` (
`id` int primary key auto_increment,
`planilha_aluno_id` int references `planilha_aluno`(`id`),
`datahora` datetime not null
);

create table `planilha_aluno_exercicio`(
`planilha_feito_id` int references `planilha_aluno_feito`(`id`),
`planilha_tabela_id` int references `planilha_tabela`(`id`),
`exercicio` int references `planilha_exercicio`(`id`),
primary key (`planilha_feito_id`, `planilha_tabela_id`, `exercicio`)
);

CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `desempenho` text COLLATE utf8_unicode_ci,
  `frequencia` text COLLATE utf8_unicode_ci,
  `grupo_cumpriu` text COLLATE utf8_unicode_ci,
  `grupo_duvida` text COLLATE utf8_unicode_ci,
  `grupo_dificuldade` text COLLATE utf8_unicode_ci,
  `caso_sim` text COLLATE utf8_unicode_ci,
  `consideracoes` text COLLATE utf8_unicode_ci,
`musculatura` text COLLATE utf8_unicode_ci,
`lesao` text COLLATE utf8_unicode_ci,
`queimacao` text COLLATE utf8_unicode_ci,
`caimbras` text COLLATE utf8_unicode_ci,
`tontura` text COLLATE utf8_unicode_ci,
`consideracoes_corporal` text COLLATE utf8_unicode_ci,
  `profissional_id` int(11) DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

create table `meta`(
`id` int primary key auto_increment,
`tipo` ENUM ('PERDER', 'GANHAR', 'MANTER') not null,
`data_inicial` date not null,
`data_final` date not null,
`peso_inicial` decimal(6,3) not null,
`peso_final` decimal(6,3) not null,
`status` ENUM ('ativa', 'finalizada') not null default 'ativa',
`usuario_id` int references `usuario`(`id`)
); 

create table `dados_meta`(
`id` int primary key auto_increment,
`data_add` date not null,
`peso_add` decimal(6,3) not null,
`descricao` TEXT,
`meta_id` int references `meta`(`id`)
);

insert into `tipo_usuario` (`tipo`) values ('aluno');
insert into `tipo_usuario` (`tipo`) values ('profissional');

replace into `usuario` (`nome`, `sobrenome`, `senha`, `email`, `tipo_id`) values ('Administrador','Geral','$2y$10$F4o1IGnrLVcWQaibszv.9O18QcUQ0cES8XYr6Hqv0lqiic00dC8vC', 'admin@admin', null);