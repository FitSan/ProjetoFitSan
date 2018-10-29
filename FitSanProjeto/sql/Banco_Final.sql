-- Quando tiver tudo certo vamos organizar só as tabelas do fitsan aqui!--

-- Criação do Banco

CREATE DATABASE FitSan;

-- Tabela Usuario--



CREATE TABLE usuario(
id INT PRIMARY KEY auto_increment,
datahora datetime NOT NULL DEFAULT now(),
nome VARCHAR(255) NOT NULL,
sobrenome VARCHAR(255) NOT NULL,
datanasc DATE,
sexo ENUM('masculino', 'feminino'),
foto VARCHAR(255),
senha VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE,
tipo_id INTEGER REFERENCES tipo_usuario(id),
status ENUM('ativado', 'desativado', 'excluido') DEFAULT 'ativado'
);

-- Tabela Tipo de Usuarios--


CREATE TABLE tipo_usuario(
 id INT PRIMARY KEY auto_increment,
tipo VARCHAR(100) NOT NULL
);

-- Inserir dados no banco.(Relação ao tipo de usuario)

INSERT INTO tipo_usuario (tipo) VALUES ('aluno');
INSERT INTO tipo_usuario (tipo) VALUES ('profissional');

-- Tabela Vinculos --

CREATE TABLE vinculo(
 aluno_id INT REFERENCES usuario(id),
 profissional_id INT REFERENCES usuario(id),
 solicitante ENUM('aluno', 'profissional') NOT NULL,
 status ENUM('espera', 'aprovado','negado') NOT NULL,
PRIMARY KEY (aluno_id, profissional_id)
);

--Tabela Dicas--

CREATE TABLE dica(
id INT PRIMARY KEY auto_increment,
texto TEXT NOT NULL,
profissional_nome VARCHAR(255),
profissional_id INT REFERENCES usuario(id),
data_envio VARCHAR(20)
);


CREATE TABLE upload_dica(
 id INT PRIMARY KEY auto_increment,
nome_arq VARCHAR(40) NOT NULL,
tipo CHAR(3) NOT NULL, 
dica_id INT REFERENCES dica(id)
);

-- Tabela Notificação--

CREATE TABLE notificacao(
id INT primary key AUTO_INCREMENT,
data DATETIME NOT NULL,
lido ENUM('N', 'L') NOT NULL,
status ENUM('OK', 'ERRO', 'INFO') NOT NULL,
texto TEXT NOT NULL,
profissional_id int references usuario(id),
aluno_id int references usuario(id),
dados TEXT
);

-- Tabela Atividade Extras --

CREATE TABLE ativ_extras(
id INT PRIMARY KEY auto_increment,
datahora datetime NOT NULL,
titulo VARCHAR(255) NOT NULL,
texto TEXT NOT NULL,
visualizacao ENUM('PUBLICO','PRIVADO') NOT NULL DEFAULT 'PRIVADO',
aluno_id INT REFERENCES  usuario(id)
);

CREATE TABLE ativ_extras_exercicios(
id INT PRIMARY KEY auto_increment,
ativ_extras_id INT REFERENCES ativ_extra(id),
exercicio VARCHAR(255) NOT NULL
);

-- Tabela Informações Adicionais--

CREATE TABLE informacoes_adicionais(
id INT PRIMARY KEY auto_increment,
saude TEXT,
medico TEXT,
alergia TEXT,
medicamento TEXT,
gruposangue VARCHAR(3),
doador ENUM('SIM', 'NAO'),
academia_frequentada TEXT,
academia_atual TEXT,
aluno_id INT REFERENCES usuario(id)
);


CREATE TABLE informacoes_adicionais_contatos(
id INT PRIMARY KEY auto_increment,
tipo VARCHAR(255),
nome VARCHAR(255),
telefone VARCHAR(255),
informacoes_adicionais_id INT REFERENCES informacoes_adicionais(id)
);

CREATE TABLE informacoes_adicionais_medidas(
id INT PRIMARY KEY auto_increment,
altura DECIMAL(7,2),
peso DECIMAL(7,3),
massa_magra DECIMAL(7,3),
gordura_corporal DECIMAL(7,3),
informacoes_adicionais_id INT REFERENCES informacoes_adicionais(id)
);


