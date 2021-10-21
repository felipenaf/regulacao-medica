DROP DATABASE IF EXISTS regulacao_medica;

CREATE DATABASE regulacao_medica;

USE regulacao_medica;

CREATE TABLE estado (
id int NOT NULL AUTO_INCREMENT,
sigla char(2) NOT NULL,
nome varchar(255) NOT NULL,
PRIMARY KEY (id),
UNIQUE(sigla)
);

CREATE TABLE cidade (
id int NOT NULL AUTO_INCREMENT,
id_estado int NOT NULL,
nome varchar(255) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (id_estado) REFERENCES estado(id)
);

CREATE TABLE paciente (
 id int NOT NULL AUTO_INCREMENT,
 nome varchar(255) NOT NULL,
 cpf varchar(50) NOT NULL,
 id_cidade int NOT NULL,
 PRIMARY KEY (id),
 UNIQUE(cpf),
 FOREIGN KEY (id_cidade) REFERENCES cidade(id)
);

CREATE TABLE especialidade (
id int NOT NULL AUTO_INCREMENT,
nome varchar(255) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE perfil_acesso (
id int NOT NULL AUTO_INCREMENT,
tipo varchar(255) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE usuario (
id int NOT NULL AUTO_INCREMENT,
email varchar(100) NOT NULL,
senha varchar(255) NOT NULL,
id_perfil_acesso int NOT NULL,
nome varchar(255) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (id_perfil_acesso) REFERENCES perfil_acesso(id)
);

CREATE TABLE status (
id int NOT NULL AUTO_INCREMENT,
nome varchar(255) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE motivo_reprovacao (
id int NOT NULL AUTO_INCREMENT,
descricao varchar(255) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE encaminhamento (
id int NOT NULL AUTO_INCREMENT,
id_paciente int NOT NULL,
id_especialidade int NOT NULL,
id_status int NOT NULL,
id_medico_familia int NOT NULL,
id_medico_regulador int,
descricao text NOT NULL,
id_motivo_reprovacao int,
descricao_reprovacao text,
data_criacao timestamp NOT NULL DEFAULT current_timestamp,
data_atualizacao timestamp NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp,
PRIMARY KEY (id),
FOREIGN KEY (id_paciente) REFERENCES paciente(id),
FOREIGN KEY (id_especialidade) REFERENCES especialidade(id),
FOREIGN KEY (id_status) REFERENCES status(id),
FOREIGN KEY (id_motivo_reprovacao) REFERENCES motivo_reprovacao(id),
FOREIGN KEY (id_medico_familia) REFERENCES usuario(id),
FOREIGN KEY (id_medico_regulador) REFERENCES usuario(id)
);

CREATE TABLE encaminhamento_historico (
id int NOT NULL AUTO_INCREMENT,
id_encaminhamento int NOT NULL,
id_paciente int NOT NULL,
id_especialidade int NOT NULL,
id_status int NOT NULL,
id_medico_familia int NOT NULL,
id_medico_regulador int,
descricao text NOT NULL,
id_motivo_reprovacao int,
descricao_reprovacao text,
data_criacao timestamp NOT NULL DEFAULT current_timestamp,
PRIMARY KEY (id),
FOREIGN KEY (id_paciente) REFERENCES paciente(id),
FOREIGN KEY (id_especialidade) REFERENCES especialidade(id),
FOREIGN KEY (id_status) REFERENCES status(id),
FOREIGN KEY (id_motivo_reprovacao) REFERENCES motivo_reprovacao(id),
FOREIGN KEY (id_medico_familia) REFERENCES usuario(id),
FOREIGN KEY (id_medico_regulador) REFERENCES usuario(id),
FOREIGN KEY (id_encaminhamento) REFERENCES encaminhamento(id)
);

INSERT INTO estado (id, sigla, nome) VALUES(1, 'mg', 'Minas Gerais');
INSERT INTO estado (id, sigla, nome) VALUES(2, 'am', 'Amazonas');
INSERT INTO estado (id, sigla, nome) VALUES(3, 'pe', 'Pernambuco');
INSERT INTO estado (id, sigla, nome) VALUES(4, 'rs', 'Rio Grande do Sul');

INSERT INTO cidade (id, id_estado, nome) VALUES(1, 1, 'Belo Horizonte');
INSERT INTO cidade (id, id_estado, nome) VALUES(2, 2, 'Manaus');
INSERT INTO cidade (id, id_estado, nome) VALUES(3, 3, 'Recife');
INSERT INTO cidade (id, id_estado, nome) VALUES(4, 4, 'Porto Alegre');

INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(1, 'Felipe', '482.468.963-50', 1);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(2, 'William', '123.659.741-25', 2);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(3, 'Politano', '123.963.459-74', 3);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(4, 'Ana', '123.963.459-99', 4);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(5, 'Gean', '189.777.425-5', 1);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(6, 'Thauanne', '189.555.425-5', 2);

INSERT INTO especialidade (id, nome) VALUES(1, 'Cardiologia');
INSERT INTO especialidade (id, nome) VALUES(2, 'Endocrinologia');
INSERT INTO especialidade (id, nome) VALUES(3, 'Ortopedia');
INSERT INTO especialidade (id, nome) VALUES(4, 'Reumatologia');

INSERT INTO perfil_acesso (id, tipo) VALUES(1, 'Médico de Família');
INSERT INTO perfil_acesso (id, tipo) VALUES(2, 'Médico Regulador');

INSERT INTO usuario (id, email, senha, id_perfil_acesso, nome) VALUES(1, 'amadeus@hsl.com', '123', 1, 'Dr. Amadeus');
INSERT INTO usuario (id, email, senha, id_perfil_acesso, nome) VALUES(2, 'ludwig@hsl.com', '123', 2, 'Dr. Ludwig');
INSERT INTO usuario (id, email, senha, id_perfil_acesso, nome) VALUES(3, 'sebastian@hsl.com', '123', 1, 'Dr. Sebastian');
INSERT INTO usuario (id, email, senha, id_perfil_acesso, nome) VALUES(4, 'frederic@hsl.com', '123', 2, 'Dr. Frederic');

INSERT INTO status (id, nome) VALUES(1, 'Pendente');
INSERT INTO status (id, nome) VALUES(2, 'Aprovado');
INSERT INTO status (id, nome) VALUES(3, 'Reprovado');

INSERT INTO motivo_reprovacao (id, descricao) VALUES(1, 'Manter na atenção primária');
INSERT INTO motivo_reprovacao (id, descricao) VALUES(2, 'Informações insuficientes');
INSERT INTO motivo_reprovacao (id, descricao) VALUES(3, 'Outros');
