
-- ==========================================
-- SEED: MAKERLAB
-- ==========================================

USE makerLab;


-- ==========================================
-- 1. USUARIOS
-- ==========================================

INSERT INTO Usuarios
(nome_usuario, email, senha, instituicao, telefone, perfil)
VALUES
('João Silva', 'joao@email.com', '123456', 'IFSP', '11999990001', 'admin'),
('Maria Oliveira', 'maria@email.com', '123456', 'USP', '11999990002', 'normal'),
('Pedro Santos', 'pedro@email.com', '123456', 'UNICAMP', '11999990003', 'normal'),
('Ana Costa', 'ana@email.com', '123456', 'IFSP', '11999990004', 'normal'),
('Lucas Ferreira', 'lucas@email.com', '123456', 'SENAI', '11999990005', 'normal'),
('Beatriz Lima', 'beatriz@email.com', '123456', 'UNESP', '11999990006', 'normal'),
('Gabriel Souza', 'gabriel@email.com', '123456', 'USP', '11999990007', 'normal'),
('Camila Rocha', 'camila@email.com', '123456', 'UFABC', '11999990008', 'admin'),
('Mateus Alves', 'mateus@email.com', '123456', 'IFSP', '11999990009', 'normal'),
('Juliana Mendes', 'juliana@email.com', '123456', 'FATEC', '11999990010', 'normal');


-- ==========================================
-- 2. BANCADAS
-- ==========================================

INSERT INTO Bancadas
(nome_bancada, descricao_bancada, quantidade_bancada,
 primeira_vantagem, segunda_vantagem, imagens_bancada,
 preco_bancada, status_bancada, area_bancada)
VALUES
('Bancada de Eletrônica',
 'Espaço para projetos eletrônicos e circuitos.',
 6, 'Arduino e sensores', 'Ferros de solda',
 'eletronica.jpg', 25.00, 'disponivel', 'Eletrônica'),

('Bancada de Impressão 3D',
 'Espaço equipado para impressão 3D.',
 4, 'Impressoras 3D', 'Filamentos variados',
 'impressao3d.jpg', 35.00, 'disponivel', 'Prototipagem'),

('Bancada de Marcenaria',
 'Espaço para trabalhos com madeira.',
 8, 'Serras e lixadeiras', 'Bancada reforçada',
 'marcenaria.jpg', 30.00, 'disponivel', 'Marcenaria'),

('Bancada de Robótica',
 'Espaço para montagem e programação de robôs.',
 6, 'Kits de robótica', 'Notebooks',
 'robotica.jpg', 40.00, 'manutencao', 'Robótica'),

('Bancada de Prototipagem',
 'Espaço para desenvolvimento de protótipos.',
 5, 'Mesa ampla', 'Ferramentas manuais',
 'prototipagem.jpg', 28.00, 'disponivel', 'Prototipagem'),

('Bancada de Corte a Laser',
 'Espaço equipado para corte e gravação a laser.',
 3, 'Cortadora a laser', 'Exaustão',
 'corte_laser.jpg', 45.00, 'disponivel', 'Corte e Usinagem'),

('Bancada de Química e Materiais',
 'Espaço para testes com resinas, tintas e polímeros.',
 4, 'Capela de exaustão', 'Balanças de precisão',
 'quimica.jpg', 32.00, 'disponivel', 'Química'),

('Bancada de IoT & Sensores',
 'Espaço dedicado a automação residencial e redes sem fio.',
 6, 'Módulos Wi-Fi', 'Sensores variados',
 'iot.jpg', 38.00, 'disponivel', 'Eletrônica');


-- ==========================================
-- 3. FERRAMENTAS
-- ==========================================

