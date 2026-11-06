-- seed
USE PetConnect;

-- =========================================
-- 1. TABELA: USUARIOS
-- =========================================

INSERT INTO usuarios
(id_usuario, nome, email, senha, data_nascimento, telefone, cidade, estado)
VALUES
(1, 'Ana Souza', 'ana.souza@email.com', 'hash_demo_001', '1996-02-14', '41999991001', 'Curitiba', 'PR'),
(2, 'Bruno Lima', 'bruno.lima@email.com', 'hash_demo_002', '1994-05-20', '48999991002', 'Florianopolis', 'SC'),
(3, 'Carla Mendes', 'carla.mendes@email.com', 'hash_demo_003', '1998-08-11', '51999991003', 'Porto Alegre', 'RS'),
(4, 'Diego Alves', 'diego.alves@email.com', 'hash_demo_004', '1995-03-25', '19999991004', 'Campinas', 'SP'),
(5, 'Elisa Rocha', 'elisa.rocha@email.com', 'hash_demo_005', '1997-11-09', '21999991005', 'Rio de Janeiro', 'RJ'),
(6, 'Fabio Costa', 'fabio.costa@email.com', 'hash_demo_006', '1993-07-16', '31999991006', 'Belo Horizonte', 'MG'),
(7, 'Gabriela Nunes', 'gabriela.nunes@email.com', 'hash_demo_007', '1999-01-30', '27999991007', 'Vitoria', 'ES'),
(8, 'Hugo Martins', 'hugo.martins@email.com', 'hash_demo_008', '1992-09-05', '62999991008', 'Goiania', 'GO'),
(9, 'Isabela Freitas', 'isabela.freitas@email.com', 'hash_demo_009', '2000-04-18', '71999991009', 'Salvador', 'BA'),
(10, 'Joao Pereira', 'joao.pereira@email.com', 'hash_demo_010', '1991-12-22', '81999991010', 'Recife', 'PE');


-- =========================================
-- 2. TABELA: ANIMAIS
-- =========================================

INSERT INTO animais
(id_animal, nome, especie, idade, sexo, porte, cidade, estado, raca,
 situacao_animal, status_animal, url_imagem)
VALUES
(1, 'Thor', 'CACHORRO', 3, 'MACHO', 'MEDIO', 'Curitiba', 'PR',
 'Labrador', 'Cachorro resgatado, vacinado e muito brincalhao.', 'DISPONIVEL',
 'https://example.com/imagens/thor.jpg'),

(2, 'Mimi', 'GATO', 2, 'FEMEA', 'PEQUENO', 'Florianopolis', 'SC',
 'Siamês', 'Gata tranquila, carinhosa e acostumada com pessoas.', 'EM_PROCESSO',
 'https://example.com/imagens/mimi.jpg'),

(3, 'Nina', 'CACHORRO', 4, 'FEMEA', 'PEQUENO', 'Porto Alegre', 'RS',
 'SRD', 'Cachorra resgatada, sociavel e com vacinas em dia.', 'ADOTADO',
 'https://example.com/imagens/nina.jpg'),

(4, 'Rex', 'CACHORRO', 5, 'MACHO', 'GRANDE', 'Campinas', 'SP',
 'Beagle', 'Animal ativo, gosta de passeios e ambientes abertos.', 'DISPONIVEL',
 'https://example.com/imagens/rex.jpg'),

(5, 'Luna', 'GATO', 1, 'FEMEA', 'PEQUENO', 'Rio de Janeiro', 'RJ',
 'Persa', 'Gata filhote, precisa de uma familia amorosa.', 'EM_PROCESSO',
 'https://example.com/imagens/luna.jpg'),

(6, 'Mel', 'CACHORRO', 6, 'FEMEA', 'MEDIO', 'Belo Horizonte', 'MG',
 'Poodle', 'Cachorra calma, adestrada e acostumada com crianças.', 'ADOTADO',
 'https://example.com/imagens/mel.jpg'),

(7, 'Bob', 'CACHORRO', 2, 'MACHO', 'MEDIO', 'Vitoria', 'ES',
 'SRD', 'Cachorro brincalhao, saudavel e bastante companheiro.', 'DISPONIVEL',
 'https://example.com/imagens/bob.jpg'),

(8, 'Amora', 'GATO', 3, 'FEMEA', 'PEQUENO', 'Goiania', 'GO',
 'Shih-Tzu', 'Animal dócil, precisa de um lar seguro e acolhedor.', 'EM_PROCESSO',
 'https://example.com/imagens/amora.jpg'),

