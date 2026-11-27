-- SEED ElectroSafe
-- Execute depois de criar as tabelas e a VIEW do schema.
-- Preparado para banco vazio; os IDs são informados explicitamente.
-- Senha de teste de todos os usuários: password
-- A coluna senha recebe um hash bcrypt de teste, nunca texto puro.
USE ElectroSafe;


INSERT INTO enderecoCliente (id, cep, numero, rua, bairro, cidade, estado, complemento) VALUES
(1, '09010-100', '120', 'Rua das Flores', 'Centro', 'Santo André', 'SP', 'Casa'),
(2, '09020-200', '45', 'Avenida Brasil', 'Jardim', 'Santo André', 'SP', 'Apartamento 12'),
(3, '09110-300', '780', 'Rua dos Ipês', 'Vila Assunção', 'Santo André', 'SP', 'Bloco B'),
(4, '09210-400', '63', 'Rua São Pedro', 'Campestre', 'Santo André', 'SP', NULL),
(5, '09310-500', '215', 'Rua das Acácias', 'Utinga', 'Santo André', 'SP', 'Fundos'),
(6, '09410-600', '990', 'Avenida Industrial', 'Jardim', 'Santo André', 'SP', 'Sala 3'),
(7, '09510-700', '31', 'Rua do Comércio', 'Centro', 'São Bernardo do Campo', 'SP', 'Casa 2'),
(8, '09610-800', '402', 'Rua Paraná', 'Nova Petrópolis', 'São Bernardo do Campo', 'SP', NULL),
(9, '09710-900', '88', 'Rua Bahia', 'Rudge Ramos', 'São Bernardo do Campo', 'SP', 'Apartamento 21'),
(10, '09810-000', '150', 'Rua Minas Gerais', 'Baeta Neves', 'São Bernardo do Campo', 'SP', 'Casa');