INSERT INTO Ferramentas
(nome_ferramenta, area, estoque, id_bancada, status_ferramenta)
VALUES
('Ferro de Solda', 'Eletrônica', 10, 1, 'disponivel'),
('Multímetro Digital', 'Eletrônica', 8, 1, 'disponivel'),
('Osciloscópio', 'Eletrônica', 3, 1, 'disponivel'),
('Impressora 3D Ender 3', 'Prototipagem', 2, 2, 'disponivel'),
('SLA Resin Printer', 'Prototipagem', 1, 2, 'disponivel'),
('Serra Tico-Tico', 'Marcenaria', 5, 3, 'disponivel'),
('Lixadeira Orbital', 'Marcenaria', 4, 3, 'indisponivel'),
('Tupia Manual', 'Marcenaria', 2, 3, 'disponivel'),
('Arduino Uno', 'Robótica', 15, 4, 'disponivel'),
('Kit Servomotores', 'Robótica', 10, 4, 'indisponivel'),
('Raspberry Pi 4', 'Robótica', 6, 4, 'disponivel'),
('Chave de Fenda', 'Prototipagem', 20, 5, 'disponivel'),
('Micro Retífica', 'Prototipagem', 6, 5, 'disponivel'),
('Alicate de Corte', 'Eletrônica', 12, 1, 'disponivel'),
('Cortadora Laser CO2', 'Corte e Usinagem', 1, 6, 'disponivel'),
('Exaustor Industrial', 'Química', 2, 7, 'disponivel'),
('Módulo ESP32 Wi-Fi/Bluetooth', 'Eletrônica', 18, 8, 'disponivel');


-- ==========================================
-- 4. PROJETOS
-- ==========================================

INSERT INTO Projetos
(nome_projeto, descricao_projeto, duracao, arquivo_projeto, id_criador)
VALUES
(
 'Robô Seguidor de Linha',
 'Construção de um robô autônomo capaz de seguir trajetos utilizando sensores e programação.',
 10, NULL, 1
),
(
 'Impressão 3D de Miniaturas',
 'Desenvolvimento de miniaturas personalizadas utilizando modelagem e impressão tridimensional.',
 15, NULL, 2
),
(
 'Circuito Eletrônico Inteligente',
 'Criação de um circuito eletrônico utilizando Arduino, sensores e componentes eletrônicos.',
 20, NULL, 3
),
(
 'Móvel Sustentável',
 'Construção de um pequeno móvel utilizando madeira reaproveitada e ferramentas de marcenaria.',
 8, NULL, 4
),
(
 'Estação Meteorológica',
 'Desenvolvimento de uma estação meteorológica para monitoramento de temperatura e umidade.',
 30, NULL, 5
),
(
 'Sistema de Corte a Laser',
 'Criação de peças personalizadas utilizando equipamentos de corte e gravação a laser.',
 12, NULL, 6
),
(
 'Experimentos com Polímeros',
 'Estudo e desenvolvimento de materiais utilizando resinas, tintas e diferentes polímeros.',
 25, NULL, 7
),
(
 'Automação Residencial IoT',
 'Desenvolvimento de um sistema de automação residencial utilizando módulos Wi-Fi e sensores.',
 18, NULL, 8
),
(
 'Braço Robótico Automatizado',
 'Montagem e programação de um braço robótico utilizando motores e componentes eletrônicos.',
 40, NULL, 9
),
(
 'Mini Protótipo Mecânico',
 'Construção de um protótipo mecânico para testar soluções de engenharia e mecanismos.',
 5, NULL, 10
);


-- ==========================================
-- 5. PROJETOS_USUARIOS
-- ==========================================

INSERT INTO Projetos_Usuarios
(id_projeto, id_usuario)
VALUES
(1, 1),
(1, 2),

(2, 3),

(3, 1),
(3, 4),

(4, 5),

(5, 2),

(6, 6),
(6, 7),

(7, 8),

(8, 9),
(8, 10),

(9, 3),
(9, 6),

(10, 4);


-- ==========================================
-- 6. RESERVAS
-- ==========================================

INSERT INTO Reservas
(data_reserva, horas_reservadas, preco_total,
 id_usuario, id_bancada, id_projeto)
VALUES
('2026-11-02 09:00:00', 2, 50.00, 1, 1, 1),

('2026-11-03 14:00:00', 3, 105.00, 2, 2, 2),

('2026-11-04 10:00:00', 2, 60.00, 3, 3, 3),

('2026-11-05 13:00:00', 4, 112.00, 4, 5, 4),

('2026-11-06 08:00:00', 2, 50.00, 5, 1, 5),

('2026-11-07 11:00:00', 3, 135.00, 6, 6, 6),

('2026-11-08 15:00:00', 5, 160.00, 7, 7, 6),

('2026-11-09 09:30:00', 4, 152.00, 8, 8, 7),

('2026-11-10 14:00:00', 2, 70.00, 9, 2, 8),

('2026-11-11 10:00:00', 3, 90.00, 10, 3, 8),

('2026-11-12 16:00:00', 2, 90.00, 3, 6, 9),

('2026-11-13 08:30:00', 1, 28.00, 4, 5, 10);


-- ==========================================
-- FIM DA SEED
-- ==========================================
