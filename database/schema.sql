CREATE TABLE IF NOT EXISTS exemplos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(120) NOT NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

USE db_lanchonete_doce_encontro;
CREATE DATABASE IF NOT EXISTS db_lanchonete_doce_encontro;

CREATE TABLE tb_usuarios (
    id_usuario INT(10) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NULL,
    PRIMARY KEY (id_usuario)
);

CREATE TABLE tb_categorias (
    id_categoria INT(10) NOT NULL AUTO_INCREMENT,
    nome_categoria VARCHAR(50) NOT NULL,
    descricao TEXT NULL,
    PRIMARY KEY (id_categoria)
);

CREATE TABLE tb_produtos (
    id_produto INT(10) NOT NULL AUTO_INCREMENT,
    id_categoria INT(10) NOT NULL,
    nome_item VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    tag_selo VARCHAR(50) NULL,
    descricao_delicada TEXT NULL,
    imagem_url VARCHAR(255) NULL,
    PRIMARY KEY (id_produto),
    FOREIGN KEY (id_categoria) REFERENCES tb_categorias(id_categoria)
);

CREATE TABLE tb_pedidos (
    id_pedido INT(10) NOT NULL AUTO_INCREMENT,
    codigo_encomenda VARCHAR(20) NOT NULL,
    id_usuario INT(10) NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    status_pedido VARCHAR(30) NOT NULL,
    previsao_entrega VARCHAR(50) NULL,
    tipo_entrega VARCHAR(30) NULL,
    data_pedido DATETIME NOT NULL,
    PRIMARY KEY (id_pedido),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario)
);

CREATE TABLE tb_itens_pedido (
    id_item_pedido INT(10) NOT NULL AUTO_INCREMENT,
    id_pedido INT(10) NOT NULL,
    id_produto INT(10) NOT NULL,
    quantidade INT(5) NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_item_pedido),
    FOREIGN KEY (id_pedido) REFERENCES tb_pedidos(id_pedido),
    FOREIGN KEY (id_produto) REFERENCES tb_produtos(id_produto)
);

CREATE TABLE tb_reservas (
    id_reserva INT(10) NOT NULL AUTO_INCREMENT,
    id_usuario INT(10) NOT NULL,
    qntd_de_mesas INT(2) NULL,
    qntd_pessoas INT(3) NOT NULL,
    data_reserva DATE NOT NULL,
    hora_reserva TIME NOT NULL,
    status_reserva VARCHAR(20) NOT NULL,
    observacoes TEXT NULL,
    PRIMARY KEY (id_reserva),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario)
);

CREATE TABLE tb_vendas (
    id_venda INT(10) NOT NULL AUTO_INCREMENT,
    qntd_de_mesas INT(2) NULL,
    id_usuario INT(10) NOT NULL,
    id_pedido INT(10) NOT NULL,
    valor_pedido DECIMAL(10,2) NOT NULL,
    status_do_pedido VARCHAR(30) NOT NULL,
    id_reserva INT(10) NULL,
    data_venda DATETIME NOT NULL,
    PRIMARY KEY (id_venda),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario),
    FOREIGN KEY (id_pedido) REFERENCES tb_pedidos(id_pedido),
    FOREIGN KEY (id_reserva) REFERENCES tb_reservas(id_reserva)
); 