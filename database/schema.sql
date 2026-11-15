CREATE DATABASE integrador CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE integrador;

-- ========== TABELAS ==========

CREATE TABLE usuario(
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL
);

CREATE TABLE pontoColeta(
    idEndereco INT PRIMARY KEY AUTO_INCREMENT,
    logradouro VARCHAR(100) NOT NULL,
    numero INT,
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(100),
    pais VARCHAR(100)
);

CREATE TABLE objetos(
    idObjeto INT PRIMARY KEY AUTO_INCREMENT,
    nomeUsuario INT NOT NULL DEFAULT 1,   -- quem cadastrou (DEFAULT 1 só até o login ficar pronto)
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    localEncontrado VARCHAR(150),
    categoria ENUM('Acessórios', 'Bolsas e Mochilas', 'Documentos', 'Eletrônicos', 'Roupas', 'Outros') NOT NULL,
    imagemObjeto VARCHAR(20),
    status_objeto ENUM('Encontrado', 'Perdido', 'Abandonado') NOT NULL,
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
    nomeUsuario INT NOT NULL,
    assunto ENUM('Suporte', 'Sugestão', 'Reclamação') NOT NULL,
    mensagem TEXT NOT NULL,
    FOREIGN KEY (nomeUsuario) REFERENCES usuario(idUsuario)
);

-- ========== DADOS ==========

INSERT INTO usuario (nome, telefone, email, senha) VALUES
('Ana Souza',      '11987654321', 'ana.souza@email.com',      SHA2('ana@123', 256)),
('Bruno Lima',     '11976543210', 'bruno.lima@email.com',     SHA2('bruno@123', 256)),
('Carla Mendes',   '11965432109', 'carla.mendes@email.com',   SHA2('carla@123', 256)),
('Diego Santos',   '11954321098', 'diego.santos@email.com',   SHA2('diego@123', 256)),
('Elisa Ferreira', '11943210987', 'elisa.ferreira@email.com', SHA2('elisa@123', 256));

INSERT INTO pontoColeta (logradouro, numero, bairro, cidade, estado, pais) VALUES
('Rua das Flores',       120, 'Centro',        'Santo André',           'São Paulo', 'Brasil'),
('Avenida Industrial',   450, 'Jardim',        'Santo André',           'São Paulo', 'Brasil'),
('Rua Marechal Deodoro',  85, 'Centro',        'São Bernardo do Campo', 'São Paulo', 'Brasil'),
('Avenida Paulista',     900, 'Bela Vista',    'São Paulo',             'São Paulo', 'Brasil'),
('Rua Sete de Setembro',  33, 'Vila Assunção', 'Santo André',           'São Paulo', 'Brasil');

