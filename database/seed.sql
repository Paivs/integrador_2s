-- seed


USE GameHub;

-- =========================================
-- 1. TABELA EQUIPES
-- =========================================

INSERT INTO equipes (nome, img, jogo_equipe) VALUES
('FURIA', 'furia.png', 'Counter-Strike 2'),
('LOUD', 'loud.png', 'Valorant'),
('Team Liquid', 'liquid.png', 'League of Legends'),
('MIBR', 'mibr.png', 'Counter-Strike 2'),
('Fluxo', 'fluxo.png', 'Free Fire'),
('Pain Gaming', 'pain.png', 'League of Legends');

-- =========================================
-- 2. TABELA USUARIOS
-- =========================================

INSERT INTO usuarios (email_conta, senha_conta, username_conta, id_equipe) VALUES
('joao@gmail.com', 'senha123', 'JoaoFPS', 1),
('pedro@gmail.com', 'senha456', 'PedroGamer', 2),
('lucas@gmail.com', 'senha789', 'LucasPro', 3),
('gabriel@gmail.com', 'gabriel123', 'GabsMIBR', 4),
('matheus@gmail.com', 'matheus456', 'MathFPS', 5),
('rafael@gmail.com', 'rafael789', 'RafaPain', 6),
('ana@gmail.com', 'ana123', 'AnaGamer', 1);

-- =========================================
-- 3. TABELA TORNEIOS
-- =========================================

INSERT INTO torneios (
    nome_torneio,
    data_torneio,
    premiacao,
    qnt_jogadores,
    format_torneio,
    nmjogo_torneio,
    horainit_torneio,
    taxa,
    tipo
) VALUES
('GameHub Championship', '2026-11-15', 5000, 16, 'Eliminatoria', 'Counter-Strike 2', '14:00', 0.00, 'gamehub'),

('Valorant Masters', '2026-11-20', 3000, 10, 'Pontos corridos', 'Valorant', '16:00', 15.00, 'gamehub'),

('League of Legends Cup', '2026-11-25', 2500, 10, 'Eliminatoria', 'League of Legends', '15:00', 10.00, 'gamehub'),

('Free Fire Battle', '2026-12-01', 1500, 20, 'Pontos corridos', 'Free Fire', '19:00', 5.00, 'comunidade'),

('CS2 Pro League', '2026-12-05', 7000, 16, 'Eliminatoria', 'Counter-Strike 2', '18:00', 20.00, 'comunidade'),

('GameHub Open', '2026-12-10', 1000, 8, 'Eliminatoria', 'Valorant', '13:00', 0.00, 'comunidade');

-- =========================================
-- 4. TABELA TORNEIOS_EQUIPES
-- =========================================

INSERT INTO torneios_equipes (id_torneio, id_equipe) VALUES
(1, 1),
(1, 4),
(2, 2),
(3, 3),
(3, 6),
(4, 5),
(5, 1),
(5, 4),
(6, 2);

-- =========================================
-- 5. TABELA RANKING
-- =========================================

INSERT INTO ranking (id_usuario, pontuacao) VALUES
(1, 1500),
(2, 1350),
(3, 1800),
(4, 1200),
(5, 950),
(6, 1600),
(7, 1750);
