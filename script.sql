drop database if exists regulacao_medica;
create database regulacao_medica;
use regulacao_medica;

create table estado (
	id int not null,
	nome varchar(255) not null,
	primary key (id)
);

create table cidade (
	id int not null,
	id_estado int not null,
	nome varchar(255) not null,
	primary key (id),
	foreign key (id_estado) references estado(id)
);

create table paciente (
	id int not null,
	nome varchar(255) not null,
	cpf varchar(50) not null,
	id_cidade int not null,
	primary key (id),
	unique(cpf),
	foreign key (id_cidade) references cidade(id)
);

create table especialidade (
	id int not null,
	nome varchar(255) not null,
	primary key (id)
);

create table perfil_acesso (
	id int not null,
	tipo varchar(255) not null,
	primary key (id)
);

create table profissional_saude (
	id int not null,
	id_perfil_acesso int not null,
	crm varchar(50) not null,
	nome varchar(255) not null,
	primary key (id),
	unique(crm),
	foreign key (id_perfil_acesso) references perfil_acesso(id)
);

create table status (
	id int not null,
	nome varchar(255) not null,
	primary key (id)
);

create table solicitacao_encaminhamento (
	id int not null,
	id_paciente int not null,
	id_especialidade int not null,
	id_status int not null,
	descricao text not null,
	primary key (id),
	foreign key (id_paciente) references paciente(id),
	foreign key (id_especialidade) references especialidade(id),
	foreign key (id_status) references status(id)
);




