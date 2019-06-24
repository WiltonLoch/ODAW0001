create database tutorias;

use tutorias;

create table disciplinas(id int auto_increment primary key, sigla varchar(15), nome varchar(100));

create table usuarios(id int auto_increment primary key, nome varchar(10), sobrenome varchar(30), email varchar(50), universidade varchar(10), cpf char(11) unique, telefone varchar(13), nascimento date, senha varchar(15), usuario varchar(15) unique, genero char(1), facebook varchar(50) unique, descricao varchar(300), imagem varchar(30));

create table usuarios_disciplinas(id int auto_increment primary key, id_usuario int, id_disciplina int, foreign key(id_usuario) references usuarios(id), foreign key(id_disciplina) references disciplinas(id));

create table tutorias(id int auto_increment primary key, id_tutor int, id_aluno int, id_disciplina int, status bit(2), avaliacao float, foreign key(id_tutor) references usuarios(id), foreign key(id_aluno) references usuarios(id), foreign key(id_disciplina) references disciplinas(id));

insert into usuarios (nome, sobrenome, email, universidade, cpf, telefone, nascimento, senha, usuario, genero, facebook, descricao, imagem) values ("wilton", "jaciel loch", 'wilton@hotmail.com.br', 'UDESC', '05832860977', '47988685970', '1998-11-14', 'abc123', 'wilton', 'M', 'wilton.loch', 'meu nome é wilton', 'imagens/wilton.jpg');
insert into usuarios (nome, sobrenome, email, universidade, cpf, telefone, nascimento, senha, usuario, genero, facebook, descricao, imagem) values ("Felipe", "Weiss", 'weisslipe@gmail.com', 'UDESC', '12345678901', '47988685970', '1998-11-14', 'abc123', 'weiss', 'M', 'lipeweiss', 'meu nome é weiss', 'imagens/weiss.jpg');

insert into disciplinas (sigla, nome) values("TEG0001", "Teoria dos Grafos");
insert into disciplinas (sigla, nome) values("REC0001", "Redes de Computadores");
insert into disciplinas (sigla, nome) values("OCEV0001", "Computação Evolucionária");
insert into disciplinas (sigla, nome) values("ODAW0001", "Desenvolvimento de Aplicações Web");

insert into usuarios_disciplinas(id_usuario, id_disciplina) values (2, 1);
insert into usuarios_disciplinas(id_usuario, id_disciplina) values (1, 2);
