create database FitSan;

create table usuario(
id int primary key auto_increment,
datahora timestamp not null default now(),
nome varchar(255) not null,
sobrenome varchar(255) not null,
datanasc date,
sexo enum('masculino', 'feminino'),
foto varchar(255),
senha varchar(255) not null,
email varchar(255) not null unique,
tipo_id integer references tipo_usuario(id)
);

ALTER TABLE usuario ADD codigo varchar(255);

create table tipo_usuario(
 id int primary key auto_increment,
tipo varchar(100) not null
);

create table vinculo(
 aluno_id int references usuario(id),
 profissional_id int references usuario(id),
 solicitante enum('aluno', 'profissional') not null,
 status enum('espera', 'aprovado','negado') not null,
primary key (aluno_id, profissional_id)
);

create table dica(
 id int primary key auto_increment,
texto varchar(255) not null,
profissional_nome varchar(255),
profissional_id int references usuario(id),
data_envio varchar(20)
);

create table upload_dica(
 id int primary key auto_increment,
nome_arq varchar(40) not null,
tipo char(3) not null, 
dica_id int references dica(id)
);


CREATE TABLE notificacao(
id INT primary key AUTO_INCREMENT,
data datetime NOT NULL,
lido ENUM('N', 'L') NOT NULL,
status ENUM('OK', 'ERRO', 'INFO') NOT NULL,
texto TEXT NOT NULL,
profissional_id int references usuario(id),
aluno_id int references usuario(id),
dados TEXT
);



DROP TABLE ativ_extras;
DROP TABLE ativ_extras_exercicios;

create table ativ_extras(
id int primary key auto_increment,
datahora timestamp not null,
titulo varchar(255) not null,
texto text not null,
aluno_id int references usuario(id)
);

create table ativ_extras_exercicios(
id int primary key auto_increment,
ativ_extras_id int references ativ_extra(id),
exercicio varchar(255) not null
);

create table informacoes_adicionais(
id int primary key auto_increment,
saude text,
medico text,
alergia text,
medicamento text,
gruposangue varchar(3),
doador ENUM('SIM', 'NAO'),
academia_frequentada text,
academia_atual text,
aluno_id int references usuario(id)
);


create table informacoes_adicionais_contatos(
id int primary key auto_increment,
tipo varchar(255),
nome varchar(255),
telefone varchar(255),
informacoes_adicionais_id int references informacoes_adicionais(id)
);

create table informacoes_adicionais_medidas(
id int primary key auto_increment,
altura decimal(5,2),
peso decimal(5,3),
massa_magra decimal(5,3),
gordura_corporal decimal(5,3),
informacoes_adicionais_id int references informacoes_adicionais(id)
);

create table informacoes_adicionais_exercicios(
id int primary key auto_increment,
exercicios varchar(255),
informacoes_adicionais_id int references informacoes_adicionais(id)
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

ALTER DATABASE FitSan CHARACTER SET utf8 COLLATE utf8_unicode_ci;
SELECT CONCAT('ALTER TABLE ',  table_name, ' CHARACTER SET utf8 COLLATE utf8_unicode_ci;') FROM information_schema.TABLES WHERE table_schema = 'FitSan';

ALTER TABLE dica CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE notificacao CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE tipo_usuario CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE usuario CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE vinculo CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE ativ_extras CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE ativ_extras_exercicios CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE upload_dica CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE informacoes_adicionais CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE informacoes_adicionais_contatos CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE informacoes_adicionais_exercicios CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE informacoes_adicionais_medidas CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--inserir dados no banco.
insert into tipo_usuario (tipo) values ('aluno');
insert into tipo_usuario (tipo) values ('profissional');



--TESTES -----

update usuario set datahora = now();

-- Criando campo na tabela usuario depois do campo id com valor padrao
ALTER TABLE usuario ADD datahora timestamp not null after id;
ALTER TABLE usuario CHANGE datahora datahora timestamp not null default now() after id;

ALTER TABLE usuario ADD datanasc date;
ALTER TABLE usuario ADD sexo enum('masculino', 'feminino');
ALTER TABLE usuario ADD foto varchar(255);

ALTER TABLE usuario DROP COLUMN datanasc;
ALTER TABLE usuario DROP COLUMN sexo;
ALTER TABLE usuario DROP COLUMN foto;

ALTER TABLE usuario CHANGE datanasc datanasc date;
ALTER TABLE usuario CHANGE sexo sexo enum('masculino', 'feminino');
ALTER TABLE usuario CHANGE foto foto varchar(255);

update usuario set datanasc=now(); 

drop table usuario;


ALTER TABLE vinculo DROP COLUMN status;
ALTER TABLE vinculo ADD status enum('espera', 'aprovado','negado') not null;
ALTER TABLE vinculo DROP COLUMN solicitante;
ALTER TABLE vinculo ADD solicitante enum('aluno', 'profissional') not null;




select * from usuario;
select * from vinculo;
select * from tipo_usuario;
select * from notificacao;

TRUNCATE TABLE vinculo;
TRUNCATE TABLE notificacao;




drop table notificacao;
truncate table notificacao;

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