INSERT INTO objetos (nomeUsuario, nome, descricao, localEncontrado, categoria, imagemObjeto, status_objeto) VALUES
(1, 'Carteira',           'Carteira de couro preta com documentos',        'Estação Santo André',     'Documentos',        '💳', 'Perdido'),
(2, 'Celular',            'iPhone com capa azul',                          'Parque Celso Daniel',     'Eletrônicos',       '📱', 'Encontrado'),
(3, 'Chave',              'Chaveiro com 3 chaves e um pingente',           'Praça do Carmo',          'Acessórios',        '🔑', 'Encontrado'),
(4, 'Mochila',            'Mochila cinza com notebook dentro',             'Terminal Vila Luzita',    'Bolsas e Mochilas', '👜', 'Perdido'),
(5, 'Guarda-chuva',       'Guarda-chuva preto automático',                 'Biblioteca Municipal',    'Acessórios',        '🌂', 'Abandonado'),
(1, 'Óculos de grau',     'Óculos com armação preta e estojo azul',        'Shopping ABC',            'Acessórios',        '👓', 'Perdido'),
(2, 'Relógio',            'Relógio de pulso prata com pulseira de metal',  'Academia Centro',         'Acessórios',        '⌚', 'Encontrado'),
(3, 'Bolsa',              'Bolsa marrom de alça longa com zíper dourado',  'Estação Santo André',     'Bolsas e Mochilas', '👜', 'Perdido'),
(4, 'Mochila escolar',    'Mochila azul com estojo e cadernos dentro',     'Escola Estadual Centro',  'Bolsas e Mochilas', '👜', 'Encontrado'),
(5, 'Pochete',            'Pochete preta com fecho de pressão',            'Parque Celso Daniel',     'Bolsas e Mochilas', '👜', 'Perdido'),
(1, 'RG',                 'RG em nome de Marcos Oliveira',                 'Praça do Carmo',          'Documentos',        '💳', 'Encontrado'),
(2, 'CNH',                'Carteira de habilitação categoria B',           'Shopping ABC',            'Documentos',        '💳', 'Perdido'),
(3, 'Cartão de crédito',  'Cartão Nubank roxo',                            'Terminal Vila Luzita',    'Documentos',        '💳', 'Encontrado'),
(4, 'Fone de ouvido',     'Fone bluetooth branco na caixinha',             'Academia Centro',         'Eletrônicos',       '🎧', 'Perdido'),
(5, 'Notebook',           'Notebook cinza de 14 polegadas com capa',       'Biblioteca Municipal',    'Eletrônicos',       '💻', 'Encontrado'),
(1, 'Carregador',         'Carregador de celular branco com cabo USB-C',   'Escola Estadual Centro',  'Eletrônicos',       '📱', 'Perdido'),
(2, 'Casaco',             'Casaco de moletom cinza tamanho M',             'Estação Santo André',     'Roupas',            '🧥', 'Abandonado'),
(3, 'Boné',               'Boné preto com aba reta',                       'Parque Celso Daniel',     'Roupas',            '🧢', 'Perdido'),
(4, 'Cachecol',           'Cachecol de lã vermelho',                       'Praça do Carmo',          'Roupas',            '🧥', 'Abandonado'),
(5, 'Garrafa térmica',    'Garrafa térmica azul de 500 ml',                'Academia Centro',         'Outros',            '🥤', 'Perdido'),
(1, 'Bola de futebol',    'Bola de futebol branca e preta',                'Parque Celso Daniel',     'Outros',            '⚽', 'Encontrado'),
(2, 'Patins',             'Patins rosa tamanho 36',                        'Praça do Carmo',          'Outros',            '🛼', 'Perdido'),
(3, 'Videogame portátil', 'Videogame portátil preto com capa',             'Shopping ABC',            'Outros',            '🎮', 'Encontrado'),
(4, 'Ursinho de pelúcia', 'Ursinho marrom com laço vermelho',              'Escola Estadual Centro',  'Outros',            '🧸', 'Perdido'),
(5, 'Caixa de chocolates','Caixa de chocolates fechada',                   'Terminal Vila Luzita',    'Outros',            '🍫', 'Abandonado'),
(1, 'Batom',              'Batom vermelho na necessaire',                  'Shopping ABC',            'Acessórios',        '💄', 'Perdido'),
(2, 'Anel',               'Anel dourado com pedra azul',                   'Praça do Carmo',          'Acessórios',        '💍', 'Encontrado'),
(3, 'Câmera',             'Câmera digital preta com alça',                 'Parque Celso Daniel',     'Eletrônicos',       '📷', 'Perdido'),
(4, 'Livro',              'Livro de capa azul com marca-página',           'Biblioteca Municipal',    'Documentos',        '📚', 'Encontrado'),
(5, 'Agenda',             'Agenda preta com anotações',                    'Escola Estadual Centro',  'Documentos',        '📓', 'Perdido'),
(1, 'Caneta',             'Caneta tinteiro prateada',                      'Biblioteca Municipal',    'Documentos',        '🖊', 'Abandonado'),
(2, 'Martelo',            'Martelo com cabo de madeira',                   'Terminal Vila Luzita',    'Outros',            '🔨', 'Perdido');

-- Achados de exemplo: só de objetos Encontrados (ids 2, 3, 7, 9, 11)
-- Quem achou é sempre diferente do dono do objeto. As datas variam para testar a regra dos 30 dias.
INSERT INTO achado (idObjeto, idUsuarioAchou, estadoObjeto, localEncontrado, idPontoColeta, dataAchado, dataRetirada) VALUES
(2,  1, 'Perfeito',           'Parque Celso Daniel',    2, NOW() - INTERVAL 2 DAY,  NULL),
(3,  2, 'Com marcas de uso',  'Praça do Carmo',         3, NOW() - INTERVAL 10 DAY, NULL),
(7,  5, 'Perfeito',           'Academia Centro',        1, NOW() - INTERVAL 25 DAY, NULL),
(9,  3, 'Danificado',         'Escola Estadual Centro', 4, NOW() - INTERVAL 40 DAY, NULL),
(11, 4, 'Perfeito',           'Praça do Carmo',         5, NOW() - INTERVAL 5 DAY,  NOW() - INTERVAL 1 DAY);

INSERT INTO mensagem (nomeUsuario, assunto, mensagem) VALUES
(1, 'Suporte',    'Não consegui cadastrar a foto do meu objeto.'),
(3, 'Sugestão',   'Seria legal receber um aviso quando um objeto parecido com o meu for cadastrado.'),
(4, 'Reclamação', 'O e-mail de aviso demorou para chegar.');