INSERT INTO usuarios (id, nome, email, data_nascimento, senha, cpf, telefone) VALUES
(1, 'Ana Martins', 'ana.martins@example.com', '1995-03-14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000001', '11900000001'),
(2, 'Bruno Costa', 'bruno.costa@example.com', '1988-07-22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000002', '11900000002'),
(3, 'Camila Rocha', 'camila.rocha@example.com', '2000-11-09', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000003', '11900000003'),
(4, 'Diego Almeida', 'diego.almeida@example.com', '1992-01-30', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000004', '11900000004'),
(5, 'Eduarda Lima', 'eduarda.lima@example.com', '1998-05-18', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000005', '11900000005'),
(6, 'Felipe Santos', 'felipe.santos@example.com', '1985-09-02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000006', '11900000006'),
(7, 'Gabriela Souza', 'gabriela.souza@example.com', '2001-12-12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000007', '11900000007'),
(8, 'Heitor Ribeiro', 'heitor.ribeiro@example.com', '1990-04-25', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000008', '11900000008'),
(9, 'Isabela Ferreira', 'isabela.ferreira@example.com', '1997-08-16', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000009', '11900000009'),
(10, 'João Oliveira', 'joao.oliveira@example.com', '1993-06-05', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '00000000010', '11900000010'),
(11, 'Lucas Mendes', 'lucas.mendes@electrosafe.example', '1990-02-11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000001', '11910000001'),
(12, 'Mariana Alves', 'mariana.alves@electrosafe.example', '1994-06-19', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000002', '11910000002'),
(13, 'Nicolas Barros', 'nicolas.barros@electrosafe.example', '1987-10-03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000003', '11910000003'),
(14, 'Olivia Cardoso', 'olivia.cardoso@electrosafe.example', '1996-12-27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000004', '11910000004'),
(15, 'Pedro Teixeira', 'pedro.teixeira@electrosafe.example', '1989-04-08', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000005', '11910000005'),
(16, 'Rafaela Gomes', 'rafaela.gomes@electrosafe.example', '1992-08-14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000006', '11910000006'),
(17, 'Samuel Nunes', 'samuel.nunes@electrosafe.example', '1998-01-21', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000007', '11910000007'),
(18, 'Talita Freitas', 'talita.freitas@electrosafe.example', '1991-05-31', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000008', '11910000008'),
(19, 'Vitor Pires', 'vitor.pires@electrosafe.example', '1986-09-17', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000009', '11910000009'),
(20, 'Yasmin Carvalho', 'yasmin.carvalho@electrosafe.example', '1999-11-06', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '10000000010', '11910000010'),
(21, 'Alice Ribeiro', 'alice.ribeiro@electrosafe.example', '1982-02-10', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000001', '11920000001'),
(22, 'Breno Lopes', 'breno.lopes@electrosafe.example', '1980-07-15', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000002', '11920000002'),
(23, 'Cecilia Ramos', 'cecilia.ramos@electrosafe.example', '1985-03-28', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000003', '11920000003'),
(24, 'Davi Moreira', 'davi.moreira@electrosafe.example', '1979-11-04', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000004', '11920000004'),
(25, 'Elisa Fernandes', 'elisa.fernandes@electrosafe.example', '1988-05-20', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000005', '11920000005'),
(26, 'Fabio Batista', 'fabio.batista@electrosafe.example', '1983-09-12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000006', '11920000006'),
(27, 'Giovana Melo', 'giovana.melo@electrosafe.example', '1986-01-25', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000007', '11920000007'),
(28, 'Hugo Azevedo', 'hugo.azevedo@electrosafe.example', '1981-06-17', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000008', '11920000008'),
(29, 'Iris Monteiro', 'iris.monteiro@electrosafe.example', '1987-10-30', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000009', '11920000009'),
(30, 'Jonas Duarte', 'jonas.duarte@electrosafe.example', '1984-12-08', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', '20000000010', '11920000010');

INSERT INTO departamentos (id, numero, nome, dataCriacao) VALUES
(1, 101, 'Atendimento', '2025-01-10 09:00:00'),
(2, 102, 'Instalações', '2025-01-11 09:00:00'),
(3, 103, 'Manutenção', '2025-01-12 09:00:00'),
(4, 104, 'Iluminação', '2025-01-13 09:00:00'),
(5, 105, 'Segurança Elétrica', '2025-01-14 09:00:00'),
(6, 106, 'Vistorias', '2025-01-15 09:00:00'),
(7, 107, 'Orçamentos', '2025-01-16 09:00:00'),
(8, 108, 'Suporte Técnico', '2025-01-17 09:00:00'),
(9, 109, 'Projetos', '2025-01-18 09:00:00'),
(10, 110, 'Administração', '2025-01-19 09:00:00');

INSERT INTO clientes (idUsuario, idEndereco) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

INSERT INTO administrador (idUsuario, id_departamento) VALUES
(22, 1),
(23, 2),
(24, 3),
(25, 4),
(26, 5),
(27, 6),
(28, 7),
(29, 8),
(30, 9),
(21, 10);


INSERT INTO funcionarios (idUsuario, especializacao) VALUES
(11, 'Eletricista'),
(12, 'Iluminação'),
(13, 'Instalação'),
(14, 'Segurança'),
(15, 'Eletricista'),
(16, 'Manutenção'),
(17, 'Iluminação'),
(18, 'Instalação'),
(19, 'Segurança'),
(20, 'Manutenção');

INSERT INTO funcionario_departamentos (id, idFuncionario, idDepartamento) VALUES
(1, 11, 2),
(2, 12, 4),
(3, 13, 2),
(4, 14, 5),
(5, 15, 3),
(6, 16, 3),
(7, 17, 4),
(8, 18, 9),
(9, 19, 5),
(10, 20, 8);

INSERT INTO pedidos (id, idCliente, statusPedido, categoria, descricao) VALUES
(1, 1, 'AGUARDANDO', 'TOMADA', 'Verificar tomada que apresenta mau contato.'),
(2, 2, 'ANDAMENTO', 'ILUMINACAO', 'Avaliar instalação de iluminação na sala.'),
(3, 3, 'FINALIZADO', 'DISJUNTOR', 'Inspecionar o disjuntor do quadro elétrico.'),
(4, 4, 'AGUARDANDO', 'INSTALACAO', 'Solicitação de instalação elétrica em um cômodo.'),
(5, 5, 'CANCELADO', 'TOMADA', 'Pedido cancelado pelo cliente.'),
(6, 6, 'ANDAMENTO', 'ILUMINACAO', 'Substituição de pontos de iluminação.'),
(7, 7, 'AGUARDANDO', 'DISJUNTOR', 'Verificar o dimensionamento do disjuntor.'),
(8, 8, 'FINALIZADO', 'INSTALACAO', 'Instalação de novo ponto elétrico concluída.'),
(9, 9, 'ANDAMENTO', 'TOMADA', 'Avaliar necessidade de novo ponto de tomada.'),
(10, 10, 'AGUARDANDO', 'INSTALACAO', 'Solicitação de vistoria da instalação elétrica.');

INSERT INTO registros (id, idUsuario, descricao, status_registro, data_ocorrencia, idDepartamento, impacto_erro, norma_violada, origem_desvio, acao_imediata, responsavel_Imediato, prazo, analise_erro, acao_corretiva, responsavel_acaoFinal, prazo_limite, data_verificacao, eficacia, obs_fechamento) VALUES
(1, 1, 'Tomada identificada com aquecimento acima do esperado.', 'AGUARDANDO', '2025-02-01 08:30:00', 1, 'MODERADO', 'ABNT NBR 5410', 'Conexão elétrica inadequada', 'Solicitar avaliação técnica e isolar o ponto para inspeção.', 11, '2025-02-02 17:00:00', 'Verificar aperto dos terminais e dimensionamento do circuito.', 'Corrigir conexão e substituir componentes inadequados, se necessário.', 21, '2025-02-05 17:00:00', NULL, NULL, NULL),
(2, 2, 'Iluminação apresentou funcionamento intermitente.', 'ANDAMENTO', '2025-02-02 10:15:00', 2, 'LEVE', 'ABNT NBR 5410', 'Possível falha de conexão', 'Encaminhar solicitação para inspeção do circuito.', 12, '2025-02-03 17:00:00', 'Inspecionar conexões, interruptor e alimentação.', 'Reparar a conexão ou substituir o componente defeituoso.', 22, '2025-02-06 17:00:00', NULL, NULL, NULL),
(3, 3, 'Disjuntor necessita de avaliação após desarme recorrente.', 'ANDAMENTO', '2025-02-03 14:20:00', 3, 'CRITICO', 'ABNT NBR 5410', 'Possível sobrecarga no circuito', 'Encaminhar para avaliação de profissional habilitado.', 13, '2025-02-04 17:00:00', 'Analisar carga instalada e características da proteção.', 'Adequar o circuito e a proteção conforme projeto e norma aplicável.', 23, '2025-02-07 17:00:00', NULL, NULL, NULL),
(4, 4, 'Foi relatada ausência de identificação no quadro elétrico.', 'AGUARDANDO', '2025-02-04 09:00:00', 4, 'LEVE', 'ABNT NBR 5410', 'Identificação incompleta', 'Registrar a ocorrência e solicitar vistoria.', 14, '2025-02-05 17:00:00', 'Conferir os circuitos e a documentação disponível.', 'Atualizar a identificação do quadro e os registros técnicos.', 24, '2025-02-08 17:00:00', NULL, NULL, NULL),
(5, 5, 'Foi observada divergência entre instalação e documentação.', 'FINALIZADO', '2025-02-05 11:40:00', 5, 'MODERADO', 'ABNT NBR 5410', 'Documentação desatualizada', 'Solicitar conferência do projeto e da instalação.', 15, '2025-02-06 17:00:00', 'Comparar os pontos instalados com o projeto aprovado.', 'Atualizar a documentação técnica após validação.', 25, '2025-02-09 17:00:00', '2025-02-13 15:00:00', 'SIM', 'Documentação revisada e validada.'),
(6, 6, 'Ponto de iluminação apresentou falha após manutenção.', 'AGUARDANDO', '2025-02-06 16:10:00', 6, 'LEVE', 'ABNT NBR 5410', 'Componente possivelmente danificado', 'Abrir solicitação de inspeção do ponto.', 16, '2025-02-07 17:00:00', 'Verificar componente, conexões e alimentação.', 'Substituir componente defeituoso após diagnóstico.', 26, '2025-02-10 17:00:00', NULL, NULL, NULL),
(7, 7, 'Foi identificada necessidade de revisão de proteção elétrica.', 'ANDAMENTO', '2025-02-07 13:25:00', 7, 'CRITICO', 'ABNT NBR 5410', 'Possível incompatibilidade da proteção', 'Encaminhar para análise técnica prioritária.', 17, '2025-02-08 17:00:00', 'Verificar corrente de projeto, condutores e dispositivo de proteção.', 'Adequar a proteção após avaliação técnica.', 27, '2025-02-11 17:00:00', NULL, NULL, NULL),
(8, 8, 'Solicitação de revisão de instalação em área de serviço.', 'FINALIZADO', '2025-02-08 08:50:00', 8, 'MODERADO', 'ABNT NBR 5410', 'Instalação antiga', 'Agendar vistoria técnica no local.', 18, '2025-02-09 17:00:00', 'Avaliar condições dos circuitos e dos pontos de utilização.', 'Executar adequações indicadas no relatório técnico.', 28, '2025-02-12 17:00:00', '2025-02-19 14:30:00', 'SIM', 'Adequações verificadas em vistoria.'),
(9, 9, 'Foi relatado mau contato em ponto de tomada.', 'CANCELADO', '2025-02-09 12:05:00', 9, 'LEVE', 'ABNT NBR 5410', 'Desgaste do componente', 'Registrar solicitação para avaliação.', 19, '2025-02-10 17:00:00', 'Verificar estado do componente e das conexões.', 'Substituir o componente caso a falha seja confirmada.', 29, '2025-02-13 17:00:00', NULL, NULL, 'Registro cancelado para fins de teste.'),
(10, 10, 'Foi solicitada avaliação preventiva da instalação.', 'AGUARDANDO', '2025-02-10 09:35:00', 10, 'MODERADO', 'ABNT NBR 5410', 'Ausência de inspeção periódica', 'Encaminhar solicitação ao suporte técnico.', 20, '2025-02-11 17:00:00', 'Levantar condições gerais da instalação e pontos críticos.', 'Elaborar plano de adequação conforme resultado da inspeção.', 30, '2025-02-14 17:00:00', NULL, NULL, NULL);

INSERT INTO analise_tecnica (cliente_analise, servicos, relatoProblema) VALUES
(1, 'AVALIAÇÃO', 'Cliente solicita avaliação de tomadas e pontos de energia.'),
(2, 'MANUTENÇÃO', 'Cliente relata falhas intermitentes na iluminação.'),
(3, 'CONSERTO', 'Cliente solicita análise de disjuntor com desarme recorrente.'),
(4, 'MONTAGEM', 'Cliente solicita montagem de pontos elétricos em um cômodo.'),
(5, 'MODIFICAÇÃO', 'Cliente deseja reorganizar pontos de iluminação.'),
(6, 'AVALIAÇÃO', 'Cliente solicita avaliação preventiva do quadro elétrico.'),
(7, 'MANUTENÇÃO', 'Cliente relata necessidade de manutenção em circuito de iluminação.'),
(8, 'CONSERTO', 'Cliente solicita avaliação de tomada com mau contato.'),
(9, 'MONTAGEM', 'Cliente solicita instalação de novos pontos de energia.'),
(10, 'MODIFICAÇÃO', 'Cliente solicita análise para modificação da instalação existente.');

-- Conferência das quantidades inseridas.
-- Esperado: 10 em cada tabela, exceto usuarios (30).
SELECT 'enderecoCliente' AS tabela, COUNT(*) AS quantidade FROM enderecoCliente
UNION ALL SELECT 'usuarios', COUNT(*) FROM usuarios
UNION ALL SELECT 'clientes', COUNT(*) FROM clientes
UNION ALL SELECT 'funcionarios', COUNT(*) FROM funcionarios
UNION ALL SELECT 'departamentos', COUNT(*) FROM departamentos
UNION ALL SELECT 'administrador', COUNT(*) FROM administrador
UNION ALL SELECT 'funcionario_departamentos', COUNT(*) FROM funcionario_departamentos
UNION ALL SELECT 'pedidos', COUNT(*) FROM pedidos
UNION ALL SELECT 'registros', COUNT(*) FROM registros
UNION ALL SELECT 'analise_tecnica', COUNT(*) FROM analise_tecnica;
