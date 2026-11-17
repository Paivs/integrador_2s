
CREATE DATABASE IF NOT EXISTS carcare
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE carcare;

-- Contas usadas para entrar no sistema.
CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados dos clientes/proprietários.
CREATE TABLE IF NOT EXISTS clientes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NULL UNIQUE,
    nome VARCHAR(120) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(190),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Dados dos funcionários que atendem os clientes.
CREATE TABLE IF NOT EXISTS funcionarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NULL UNIQUE,
    nome VARCHAR(120) NOT NULL,
    cargo VARCHAR(50),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Veículos pertencem a um cliente.
CREATE TABLE IF NOT EXISTS veiculos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT UNSIGNED NOT NULL,
    placa VARCHAR(7) NOT NULL UNIQUE,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(120) NOT NULL,
    ano INT NOT NULL,
    quilometragem INT NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Catálogo de serviços oferecidos pela oficina.
CREATE TABLE IF NOT EXISTS servicos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    descricao VARCHAR(255),
    valor DECIMAL(10,2) NOT NULL DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 1
);

-- Catálogo de peças.
CREATE TABLE IF NOT EXISTS pecas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    valor DECIMAL(10,2) NOT NULL DEFAULT 0,
    estoque INT NOT NULL DEFAULT 0
);

-- O cliente cria a solicitação e o funcionário controla o andamento.
CREATE TABLE IF NOT EXISTS manutencoes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    veiculo_id INT UNSIGNED NOT NULL,
    funcionario_id INT UNSIGNED NULL,
    servico_id INT UNSIGNED NULL,
    data_agendamento DATETIME NOT NULL,
    data_conclusao DATETIME NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Solicitado',
    descricao VARCHAR(390) NOT NULL,
    quilometragem INT NOT NULL DEFAULT 0,
    observacoes TEXT,
    proxima_manutencao_data DATE NULL,
    proxima_manutencao_km INT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (veiculo_id) REFERENCES veiculos(id) ON DELETE CASCADE,
    FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id) ON DELETE SET NULL,
    FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE SET NULL
);

-- Peças utilizadas em cada manutenção.
CREATE TABLE IF NOT EXISTS manutencao_pecas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    manutencao_id INT UNSIGNED NOT NULL,
    peca_id INT UNSIGNED NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    FOREIGN KEY (manutencao_id) REFERENCES manutencoes(id) ON DELETE CASCADE,
    FOREIGN KEY (peca_id) REFERENCES pecas(id)
);

-- Cliente fictício 
INSERT INTO clientes (nome, telefone, email)
SELECT 'Lucas Andrade Silva', '(11) 99999-0000', 'lucas.exemplo@carcare.local'
WHERE NOT EXISTS (
    SELECT id FROM clientes WHERE email = 'lucas.exemplo@carcare.local'
);

-- Retirar o carro de exemplo de bancos antigos
DELETE veiculos
FROM veiculos
INNER JOIN clientes ON clientes.id = veiculos.cliente_id
WHERE veiculos.placa = 'BRA2E19'
  AND veiculos.marca = 'Volkswagen'
  AND veiculos.modelo = 'Gol 1.6 MSI'
  AND veiculos.ano = 2020
  AND veiculos.quilometragem = 45820
  AND clientes.email = 'lucas.exemplo@carcare.local'
  AND clientes.usuario_id IS NULL
  AND NOT EXISTS (
      SELECT 1 FROM manutencoes WHERE manutencoes.veiculo_id = veiculos.id
  );

-- Serviços iniciais para o cliente conseguir fazer uma solicitação.
INSERT INTO servicos (nome, descricao, valor)
SELECT 'Troca de óleo', 'Troca do óleo e verificação do filtro', 180.00
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Troca de óleo');

INSERT INTO servicos (nome, descricao, valor)
SELECT 'Revisão preventiva', 'Verificação geral dos itens principais do veículo', 250.00
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Revisão preventiva');

INSERT INTO servicos (nome, descricao, valor)
SELECT 'Alinhamento e balanceamento', 'Ajuste de direção e balanceamento das rodas', 160.00
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Alinhamento e balanceamento');