(9, 'Max', 'CACHORRO', 4, 'MACHO', 'GRANDE', 'Salvador', 'BA',
 'Pitbull', 'Cachorro sociavel, brincalhao e bem cuidado.', 'ADOTADO',
 'https://example.com/imagens/max.jpg'),

(10, 'Toby', 'CACHORRO', 1, 'MACHO', 'PEQUENO', 'Recife', 'PE',
 'Bulldog', 'Filhote ativo, vacinado e pronto para encontrar uma familia.', 'DISPONIVEL',
 'https://example.com/imagens/toby.jpg');


-- =========================================
-- 3. TABELA: SOLICITACOES_ADOCAO
-- =========================================

INSERT INTO solicitacoes_adocao
(id_solicitacao, id_usuario, id_animal, status, observacoes)
VALUES
(1, 1, 1, 'RECUSADO', 'Solicitacao nao aprovada pela equipe responsavel.'),
(2, 2, 2, 'EM_ANALISE', 'Aguardando avaliacao do perfil do interessado.'),
(3, 3, 3, 'APROVADO', 'Adocao aprovada e finalizada com sucesso.'),
(4, 4, 4, 'CANCELADA', 'Usuario decidiu cancelar a solicitacao.'),
(5, 5, 5, 'EM_ANALISE', 'Documentacao enviada e aguardando verificacao.'),
(6, 6, 6, 'APROVADO', 'Adocao aprovada apos entrevista.'),
(7, 7, 7, 'RECUSADO', 'Perfil nao atendeu aos criterios de adocao.'),
(8, 8, 8, 'EM_ANALISE', 'Aguardando contato da equipe de adocao.'),
(9, 9, 9, 'APROVADO', 'Processo de adocao concluido.'),
(10, 10, 10, 'CANCELADA', 'Solicitacao cancelada pelo usuario.');


-- =========================================
-- 4. TABELA: FAVORITOS
-- =========================================

INSERT INTO favoritos
(id_usuario, id_animal)
VALUES
(1, 2),
(2, 1),
(3, 4),
(4, 5),
(5, 7),
(6, 8),
(7, 10),
(8, 1),
(9, 2),
(10, 4);


-- =========================================
-- 5. TABELA: PRODUTOS
-- =========================================

INSERT INTO produtos
(id_produto, nome, categoria, preco, estoque, especie_indicada)
VALUES
(1, 'Guia Ajustavel', 'UTILITARIO', 39.90, 50, 'CACHORRO'),
(2, 'Cama Pet', 'UTILITARIO', 129.90, 20, 'TODOS'),
(3, 'Bola Interativa', 'BRINQUEDO', 19.90, 100, 'CACHORRO'),
(4, 'Petisco Natural', 'PETISCO', 14.50, 80, 'TODOS'),
(5, 'Caixa Transporte', 'UTILITARIO', 89.90, 15, 'GATO'),
(6, 'Arranhador', 'BRINQUEDO', 119.90, 25, 'GATO'),
(7, 'Comedouro', 'UTILITARIO', 29.90, 60, 'TODOS'),
(8, 'Corda Mordedora', 'BRINQUEDO', 24.90, 45, 'CACHORRO'),
(9, 'Shampoo Neutro', 'UTILITARIO', 32.00, 35, 'TODOS'),
(10, 'Racao Umida', 'PETISCO', 8.90, 120, 'GATO');


-- =========================================
-- 6. TABELA: PEDIDOS
-- =========================================

INSERT INTO pedidos
(id_pedido, id_usuario, valor_total, status)
VALUES
(1, 1, 39.90, 'PAGO'),
(2, 2, 129.90, 'ENVIADO'),
(3, 3, 39.80, 'ENTREGUE'),
(4, 4, 29.00, 'CANCELADO'),
(5, 5, 119.80, 'PAGO'),
(6, 6, 119.90, 'ENVIADO'),
(7, 7, 49.80, 'ENTREGUE'),
(8, 8, 46.50, 'PAGO'),
(9, 9, 44.50, 'AGUARDANDO_PAGAMENTO'),
(10, 10, 59.80, 'PAGO');


-- =========================================
-- 7. TABELA: ITENS_PEDIDOS
-- =========================================

INSERT INTO itens_pedidos
(id_itens, id_pedido, id_produto, quantidade)
VALUES
(1, 1, 1, 1),

(2, 2, 2, 1),

(3, 3, 3, 2),

(4, 4, 4, 2),

(5, 5, 5, 1),
(6, 5, 7, 1),

(7, 6, 6, 1),

(8, 7, 8, 2),

(9, 8, 9, 1),
(10, 8, 4, 1),

(11, 9, 10, 5),

(12, 10, 1, 1),
(13, 10, 3, 1);