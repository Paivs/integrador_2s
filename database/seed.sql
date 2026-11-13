-- seed


USE GameHub;


-- =========================================
-- 1. TABELA EQUIPES
-- =========================================

INSERT INTO equipes (nome, img, jogo_equipe, descricao) VALUES

('FURIA', 'furia.png', 'Counter-Strike 2',
'A FURIA é uma organização brasileira de esports reconhecida mundialmente por sua competitividade, dedicação e presença em grandes campeonatos internacionais.'),

('LOUD', 'loud.png', 'Valorant',
'A LOUD é uma organização brasileira de esports conhecida por sua forte comunidade, jogadores talentosos e destaque no cenário competitivo de Valorant.'),

('Team Liquid', 'liquid.png', 'League of Legends',
'A Team Liquid é uma organização internacional de esports com tradição competitiva, presença global e equipes de alto nível em diversas modalidades.'),

('MIBR', 'mibr.png', 'Counter-Strike 2',
'O MIBR é uma tradicional organização brasileira de esports, conhecida por sua história no Counter-Strike e participação em grandes competições mundiais.'),

('Pain Gaming', 'pain.png', 'League of Legends',
'A paiN Gaming é uma organização brasileira de esports com uma trajetória marcante, torcida apaixonada e forte presença no cenário competitivo de League of Legends.');


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


('Phantom Tournament', '2026-11-20', 3000, 10, 'Pontos corridos', 'Valorant', '16:00', 15.00, 'gamehub'),

('Rocket Champions', '2026-11-25', 2500, 10, 'Eliminatoria', 'Rocket League', '15:00', 10.00, 'comunidade'),

('Master League', '2026-12-05', 7000, 16, 'Eliminatoria', 'Counter-Strike 2', '18:00', 20.00, 'gamehub'),

('EA Cup', '2026-12-02', 4000, 16, 'Eliminatoria', 'EA FC', '12:00', 10.00, 'gamehub'),

('FN Cup', '2026-12-09', 9000, 16, 'Eliminatoria', 'Fortnite', '12:00', 10.00, 'gamehub'),

('Siege Cup', '2026-12-14', 3000, 16, 'Eliminatoria', 'Tom Clancy´s Rainbow Six Siege', '12:00', 10.00, 'gamehub'),

('CNLOL', '2026-12-22', 2000, 16, 'Eliminatoria', 'League of Legends', '12:00', 10.00, 'gamehub'),

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
