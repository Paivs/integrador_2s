create database if not exists GameHub;
USE GameHub;

CREATE TABLE IF NOT EXISTS equipes (
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    img VARCHAR(100) NOT NULL,
    jogo_equipe VARCHAR(50) NOT NULL,
    descricao VARCHAR(100) NOT NULL,
    privacidade VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email_conta VARCHAR(100) UNIQUE,
    senha_conta VARCHAR(50),
    username_conta VARCHAR(100) NOT NULL UNIQUE,
    id_equipe INT,
	CONSTRAINT fk_equipe FOREIGN KEY (id_equipe) REFERENCES  equipes(id),
    perfil ENUM('root', 'normal') not null default 'normal'
);

CREATE TABLE IF NOT EXISTS torneios (
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome_torneio VARCHAR(100) NOT NULL,
    data_torneio DATE NOT NULL,
    premiacao INT NOT NULL,
    qnt_jogadores INT NOT NULL,
    format_torneio VARCHAR(50) NOT NULL,
    nmjogo_torneio VARCHAR(50) NOT NULL,
    horainit_torneio VARCHAR(15) NOT NULL,
    img VARCHAR(100) NOT NULL,
    Chaveamento VARCHAR(100) NOT NULL,
    taxa double not null default 0.0,
    tipo ENUM('comunidade', 'gamehub') not null default 'gamehub'
);


CREATE TABLE IF NOT EXISTS torneios_equipes(
	id INT AUTO_INCREMENT PRIMARY KEY,
    id_torneio int not null,
    id_equipe int not null,
    CONSTRAINT fk_equipe_id FOREIGN KEY (id_equipe) REFERENCES  equipes(id),
    CONSTRAINT fk_torneio_id FOREIGN KEY (id_torneio) REFERENCES torneios(id)
);


CREATE TABLE IF NOT EXISTS ranking (
	id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario int NOT NULL,
    pontuacao INT NOT NULL,
    CONSTRAINT fk_usuarios_id FOREIGN KEY (id_usuario) REFERENCES  usuarios(id)
);





