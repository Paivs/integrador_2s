use SOLARCONTROL;

-- seed.sql


USE SOLARCONTROL;

-- =========================================
-- 1. TABELA DE ENDERECOS
-- =========================================

INSERT INTO enderecos
(CEP, estado, cidade, logradouro, numero)
VALUES
('01001000', 'SP', 'Sao Paulo', 'Rua das Flores', '100'),
('20040002', 'RJ', 'Rio de Janeiro', 'Rua do Sol', '250'),
('30140071', 'MG', 'Belo Horizonte', 'Av. Brasil', '350'),
('80010000', 'PR', 'Curitiba', 'Rua Central', '45'),
('40020000', 'BA', 'Salvador', 'Av. Bahia', '120');


-- =========================================
-- 2. TABELA DE USUARIOS
-- =========================================

INSERT INTO usuarios
(nome, email, senha, id_endereco, TIPO)
VALUES
('Joao Silva', 'joao@email.com', '123456', 1, 'cliente'),
('Maria Oliveira', 'maria@email.com', '123456', 2, 'cliente'),
('Carlos Souza', 'carlos@email.com', '123456', 3, 'funcionario'),
('Ana Santos', 'ana@email.com', '123456', 4, 'adm'),
('Pedro Costa', 'pedro@email.com', '123456', 5, 'cliente');


-- =========================================
-- 3. TABELA DE SISTEMAS FOTOVOLTAICOS
-- =========================================

INSERT INTO fotovoltaicos
(ID_USUARIO, modelo_painel, data_intalacao, status_sistema)
VALUES
(1, 'Canadian Solar 550W', '2024-01-15', 'Ativo'),
(2, 'Jinko Solar 450W', '2023-08-20', 'Ativo'),
(3, 'Longi Solar 500W', '2024-03-10', 'Manutencao'),
(4, 'Trina Solar 600W', '2022-11-05', 'Ativo'),
(5, 'JA Solar 540W', '2025-02-18', 'Inativo');


-- =========================================
-- 4. TABELA DE REGISTRO DE ENERGIA E CONSUMO
-- =========================================

INSERT INTO registros
(ID_fotovoltaicos, data_registro, energia_gerada, energia_consumida)
VALUES
(1, '2026-10-01', 450, 320),
(2, '2026-10-02', 380, 290),
(3, '2026-10-03', 510, 400),
(4, '2026-10-04', 620, 450),
(5, '2026-10-05', 300, 350);


-- =========================================
-- 5. TABELA DE MANUTENCAO E INSTALACAO
-- =========================================

INSERT INTO manutencao_e_instalacao
(ID_SISTEMAS, data_agendada, tempo_estimado,
 qualidade_sistema, previsao_da_proxima_manutencao)
VALUES
(1, '2026-11-10', '3 horas', 'Excelente', '2027-05-10'),
(2, '2026-11-12', '4 horas', 'Boa', '2027-05-12'),
(3, '2026-11-15', '5 horas', 'Regular', '2027-05-15'),
(4, '2026-11-18', '2 horas', 'Excelente', '2027-05-18'),
(5, '2026-11-20', '6 horas', 'Ruim', '2027-05-20');