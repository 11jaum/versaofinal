drop database papocabecachat;

create database papocabecachat;

use papocabecachat;

CREATE TABLE Chat (
  Id int(11) NOT NULL,
  Sender int(11) NOT NULL,
  Reciever int(11) NOT NULL,
  Message varchar(500) NOT NULL,
  Image varchar(1000) NOT NULL,
  Creation datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE Conversations (
  Id int(11) NOT NULL,
  MainUser int(11) NOT NULL,
  OtherUser int(11) NOT NULL,
  Unread varchar(1) NOT NULL DEFAULT 'n',
  Modification timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Creation datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE User (
  Id int(11) NOT NULL,
  Username varchar(15) NOT NULL,
  Email varchar(200) NOT NULL,
  Password varchar(70) NOT NULL,
  Picture varchar(1000) NOT NULL DEFAULT 'user.jpg',
  Online datetime NOT NULL,
  Token varchar(100) NOT NULL,
  Secure bigint(11) NOT NULL,
  Creation datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE Chat
  ADD PRIMARY KEY (Id);

ALTER TABLE Conversations
  ADD PRIMARY KEY (Id);

ALTER TABLE User
  ADD PRIMARY KEY (Id),
  ADD UNIQUE KEY Id (Id);

ALTER TABLE Chat
  MODIFY Id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE Conversations
  MODIFY Id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE User
  MODIFY Id int(11) NOT NULL AUTO_INCREMENT;

create table consulta (
id INT auto_increment primary key,
username VARCHAR(15) NOT NULL,
nome VARCHAR(100) NOT NULL,
data_consulta DATE NOT NULL,
hora TIME NOT NULL,
descricao TEXT
);

CREATE TABLE `support` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE psicologos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_psicologo VARCHAR(255) NOT NULL,
    cpf_psicologo VARCHAR(15) NOT NULL,
    especialidade VARCHAR(255) NOT NULL,
    crp VARCHAR(50) NOT NULL,
    disponibilidade TEXT NOT NULL,
    email VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE consulta
ADD COLUMN contato TEXT NOT NULL;

ALTER TABLE psicologos DROP COLUMN username_psicologo;

ALTER TABLE consulta ADD status VARCHAR(20) DEFAULT 'pendente';
select * from user;

ALTER TABLE consulta ADD COLUMN user_id INT NOT NULL;
ALTER TABLE consulta ADD FOREIGN KEY (user_id) REFERENCES User(Id);


UPDATE consulta SET status = 'aceita' WHERE id = 1;


ALTER TABLE consulta ADD COLUMN email VARCHAR(255) NOT NULL;
