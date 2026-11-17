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

-- Cliente e carro fictícios solicitados pelo grupo.
INSERT INTO clientes (nome, telefone, email)
SELECT 'Lucas Andrade Silva', '(11) 99999-0000', 'lucas.exemplo@carcare.local'
WHERE NOT EXISTS (
    SELECT id FROM clientes WHERE email = 'lucas.exemplo@carcare.local'
);

INSERT INTO veiculos (cliente_id, placa, marca, modelo, ano, quilometragem)
SELECT clientes.id, 'BRA2E19', 'Volkswagen', 'Gol 1.6 MSI', 2020, 45820
FROM clientes
WHERE clientes.email = 'lucas.exemplo@carcare.local'
  AND NOT EXISTS (SELECT id FROM veiculos WHERE placa = 'BRA2E19')
LIMIT 1;

-- Serviços iniciais para o cliente conseguir fazer uma solicitação.
INSERT INTO servicos (nome, descricao, valor)
SELECT 'Troca de óleo', 'Troca do óleo e verificação do filtro', 180.00
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Troca de óleo');

INSERT INTO servicos (nome, descricao, valor)
SELECT 'Revisão preventiva', 'Verificação geral dos itens principais do veículo', 250.00
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Revisão preventiva');

INSERT INTO servicos (nome, descricao, valor)
SELECT 'Alinhamento e balanceamento', 'Ajuste de direção e balanceamento das rodas', 160.00
<<<<<<< HEAD
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Alinhamento e balanceamento');
=======
WHERE NOT EXISTS (SELECT id FROM servicos WHERE nome = 'Alinhamento e balanceamento');
>>>>>>> ec1d8616acc96e7f5ac3933493762a9f21ea8044

CREATE TABLE codigos_falha (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(10) NOT NULL,
  componente VARCHAR(150) NOT NULL,
  descricao_falha VARCHAR(150) NOT NULL
);

CREATE TABLE veiculo_diagnosticos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  veiculo_id INT NOT NULL,
  codigo_falha_id INT NOT NULL,
  funcionario_id INT NULL,
  situacao VARCHAR(30) NOT NULL DEFAULT 'Com problema',
  atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_veiculo_codigo (veiculo_id, codigo_falha_id),
  FOREIGN KEY (veiculo_id) REFERENCES veiculos(id) ON DELETE CASCADE,
  FOREIGN KEY (codigo_falha_id) REFERENCES codigos_falha(id) ON DELETE CASCADE
);

INSERT INTO codigos_falha (codigo, componente, descricao_falha) VALUES
('12', 'Sensor de rotação e PMS', 'Sem sinal'),
('13', 'Sonda lambda', 'Circuito aberto'),
('14', 'Sensor de temperatura da água', 'Baixa tensão'),
('15', 'Sensor de temperatura da água', 'Alta tensão'),
('16', 'Sensor de detonação', 'Sem sinal'),
('17', 'Eletroinjetor de combustível', 'Falha no circuito'),
('18', 'Sensor de detonação', 'Sem regulagem do sinal'),
('19', 'Sensor de rotação e PMS', 'Sinal incorreto'),
('21', 'Sensor de posição da borboleta', 'Alta tensão'),
('22', 'Sensor de posição da borboleta', 'Baixa tensão'),
('24', 'Sensor de velocidade', 'Sem sinal'),
('25', 'Eletroinjetores', 'Alta tensão'),
('26', 'Eletroinjetor 2', 'Alta tensão'),
('27', 'Eletroinjetor 3', 'Alta tensão'),
('28', 'Eletroinjetor 4 / Relé da bomba', 'Alta tensão / Mau contato'),
('29', 'Relé da bomba de combustível / Eletroinjetor 5', 'Baixa tensão / Alta tensão'),
('31', 'Motor de passo / Válvula EGR', 'Sem sinal / Falha no gerenciamento de vácuo'),
('32', 'Relé da bomba de combustível / Eletroinjetor 6', 'Alta tensão'),
('33', 'Sensor de pressão absoluta / Eletroválvula EGR', 'Alta tensão / Baixa tensão'),
('34', 'Sensor de pressão absoluta / Eletroválvula EGR', 'Baixa tensão / Alta tensão'),
('35', 'Corretor de marcha lenta / Relé de partida a frio', 'Falha / Baixa tensão'),
('37', 'Relé de partida a frio', 'Alta tensão'),
('38', 'Sonda lambda', 'Baixa tensão'),
('39', 'Sonda lambda', 'Alta tensão'),
('41', 'Bobina de ignição (cilindros 2 e 3)', 'Alta tensão no comando'),
('42', 'Bobina de ignição (cilindros 1 e 4) / Controle do avanço de ignição', 'Alta tensão / Falha no controle');