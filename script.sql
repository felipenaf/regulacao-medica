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

CREATE TABLE medico (
	id int NOT NULL AUTO_INCREMENT,
	id_perfil_acesso int NOT NULL,
	id_especialidade int NOT NULL,
	crm varchar(50) NOT NULL,
	nome varchar(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE(crm),
	FOREIGN KEY (id_perfil_acesso) REFERENCES perfil_acesso(id),
	FOREIGN KEY (id_especialidade) REFERENCES especialidade(id)
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

CREATE TABLE solicitacao_encaminhamento (
	id int NOT NULL AUTO_INCREMENT,
	id_paciente int NOT NULL,
	id_especialidade int NOT NULL,
	id_status int NOT NULL,
	id_medico_familia int NOT NULL,
	id_medico_regulador int,
	id_motivo_reprovacao int,
	descricao text NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_paciente) REFERENCES paciente(id),
	FOREIGN KEY (id_especialidade) REFERENCES especialidade(id),
	FOREIGN KEY (id_status) REFERENCES status(id),
	FOREIGN KEY (id_motivo_reprovacao) REFERENCES motivo_reprovacao(id),
	FOREIGN KEY (id_medico_familia) REFERENCES medico(id),
	FOREIGN KEY (id_medico_regulador) REFERENCES medico(id)
);

INSERT INTO estado (id, sigla, nome) VALUES(1, 'mg', 'Minas Gerais');
INSERT INTO estado (id, sigla, nome) VALUES(2, 'am', 'Amazonas');
INSERT INTO estado (id, sigla, nome) VALUES(3, 'pe', 'Pernambuco');
INSERT INTO estado (id, sigla, nome) VALUES(4, 'rs', 'Rio Grande do Sul');

INSERT INTO cidade (id, id_estado, nome) VALUES(1, 1, 'Belo Horizonte');
INSERT INTO cidade (id, id_estado, nome) VALUES(2, 2, 'Manaus');
INSERT INTO cidade (id, id_estado, nome) VALUES(3, 3, 'Recife');
INSERT INTO cidade (id, id_estado, nome) VALUES(4, 4, 'Porto Alegre');

INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(1, 'Felipe', '48246896350', 1);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(2, 'William', '12365974125', 2);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(3, 'Politano', '12396345974', 3);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(4, 'Ana', '12396345999', 4);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(5, 'Gean', '1897774255', 1);
INSERT INTO paciente (id, nome, cpf, id_cidade) VALUES(6, 'Thauanne', '1895554255', 2);

INSERT INTO especialidade (id, nome) VALUES(1, 'Cardiologia');
INSERT INTO especialidade (id, nome) VALUES(2, 'Endocrinologia');
INSERT INTO especialidade (id, nome) VALUES(3, 'Ortopedia');
INSERT INTO especialidade (id, nome) VALUES(4, 'Reumatologia');
INSERT INTO especialidade (id, nome) VALUES(5, 'Clínico Geral');

INSERT INTO perfil_acesso (id, tipo) VALUES(1, 'Médico de Família');
INSERT INTO perfil_acesso (id, tipo) VALUES(2, 'Médico Regulador');

INSERT INTO medico (id, id_perfil_acesso, id_especialidade, crm, nome) VALUES(1, 1, 5, '12345', 'Dr. Amadeus');
INSERT INTO medico (id, id_perfil_acesso, id_especialidade, crm, nome) VALUES(2, 2, 2, '67891', 'Dr. Ludwig');
INSERT INTO medico (id, id_perfil_acesso, id_especialidade, crm, nome) VALUES(3, 1, 5, '13469', 'Dr. Sebastian');
INSERT INTO medico (id, id_perfil_acesso, id_especialidade, crm, nome) VALUES(4, 2, 4, '25896', 'Dr. Frederic');

INSERT INTO status (id, nome) VALUES(1, 'Pendente');
INSERT INTO status (id, nome) VALUES(2, 'Aprovado');
INSERT INTO status (id, nome) VALUES(3, 'Reprovado');

INSERT INTO motivo_reprovacao (id, descricao) VALUES(1, 'Manter na atenção primária');
INSERT INTO motivo_reprovacao (id, descricao) VALUES(2, 'Informações insuficientes');
INSERT INTO motivo_reprovacao (id, descricao) VALUES(3, 'Outros');
