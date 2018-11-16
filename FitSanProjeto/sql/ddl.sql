create database `FitSan`;

create table `usuario`(
`id` int primary key auto_increment,
`datahora` datetime not null,
`nome` varchar(255) not null,
`sobrenome` varchar(255) not null,
`datanasc` date,
`sexo` enum('masculino', 'feminino'),
`foto` varchar(255),
`senha` varchar(255) not null,
`email` varchar(255) not null unique,
`tipo_id` integer references tipo_usuario(id),
`codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`status` enum('ativado', 'desativado', 'excluido') default 'ativado'
);


select * from usuario;
alter table `usuario` add `codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL;

alter table usuario change column status status enum('ativado', 'desativado', 'excluido') default 'ativado';

ALTER TABLE usuario ADD codigo varchar(255);
ALTER TABLE usuario ADD status enum('ativado', 'desativado', 'excluido');

update usuario set status='ativado' where email ='$email';


-- Criando campo na tabela usuario depois do campo id com valor padrao
ALTER TABLE usuario ADD datahora datetime not null after id;
ALTER TABLE usuario CHANGE datahora datahora datetime not null default now() after id;

ALTER TABLE usuario ADD datanasc date;
ALTER TABLE usuario ADD sexo enum('masculino', 'feminino');
ALTER TABLE usuario ADD foto varchar(255);

ALTER TABLE usuario DROP COLUMN datanasc;
ALTER TABLE usuario DROP COLUMN sexo;
ALTER TABLE usuario DROP COLUMN foto;

ALTER TABLE usuario CHANGE datanasc datanasc date;
ALTER TABLE usuario CHANGE sexo sexo enum('masculino', 'feminino');
ALTER TABLE usuario CHANGE foto foto varchar(255);

update usuario set status='ativado'; 
update usuario set datanasc=now(); 
update usuario set datahora=now();

drop table usuario;

select * from usuario;


create table `tipo_usuario`(
 `id` int primary key auto_increment,
`tipo` varchar(100) not null
);

select * from tipo_usuario;

create table `vinculo`(
 `aluno_id` int references `usuario`(`id`),
 `profissional_id` int references `usuario`(`id`),
 `solicitante` enum('aluno', 'profissional') not null,
 `status` enum('espera', 'aprovado','negado') not null,
primary key (`aluno_id`, `profissional_id`)
);

drop table `chat`;

create table `chat`(
 `id` int primary key auto_increment,
 `aluno_id` int references `usuario`(`id`),
 `profissional_id` int references `usuario`(`id`),
 `origem` enum('aluno', 'profissional') not null,
 `status` enum('lido', 'pendente') not null,
 `datahora` datetime not null,
 `mensagem` text not null
);
select * from `chat`;


create table `dica`(
`id` int primary key auto_increment,
`texto` TEXT,
`titulo` varchar(255),
`profissional_nome` varchar(255),
`profissional_id` int references `usuario`(`id`),
`data_envio` varchar(20)
);

alter table dica add column titulo varchar(255) not null
alter table dica change titulo titulo varchar(255) not null after texto

alter table dica change titulo titulo varchar(255) after texto;
alter table dica change texto texto TEXT;
select * from dica;

create table `upload_dica`(
 `id` int primary key auto_increment,
`nome_arq` varchar(255) not null,
`tipo` char(3) not null, 
`dica_id` int references `dica`(`id`)
);

alter table upload_dica change nome_arq nome_arq varchar(255) not null;
select * from dica;

truncate table dica

select * from notificacao;

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

SELECT * FROM notificacao;
drop table notificacao;
truncate table notificacao;

DROP TABLE ativ_extras;
DROP TABLE ativ_extras_exercicios;

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

alter table informacoes_adicionais_medidas
change column altura altura decimal(7,2),
change column peso peso decimal(7,3),
change column massa_magra massa_magra decimal(7,3),
change column gordura_corporal gordura_corporal decimal(7,3);

create table `informacoes_adicionais_exercicios`(
`id` int primary key auto_increment,
`exercicios` varchar(255),
`informacoes_adicionais_id` int references `informacoes_adicionais`(`id`)
);

select * from informacoes_adicionais;
select * from informacoes_adicionais_contatos;
select * from informacoes_adicionais_exercicios;
select * from informacoes_adicionais_medidas;

TRUNCATE TABLE informacoes_adicionais;
TRUNCATE TABLE informacoes_adicionais_contatos;
TRUNCATE TABLE informacoes_adicionais_exercicios;
TRUNCATE TABLE informacoes_adicionais_medidas;

select * from ativ_extras;
select * from ativ_extras_exercicios;

TRUNCATE TABLE ativ_extras;
TRUNCATE TABLE ativ_extras_exercicios;

----------------------------------------------------------------

--Planilha -----

create table `planilha`(
`id` int not null primary key auto_increment,
`titulo` varchar(255) not null,
`datahora` datetime not null
);

ALTER TABLE planilha ADD datahora datetime not null default now() after titulo;

select * from planilha order by datahora desc, titulo;


--Planilha Tabela -----

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

rename table planilha to planilha_tabela;

drop table planilha_tabela;

ALTER TABLE planilha_tabela ADD series varchar(255) after exercicio_id;
ALTER TABLE planilha_tabela ADD planilha_id int references planilha(id) after profissional_id;

select * from planilha_tabela;
select * from planilha_tabela order by grupo, id;

---Grupos Musculares/Cárdio---

create table `planilha_grupoMuscuCardio`(
`id` int primary key auto_increment,
`nome` varchar(255) not null
);

select * from planilha_grupoMuscuCardio;

---Grupos Exercicios---

create table `planilha_exercicio`(
`id` int primary key auto_increment,
`musculo_cardio_id` int references `planilha_grupoMuscuCardio`(`id`),
`nome` varchar(255) not null,
`descricao` text not null,
`foto` varchar(255),
`profissional_id` int references `usuario`(`id`)
);

ALTER TABLE planilha_exercicio ADD profissional_id int references usuario(id);
UPDATE planilha_exercicio SET profissional_id = 2 WHERE profissional_id is null;


ALTER TABLE planilha_exercicio ADD musculo_cardio_id int references planilha_grupoMuscuCardio(id) after id;
select * from planilha_exercicio;

-------Aluno Planilha-----
create table `planilha_aluno`(
`id` int primary key auto_increment,
`aluno_id` int references `usuario`(`id`),
`planilha_id` int references `planilha`(`id`)
);

create table `planilha_aluno_feito`(
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

select * from planilha_aluno;
select * from planilha_aluno_feito;
select * from planilha_aluno_exercicio;

truncate table planilha_tabela;
truncate table planilha_aluno_feito;
truncate table planilha_aluno_exercicio;
truncate table planilha_aluno;
truncate table planilha;
update planilha_tabela set planilha_id = null;




select
    p.*,
    g.nome grupomusc,
    e.nome exercicio,
    e.descricao exercicio_desc,
    e.foto exercicio_foto
from
    planilha_aluno a join
    planilha_tabela p on p.planilha_id = a.planilha_id join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = p.exercicio_id and e.musculo_cardio_id = g.id
where
    a.aluno_id = 9 and
    p.profissional_id in (2,7)
order by
    p.grupo
;

select
    a.planilha_id,
    p.profissional_id,
    p.musculo_cardio_id,
    p.exercicio_id,
    p.grupo,
    p.series,
    p.repeticoes,
    p.carga,
    p.intervalo,
    p.tempo,
    g.nome grupomusc,
    e.nome exercicio,
    e.descricao exercicio_desc,
    e.foto exercicio_foto,
    f.datahora,
    z.planilha_feito_id,
    u.nome as profissional_nome,
    u.sobrenome as profissional_sobrenome,
    u.email as profissional_email
from
    planilha_aluno a join
    planilha_aluno_feito f on f.planilha_aluno_id = a.id join
    planilha_aluno_exercicio z on z.planilha_feito_id = f.id join
    planilha_tabela p on p.planilha_id = a.planilha_id and p.id = z.planilha_tabela_id join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = z.exercicio join
    usuario u on u.id = p.profissional_id
where
    a.aluno_id = 9
order by
    f.datahora desc,
    p.grupo,
    exercicio
limit
    10
offset
    0
;

-------Fim Planilha-----


CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('lido', 'nao_lido') default 'nao_lido',
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

alter table `avaliacao` add column `status` enum('lido', 'nao_lido') default 'nao_lido';

select * from `usuario`;

select * from `avaliacao` join vinculo on usuario.id=vinculo.aluno_id where profissional_id= 19;

select * from `avaliacao` ;



update usuario set status='ativado' where id = 16



-------META------
create table `meta`(
`id` int primary key auto_increment,
`tipo` ENUM ('PERDER', 'GANHAR', 'MANTER') not null,
`data_inicial` date not null,
`data_final` date not null,
`peso_inicial` decimal(6,3) not null,
`peso_final` decimal(6,3) not null,
`status` ENUM ('ativa', 'finalizada') not null default 'ativa',
`visualizacao` ENUM('PUBLICO','PRIVADO') not null default 'PRIVADO',
`usuario_id` int references `usuario`(`id`)
); 

alter table meta add column visualizacao enum('PUBLICO', 'PRIVADO') not null default 'PRIVADO' after status

create table `dados_meta`(
`id` int primary key auto_increment,
`data_add` date not null,
`peso_add` decimal(6,3) not null,
`descricao` TEXT,
`meta_id` int references `meta`(`id`)
);






--inserir dados no banco.
insert into `tipo_usuario` (`tipo`) values ('aluno');
insert into `tipo_usuario` (`tipo`) values ('profissional');



ALTER TABLE vinculo DROP COLUMN status;
ALTER TABLE vinculo ADD status enum('espera', 'aprovado','negado') not null;
ALTER TABLE vinculo DROP COLUMN solicitante;
ALTER TABLE vinculo ADD solicitante enum('aluno', 'profissional') not null;




select * from vinculo;
select * from dados_metas;
select * from metas;


TRUNCATE TABLE vinculo;




ALTER TABLE notificacao DROP COLUMN dados;
ALTER TABLE notificacao ADD dados TEXT;
ALTER TABLE notificacao CHANGE dados dados TEXT;


insert into vinculo values ('1', '2');

select * from usuario join vinculo on usuario.id=vinculo.aluno_id where profissional_id=2;

select * from dica;  
drop table dica;

delete from dica where id=10;
-- profissionais que não têm aluno
select s.nome, s.id from usuario u left outer join 
    vinculo on u.id=vinculo.aluno_id right outer join usuario s on s.id=vinculo.profissional_id
   where s.tipo_id=2 and vinculo.aluno_id is null

-- alunos que não têm profissional e que não têm
select a.nome, a.id, vinculo.profissional_id from usuario p left outer join 
    vinculo on p.id=vinculo.profissional_id right outer join usuario a on a.id=vinculo.aluno_id
   where a.tipo_id=1 and p.id=3


select * from usuario join vinculo on usuario.id=vinculo.aluno_id


select * from vinculo where aluno_id = 1
s.id, u.nome as aluno, s.nome as profissional 




insert into usuario values (default, concat(Upper(substr('mathias', 1, 1)), lower(substr('mathias', 2, length('mathias')))), '123', 'm@m', '1')

insert into usuario (id, nome, sobrenome, datanasc, sexo, foto, senha, email, tipo_id) values (default, 'Charles ','Konig ','','','', '$2y$10$DTZydgfgwrk70b4u2.RTtuWE9GF1o1vda1vxDY15Q6Sn6L/tWX5XC', 'charles@charles', '2');

replace into `usuario` (`nome`, `sobrenome`, `senha`, `email`, `tipo_id`) values ('Administrador','Geral','$2y$10$F4o1IGnrLVcWQaibszv.9O18QcUQ0cES8XYr6Hqv0lqiic00dC8vC', 'admin@admin', null);




select * from usuario left join vinculo on usuario.id=vinculo.aluno_id
where aluno_id is null and profissional_id is null and tipo_id=2
  

select * from usuario where tipo_id=2 -- profi


select * from vinculo where profissional_id=3 ---- 2   3


delete from usuario where id=10

select * from usuario where  like '%Diego Pereira%';

SELECT * FROM usuario WHERE nome = '%pereira' and sobrenome = '%pereira';


select senha from usuario where id='1';



select usuario.*, tipo_usuario.tipo from usuario join tipo_usuario on tipo_usuario.id=usuario.tipo_id where email = 'diego@diego';

select id from usuario where email='g@g';

select senha from usuario where id=$_SESSION[id];

update usuario set nome = 'gabriel' , sobrenome = 'Pessanha', email = 'g@g' where id='1';

insert into usuario(codigo) values ('sdbfahsdbfahs'), where email =l@l ;

UPDATE usuario SET codigo='FCHGVKJHKJHVV' WHERE email = 'l@l';

UPDATE usuario SET senha=2345678 WHERE codigo = '5ba93c45d17e8'




INSERT INTO `avaliacao` (`id`, `data`, `desempenho`, `frequencia`, `grupo_cumpriu`, `grupo_duvida`, `grupo_dificuldade`, `caso_sim`, `consideracoes`, `profissional_id`, `aluno_id`) VALUES (1, '2018-10-01 23:52:53', 'bom', 'boa', 'sim', 'não', 'não','sim', 'não', 1, 2 );

select * from `avaliacao`;

select * from `avaliacao` where aluno_id = 19;

select * from `usuario` where id=17;








----------------------------------------------------------------
-- ALTERANDO CHARSET E COLLATION DO BANCO ----------------------
----------------------------------------------------------------
-- INICIO ------------------------------------------------------
----------------------------------------------------------------

-- Gerar instruções para alteração do charset no banco
--     Executar esse primeiro e copiar os resultados
SELECT
        item
FROM
        ((
                SELECT DISTINCT
                        1 ordem,
                        TABLE_SCHEMA,
                        CONCAT( 'ALTER DATABASE `', TABLE_SCHEMA, '` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;' ) item
                FROM
                        information_schema.COLUMNS
        ) UNION (
                SELECT DISTINCT
                        2 ordem,
                        TABLE_SCHEMA,
                        CONCAT( 'ALTER TABLE `', TABLE_SCHEMA, '`.`', TABLE_NAME, '` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;' ) item
                FROM
                        information_schema.COLUMNS
        )) t
WHERE
        /*TABLE_SCHEMA = 'eduimove_site'*/
        TABLE_SCHEMA = DATABASE()
ORDER BY
        ordem,
        item
;

-- Gerar instruções para alteração do charset no banco em versões antigas
--     Executar esse primeiro e copiar os resultados
SELECT
        item
FROM
        ((
                SELECT DISTINCT
                        1 ordem,
                        TABLE_SCHEMA,
                        CONCAT( 'ALTER DATABASE `', TABLE_SCHEMA, '` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;' ) item
                FROM
                        information_schema.COLUMNS
        ) UNION (
                SELECT DISTINCT
                        2 ordem,
                        TABLE_SCHEMA,
                        CONCAT( 'ALTER TABLE `', TABLE_SCHEMA, '`.`', TABLE_NAME, '` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;' ) item
                FROM
                        information_schema.COLUMNS
        )) t
WHERE
        /*TABLE_SCHEMA = 'eduimove_site'*/
        TABLE_SCHEMA = DATABASE()
ORDER BY
        ordem,
        item
;

-- Instruções geradas pela SQL acima
--      Cole aqui os resultados INICIO:
ALTER DATABASE `FitSan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`ativ_extras` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`ativ_extras_exercicios` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`avaliacao` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`contato` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`dados_meta` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`dica` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`informacoes_adicionais` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`informacoes_adicionais_contatos` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`informacoes_adicionais_exercicios` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`informacoes_adicionais_medidas` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`meta` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`notificacao` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha_aluno` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha_aluno_exercicio` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha_aluno_feito` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha_exercicio` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha_grupoMuscuCardio` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`planilha_tabela` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`tipo_usuario` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`upload_dica` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`usuario` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `FitSan`.`vinculo` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--      FIM: Cole aqui os resultados, selecione todos e execute

----------------------------------------------------------------
-- FIM ------------------------------------------------------
----------------------------------------------------------------
-- ALTERANDO CHARSET E COLLATION DO BANCO ----------------------
----------------------------------------------------------------