CREATE TABLE informacoes_adicionais_exercicios(
id INT PRIMARY KEY auto_increment,
exercicios VARCHAR(255),
informacoes_adicionais_id INT REFERENCES informacoes_adicionais(id)
);


-- Tabela Profissional Planilha -----

CREATE TABLE planilha(
id INT NOT NULL PRIMARY KEY auto_increment,
titulo VARCHAR(255) NOT NULL,
datahora datetime NOT NULL DEFAULT now()
);


create table planilha_tabela(
id int not null primary key auto_increment,
grupo varchar(255) not null,
musculo_cardio_id int not null references planilha_grupoMuscuCardio(id),
exercicio_id int not null references Planilha_exercicio(id),
series varchar(255),
repeticoes varchar(255),
carga varchar(255),
intervalo varchar(255),
tempo int,
profissional_id int not null references usuario(id),
planilha_id int references planilha(id)
);


create table planilha_grupoMuscuCardio(
id int primary key auto_increment,
nome varchar(255) not null
);


create table planilha_exercicio(
id int primary key auto_increment,
musculo_cardio_id int references planilha_grupoMuscuCardio(id),
nome varchar(255) not null,
descricao text not null,
foto varchar(255),
profissional_id int references usuario(id)
);

------- Tabela Aluno Planilha -----

create table planilha_aluno(
id int primary key auto_increment,
aluno_id int references usuario(id),
planilha_id int references planilha(id)
);


create table planilha_aluno_feito (
id int primary key auto_increment,
planilha_aluno_id int references planilha_aluno(id),
datahora datetime not null
);

create table planilha_aluno_exercicio(
planilha_feito_id int references planilha_aluno_feito(id),
exercicio int references planilha_exercicio (id),
primary key (planilha_feito_id, exercicio)
);


------ Tabela Avaliação -----

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;



------- Tabela META ------

create table meta(
 id int primary key auto_increment,
tipo ENUM ('PERDER', 'GANHAR', 'MANTER') not null,
data_inicial date not null,
data_final date not null,
peso_inicial decimal(6,3) not null,
peso_final decimal(6,3) not null,
status ENUM ('ativa', 'finalizada', 'cancelada') not null default 'ativa',
usuario_id int references usuario(id)
); 

create table dados_meta(
 id int primary key auto_increment,
data_add date not null,
peso_add decimal(6,3) not null,
descricao TEXT,
meta_id int references meta(id)
);


-- Depois de todas as tabelas criadas usar esse codigo --

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
                        CONCAT( 'ALTER DATABASE ', TABLE_SCHEMA, ' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;' ) item
                FROM
                        information_schema.COLUMNS
        ) UNION (
                SELECT DISTINCT
                        2 ordem,
                        TABLE_SCHEMA,
                        CONCAT( 'ALTER TABLE ', TABLE_SCHEMA, '.', TABLE_NAME, ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;' ) item
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
ALTER DATABASE FitSan DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.ativ_extras CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.ativ_extras_exercicios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.avaliacao CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.contato CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.dados_meta CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.dica CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.informacoes_adicionais CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.informacoes_adicionais_contatos CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.informacoes_adicionais_exercicios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.informacoes_adicionais_medidas CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.meta CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.notificacao CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha_aluno CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha_aluno_exercicio CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha_aluno_feito CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha_exercicio CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha_grupoMuscuCardio CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.planilha_tabela CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.tipo_usuario CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.upload_dica CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.usuario CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE FitSan.vinculo CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--      FIM: Cole aqui os resultados, selecione todos e execute

----------------------------------------------------------------
-- FIM ------------------------------------------------------
----------------------------------------------------------------
-- ALTERANDO CHARSET E COLLATION DO BANCO ----------------------
----------------------------------------------------------------

-- Criar o usuario Administrador --

replace into usuario (nome, sobrenome, senha, email, tipo_id) values ('Administrador','Geral','$2y$10$F4o1IGnrLVcWQaibszv.9O18QcUQ0cES8XYr6Hqv0lqiic00dC8vC', 'admin@admin', null);




