CREATE DATABASE IF NOT EXISTS EnergyMonitor;
USE EnergyMonitor;

SET NAMES utf8mb4;


CREATE TABLE usuarios (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
senha VARCHAR(255) NOT NULL,
cargo VARCHAR(50) DEFAULT 'Gerente',
criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
empresa VARCHAR (100) NOT NULL
);


CREATE TABLE setor (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
descricao VARCHAR (300),
empresa_setor VARCHAR (100) NOT NULL,
criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
estado_setor VARCHAR (50) DEFAULT 'Ativo'
);


CREATE TABLE ambientes (
id INT AUTO_INCREMENT PRIMARY KEY,
setor_id INT NOT NULL,
nome VARCHAR(100) NOT NULL,
andar VARCHAR(20) NOT NULL,
empresa_ambiente VARCHAR(100) NOT NULL,
area_m2 DECIMAL(10,2) NOT NULL DEFAULT 0,
qtd_equipamentos INT DEFAULT 0,
tempo_uso_medio_diario TIME NOT NULL,
estado_medidor VARCHAR(30) DEFAULT 'ATIVO',
codigo_medidor VARCHAR(50) NOT NULL UNIQUE,
CONSTRAINT fk_ambiente_setor FOREIGN KEY (setor_id) REFERENCES setor(id) ON DELETE CASCADE
);


CREATE TABLE leituras (
id INT AUTO_INCREMENT PRIMARY KEY,
area_m2_leitura DECIMAL(10,2) NOT NULL DEFAULT 0,
codigo_medidor VARCHAR(50) NOT NULL,
ambiente_id INT NOT NULL,
usuario_id INT DEFAULT NULL,
data_hora DATETIME NOT NULL,
leitura_acumulada_kwh DECIMAL(12,3) NOT NULL,
origem ENUM('Manual', 'Simulado', 'CSV') DEFAULT 'Manual',
estado_medidor_leituras VARCHAR(30) DEFAULT 'ATIVO',
CONSTRAINT fk_leitura_ambiente FOREIGN KEY (ambiente_id) REFERENCES ambientes(id) ON DELETE CASCADE,
CONSTRAINT fk_leitura_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

CREATE TABLE metas (
id INT AUTO_INCREMENT PRIMARY KEY,
ambiente_id INT UNIQUE NOT NULL,
mes_ano DATE UNIQUE NOT NULL,
meta_kwh DECIMAL(12,2) NOT NULL,
meta_reais DECIMAL(12,2) NOT NULL,
CONSTRAINT fk_meta_ambiente FOREIGN KEY (ambiente_id) REFERENCES ambientes(id) ON DELETE CASCADE
);


CREATE TABLE relatorios_problemas (
id INT AUTO_INCREMENT PRIMARY KEY,
ambiente_id INT NOT NULL,
usuario_id INT NOT NULL,
problema_relatado TEXT NOT NULL,
estado VARCHAR(30) DEFAULT 'Pendente',
criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_problema_ambiente FOREIGN KEY (ambiente_id) REFERENCES ambientes(id) ON DELETE CASCADE,
CONSTRAINT fk_problema_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO usuarios(nome, email, senha, empresa) VALUES
( "Roberto Andrade", "roberto.andrade@cisco.org", "senai123", "Cisco");

INSERT INTO setor(nome, descricao, empresa_setor) VALUES
( "Bloco A", "Espaço de gestão da empresa", "Cisco"),
( "Bloco B", "Espaço destinado a pesquisa e desenvolvimento", "Cisco");

INSERT INTO ambientes(setor_id, nome, andar, empresa_ambiente, area_m2, qtd_equipamentos, tempo_uso_medio_diario, codigo_medidor) VALUES
( "2", "Data Center", "Térreo", "Cisco", "62", "30", "23:59:59", "MED-DC-00"),
( "2", "Lab. Cibersegurança", "Térreo", "Cisco", "110", "18", "12:00:00", "MED-CIB-00"),
( "1", "Recepção", "Térreo", "Cisco", "45", "6", "10:00:00", "MED-REC-00"),
( "1", "Sala de Reunião A", "Térreo", "Cisco", "35", "5", "05:00:00", "MED-REU-01"),
( "1", "Sala de Reunião B", "1", "Cisco", "50", "7", "05:00:00", "MED-REU-02"),
( "1", "Diretoria", "1", "Cisco", "65", "10", "10:00:00", "MED-DIR-00"),
( "2", "TI", "1", "Cisco", "85", "15", "10:00:00", "MED-TI-01"),
( "2", "RH", "1", "Cisco", "90", "16", "10:00:00", "MED-RH-03"),
( "2", "Cantina", "Térreo", "Cisco", "125", "12", "06:00:00", "MED-CAN-06");

INSERT INTO leituras(ambiente_id, usuario_id, data_hora, leitura_acumulada_kwh, area_m2_leitura, codigo_medidor, estado_medidor_leituras) VALUES
( "1", "1", "2026-11-12 09:00:00", "5.400", 89, "MED-REU-02", "ATIVO" ),
( "2", "1", "2026-10-27 00:00:00", "6.700", 76, "MED-REU-02", "ATIVO" ),
( "3", "1", "2026-11-11 12:00:00", "9.100", 56, "MED-REU-02", "ATIVO" ),
( "4", "1", "2026-11-12 08:30:00", "1.900", 67, "MED-REU-02", "ATIVO" ),
( "5", "1", "2026-11-25 09:00:00", "3.300", 91, "MED-REU-02", "ATIVO" );

INSERT INTO metas(ambiente_id, mes_ano, meta_kwh, meta_reais) VALUES
( "1", "2026-11-01", "81.50", meta_kwh * 0.7),
( "2", "2026-09-01", "43.50", meta_kwh * 0.7),
( "3", "2026-11-11", "12.50", meta_kwh * 0.7),
( "4", "2026-07-01", "83.50", meta_kwh * 0.7),
( "5", "2026-10-01", "55.50", meta_kwh * 0.7),
( "6", "2026-08-01", "78.50", meta_kwh * 0.7),
( "7", "2026-06-07", "60.70", meta_kwh * 0.7),
( "8", "2026-11-07", "54.90", meta_kwh * 0.7),
( "9", "2026-10-22", "81.50", meta_kwh * 0.7);

INSERT INTO relatorios_problemas(ambiente_id, usuario_id, problema_relatado) VALUES
( "4", "1", "O ar condicionado no MED-REU-01 não está desligando, causando pico no medidor.");
