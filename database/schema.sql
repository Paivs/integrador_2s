SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS integrador CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE integrador;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS achado;
DROP TABLE IF EXISTS retirada;      -- tabela antiga, substituída por achado
DROP TABLE IF EXISTS mensagem;
DROP TABLE IF EXISTS objetos;
DROP TABLE IF EXISTS pontoColeta;
DROP TABLE IF EXISTS usuario;
SET FOREIGN_KEY_CHECKS = 1;

-- ========== TABELAS ==========

CREATE TABLE usuario(
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL            -- hash do password_hash() do PHP
);

CREATE TABLE pontoColeta(
    idEndereco INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,            -- lugar dentro da empresa onde o objeto é entregue
    logradouro VARCHAR(100) NOT NULL,
    numero INT,
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(100),
    pais VARCHAR(100)
);

CREATE TABLE objetos(
    idObjeto INT PRIMARY KEY AUTO_INCREMENT,
    nomeUsuario INT NOT NULL DEFAULT 1,    -- quem cadastrou (DEFAULT 1 só até o login ficar pronto)
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    localEncontrado VARCHAR(150),
    categoria ENUM('Acessórios', 'Bolsas e Mochilas', 'Documentos', 'Eletrônicos', 'Roupas', 'Outros') NOT NULL,
    imagemObjeto VARCHAR(20),
    status_objeto ENUM('Encontrado', 'Perdido', 'Doado') NOT NULL,
    FOREIGN KEY (nomeUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE achado(
    idAchado INT PRIMARY KEY AUTO_INCREMENT,
    idObjeto INT NOT NULL,
    idUsuarioAchou INT NOT NULL,
    estadoObjeto VARCHAR(100) NOT NULL,
    localEncontrado VARCHAR(150) NOT NULL,
    idPontoColeta INT NOT NULL,
    dataAchado DATETIME DEFAULT CURRENT_TIMESTAMP,
    dataRetirada DATETIME NULL,
    FOREIGN KEY (idObjeto)       REFERENCES objetos(idObjeto),
    FOREIGN KEY (idUsuarioAchou) REFERENCES usuario(idUsuario),
    FOREIGN KEY (idPontoColeta)  REFERENCES pontoColeta(idEndereco)
);

CREATE TABLE mensagem(
    idMensagem INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(11) NOT NULL,
    email VARCHAR(100) NOT NULL,
    assunto ENUM('suporte', 'sugestao', 'reclamacao') NOT NULL,
    mensagem TEXT NOT NULL,
    dataEnvio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ========== DADOS ==========

-- Senhas de teste (para entrar com password_verify): ana@123, bruno@123, carla@123, diego@123, elisa@123
INSERT INTO usuario (nome, telefone, email, senha) VALUES
('Ana Souza',      '11987654321', 'ana.souza@email.com',      '$2b$12$hVtT1tfMMUh0GvYkLAoOouYUzMFUFvuqWK3JDb1k5GZO.27hE1EaK'),
('Bruno Lima',     '11976543210', 'bruno.lima@email.com',     '$2b$12$itNe3Clxv1BHiodh3yMKTu8ijJQhxxcXdUmfN0IPvFztA/V2MWmgW'),
('Carla Mendes',   '11965432109', 'carla.mendes@email.com',   '$2b$12$tD/f6KywWTr2gjhmzk338.GCLmLpI8H5x2617BDJv9esXNjvk5heO'),
('Diego Santos',   '11954321098', 'diego.santos@email.com',   '$2b$12$lN0K/yM79aUFoXGu4/ptSOdA3ALC4BIrt/d3AWLdquWtZfum2dohq'),
('Elisa Ferreira', '11943210987', 'elisa.ferreira@email.com', '$2b$12$ohr.AVcwBdSR1qAkG6aiaO2lxRcHtuSbbcm9SKaxh4Ev0yNGHCQJ2');

-- Todos os pontos ficam no mesmo endereço (a empresa); o nome diferencia o lugar
INSERT INTO pontoColeta (nome, logradouro, numero, bairro, cidade, estado, pais) VALUES
('Recepção',     'Avenida Industrial', 450, 'Jardim', 'Santo André', 'São Paulo', 'Brasil'),
('Portaria',     'Avenida Industrial', 450, 'Jardim', 'Santo André', 'São Paulo', 'Brasil'),
('Secretaria',   'Avenida Industrial', 450, 'Jardim', 'Santo André', 'São Paulo', 'Brasil'),
('Segurança',    'Avenida Industrial', 450, 'Jardim', 'Santo André', 'São Paulo', 'Brasil'),
('Almoxarifado', 'Avenida Industrial', 450, 'Jardim', 'Santo André', 'São Paulo', 'Brasil');

INSERT INTO objetos (nomeUsuario, nome, descricao, localEncontrado, categoria, imagemObjeto, status_objeto) VALUES
(1, 'Carteira',           'Carteira de couro preta com documentos',        'Recepção',              'Documentos',        '💳', 'Perdido'),
(2, 'Celular',            'iPhone com capa azul',                          'Sala de reunião 2',     'Eletrônicos',       '📱', 'Encontrado'),
(3, 'Chave',              'Chaveiro com 3 chaves e um pingente',           'Estacionamento',        'Acessórios',        '🔑', 'Encontrado'),
(4, 'Mochila',            'Mochila cinza com notebook dentro',             'Refeitório',            'Bolsas e Mochilas', '👜', 'Perdido'),
(5, 'Guarda-chuva',       'Guarda-chuva preto automático',                 'Portaria',              'Acessórios',        '🌂', 'Doado'),
(1, 'Óculos de grau',     'Óculos com armação preta e estojo azul',        'Sala de reunião 1',     'Acessórios',        '👓', 'Perdido'),
(2, 'Relógio',            'Relógio de pulso prata com pulseira de metal',  'Vestiário',             'Acessórios',        '⌚', 'Encontrado'),
(3, 'Bolsa',              'Bolsa marrom de alça longa com zíper dourado',  'Recepção',              'Bolsas e Mochilas', '👜', 'Perdido'),
(4, 'Mochila azul',       'Mochila azul com cadernos e carregador dentro', 'Sala de treinamento',   'Bolsas e Mochilas', '👜', 'Encontrado'),
(5, 'Pochete',            'Pochete preta com fecho de pressão',            'Estacionamento',        'Bolsas e Mochilas', '👜', 'Perdido'),
(1, 'RG',                 'RG em nome de Marcos Oliveira',                 'Corredor do 1º andar',  'Documentos',        '💳', 'Encontrado'),
(2, 'CNH',                'Carteira de habilitação categoria B',           'Refeitório',            'Documentos',        '💳', 'Perdido'),
(3, 'Cartão de crédito',  'Cartão Nubank roxo',                            'Copa',                  'Documentos',        '💳', 'Encontrado'),
(4, 'Fone de ouvido',     'Fone bluetooth branco na caixinha',             'Sala de reunião 2',     'Eletrônicos',       '🎧', 'Perdido'),
(5, 'Notebook',           'Notebook cinza de 14 polegadas com capa',       'Sala de treinamento',   'Eletrônicos',       '💻', 'Encontrado'),
(1, 'Carregador',         'Carregador de celular branco com cabo USB-C',   'Sala de reunião 1',     'Eletrônicos',       '📱', 'Perdido'),
(2, 'Casaco',             'Casaco de moletom cinza tamanho M',             'Auditório',             'Roupas',            '🧥', 'Doado'),
(3, 'Boné',               'Boné preto com aba reta',                       'Estacionamento',        'Roupas',            '🧢', 'Perdido'),
(4, 'Cachecol',           'Cachecol de lã vermelho',                       'Auditório',             'Roupas',            '🧥', 'Doado'),
(5, 'Garrafa térmica',    'Garrafa térmica azul de 500 ml',                'Copa',                  'Outros',            '🥤', 'Perdido'),
(1, 'Bola de futebol',    'Bola de futebol branca e preta',                'Área de lazer',         'Outros',            '⚽', 'Encontrado'),
(2, 'Patins',             'Patins rosa tamanho 36',                        'Área de lazer',         'Outros',            '🛼', 'Perdido'),
(3, 'Videogame portátil', 'Videogame portátil preto com capa',             'Área de descanso',      'Outros',            '🎮', 'Encontrado'),
(4, 'Ursinho de pelúcia', 'Ursinho marrom com laço vermelho',              'Sala de reunião 1',     'Outros',            '🧸', 'Perdido'),
(5, 'Crachá',             'Crachá de funcionário com cordão azul',         'Corredor do 2º andar',  'Documentos',        '💳', 'Doado'),
(1, 'Batom',              'Batom vermelho na necessaire',                  'Banheiro do 2º andar',  'Acessórios',        '💄', 'Perdido'),
(2, 'Anel',               'Anel dourado com pedra azul',                   'Vestiário',             'Acessórios',        '💍', 'Encontrado'),
(3, 'Câmera',             'Câmera digital preta com alça',                 'Auditório',             'Eletrônicos',       '📷', 'Perdido'),
(4, 'Livro',              'Livro de capa azul com marca-página',           'Sala de treinamento',   'Documentos',        '📚', 'Encontrado'),
(5, 'Agenda',             'Agenda preta com anotações',                    'Sala de reunião 2',     'Documentos',        '📓', 'Perdido'),
(1, 'Caneta',             'Caneta tinteiro prateada',                      'Sala de reunião 1',     'Documentos',        '🖊️', 'Doado'),
(2, 'Martelo',            'Martelo com cabo de madeira',                   'Almoxarifado',          'Outros',            '🔨', 'Perdido');

-- Achados de exemplo: só de objetos Encontrados (ids 2, 3, 7, 9, 11)
-- Quem achou é sempre diferente do dono do objeto. As datas variam para testar a regra dos 30 dias.
INSERT INTO achado (idObjeto, idUsuarioAchou, estadoObjeto, localEncontrado, idPontoColeta, dataAchado, dataRetirada) VALUES
(2,  1, 'Perfeito',           'Sala de reunião 2',    1, NOW() - INTERVAL 2 DAY,  NULL),
(3,  2, 'Com marcas de uso',  'Estacionamento',       2, NOW() - INTERVAL 10 DAY, NULL),
(7,  5, 'Perfeito',           'Vestiário',            3, NOW() - INTERVAL 25 DAY, NULL),
(9,  3, 'Danificado',         'Sala de treinamento',  4, NOW() - INTERVAL 40 DAY, NULL),
(11, 4, 'Perfeito',           'Corredor do 1º andar', 1, NOW() - INTERVAL 5 DAY,  NOW() - INTERVAL 1 DAY);

INSERT INTO mensagem (nome, telefone, email, assunto, mensagem) VALUES
('Ana Souza',    '11987654321', 'ana.souza@email.com',    'suporte',    'Não consegui cadastrar o meu objeto.'),
('Carla Mendes', '11965432109', 'carla.mendes@email.com', 'sugestao',   'Seria legal receber um aviso quando um objeto parecido com o meu for cadastrado.'),
('Diego Santos', '11954321098', 'diego.santos@email.com', 'reclamacao', 'O e-mail de aviso demorou para chegar.');