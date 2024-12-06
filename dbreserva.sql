-- Criação do banco de dados
DROP DATABASE IF EXISTS papocabecachat;
CREATE DATABASE papocabecachat;
USE papocabecachat;

-- Tabela Chat
CREATE TABLE Chat (
  Id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Sender INT(11) NOT NULL,
  Reciever INT(11) NOT NULL,
  Message VARCHAR(500) NOT NULL,
  Image VARCHAR(1000) NOT NULL,
  Creation DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela Conversations
CREATE TABLE Conversations (
  Id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  MainUser INT(11) NOT NULL,
  OtherUser INT(11) NOT NULL,
  Unread VARCHAR(1) NOT NULL DEFAULT 'n',
  Modification TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Creation DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela User
CREATE TABLE User (
  Id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(15) NOT NULL,
  Email VARCHAR(200) NOT NULL,
  Password VARCHAR(70) NOT NULL,
  Picture VARCHAR(1000) NOT NULL DEFAULT 'user.jpg',
  Online DATETIME NOT NULL,
  Token VARCHAR(100) NOT NULL,
  Secure BIGINT(11) NOT NULL,
  Creation DATETIME NOT NULL,
  UNIQUE KEY Id (Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela consulta
CREATE TABLE consulta (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(15) NOT NULL,
  nome VARCHAR(100) NOT NULL,
  data_consulta DATE NOT NULL,
  hora TIME NOT NULL,
  descricao TEXT,
  status VARCHAR(20) DEFAULT 'pendente',
  contato TEXT NOT NULL,
  email VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES User(Id)
);

-- Tabela support
CREATE TABLE support (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela psicologos
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

-- Alterações adicionais
-- Removendo coluna desnecessária da tabela psicologos
ALTER TABLE psicologos DROP COLUMN username_psicologo;

-- Atualizando consulta com status 'aceita'
UPDATE consulta SET status = 'aceita' WHERE id = 1;

-- Consultas de teste
SELECT * FROM User;
SELECT * FROM consulta WHERE username = 'llorewx_' AND status = 'aceita';
SELECT * FROM consulta WHERE status = 'aceita';
