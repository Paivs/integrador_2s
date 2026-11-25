INSERT INTO usuarios (nome, email, senha, telefone) VALUES
('Luiza', 'luizamagalhaes@gmail.com', '12345678', '11987654321'),
('Rafael Costa', 'rafael.costa@email.com', 'senha456', '11991223344'),
('Mariana Alves', 'mariana.alves@email.com', 'senha789', '11988776655');

INSERT INTO tb_categorias (nome, descricao) VALUES 
('Sobremesas', 'Doces artesanais, bolos e tortas da casa'),
('Salgados', 'Empadas, coxinhas e quiches assados na hora'),
('Bebidas', 'Cafés especiais, sucos naturais e chás gelados');


INSERT INTO tb_produtos (nome_item, preco, tag_selo, descricao_delicada, imagem_url) VALUES
('Bolo de Chocolate', 18.50, 'Mais pedido', 'Massa fofinha com cobertura cremosa de chocolate meio amargo', 'https://exemplo.com/bolo-chocolate.jpg'),
('Coxinha de Frango com Requeijão', 9.50, 'Novidade', 'Massa crocante por fora e recheio cremoso bem temperado', 'https://exemplo.com/coxinha-frango.jpg'),
('Cappuccino Cremoso', 12.00, 'Clássico', 'Espresso encorpado com leite vaporizado e toque de canela', 'https://exemplo.com/cappuccino.jpg');

INSERT INTO tb_pedidos (codigo_encomenda, id_usuario, valor_total, status_pedido, previsao_entrega, tipo_entrega, data_pedido) VALUES
('ENC-001', 18.50, 'Confirmado', '2026-11-25 15:00:00', 'Entrega', '2026-11-25 14:00:00'),
('ENC-002', 19.00, 'Em preparo', '2026-11-25 15:30:00', 'Retirada', '2026-11-25 14:15:00'),
('ENC-003', 24.00, 'Entregue', '2026-11-25 13:45:00', 'Entrega', '2026-11-25 13:00:00');


INSERT INTO tb_itens_pedido (id_pedido, id_produto, quantidade, preco_unitario, subtotal) VALUES
(1, 18.50, 18.50),
(2, 9.50, 19.00),
(2, 12.00, 24.00);


INSERT INTO tb_reservas (id_usuario, qntd_de_mesas, qntd_pessoas, data_reserva, hora_reserva, status_reserva, observacoes) VALUES
(1, 4, '2026-11-26', '18:30:00', 'Reservado', 'Mesa perto da janela'),
(1, 2, '2026-11-26', '17:00:00', 'Confirmada', 'Preferência por mesa tranquila'),
(2, 6, '2026-11-27', '19:15:00', 'Pendente', 'Aniversário em família');

INSERT INTO tb_vendas (qntd_de_mesas, id_usuario, id_pedido, valor_pedido, status_do_pedido, id_reserva, data_venda) VALUES
(1, 18.50, 'Finalizado', '2026-11-25 14:30:00'),
(1, 19.00, 'Pago', '2026-11-25 14:20:00'),
(2, 24.00, 'Finalizado', '2026-11-25 13:50:00');