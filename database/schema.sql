CREATE DATABASE SOLARCONTROL;
USE SOLARCONTROL;

## 1. TABELA DE ENDEREÇOS (Criada primeiro para que usuarios possa referenciá-la)
CREATE TABLE enderecos(
    ID_ENDERECO INT PRIMARY KEY AUTO_INCREMENT,
    CEP VARCHAR(8),
    estado VARCHAR(3),
    cidade VARCHAR(50), 
    logradouro VARCHAR(50),
    numero VARCHAR(5)
); 

## 2. TABELA DE USUÁRIOS
CREATE TABLE usuarios(
    ID_USUARIO INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(20),
    id_endereco int,
    TIPO ENUM("cliente", "funcionario", "adm") DEFAULT "cliente",
    FOREIGN KEY(id_endereco) REFERENCES enderecos (ID_ENDERECO) -- Ajustado para maiúsculo ID_ENDERECO se preferir manter o padrão
);

## 3. TABELA DE SISTEMAS FOTOVOLTAICOS
CREATE TABLE fotovoltaicos(
    ID_fotovoltaicos INT PRIMARY KEY AUTO_INCREMENT, -- O nome real da coluna pai é este
    ID_USUARIO INT,
    modelo_painel VARCHAR(100),
    data_intalacao DATE,
    status_sistema VARCHAR(20),
    FOREIGN KEY(ID_USUARIO) REFERENCES usuarios (ID_USUARIO)
);

## 4. TABELA DE REGISTRO DE ENERGIA E CONSUMO
CREATE TABLE registros(
    ID_REGISTRO INT PRIMARY KEY AUTO_INCREMENT,
    ID_fotovoltaicos INT,
    data_registro DATE,
    energia_gerada INT,
    energia_consumida INT,
    FOREIGN KEY(ID_fotovoltaicos) REFERENCES fotovoltaicos (ID_fotovoltaicos)
);

## 5. TABELA DE MANUTENÇÃO E INSTALAÇÃO (Corrigida)
CREATE TABLE manutencao_e_instalacao(
    ID_MANUTENCAO INT PRIMARY KEY AUTO_INCREMENT,
    ID_SISTEMAS INT,
    data_agendada DATE,
    tempo_estimado VARCHAR(50),
    qualidade_sistema VARCHAR(100),
    previsao_da_proxima_manutencao DATE,
    -- CORREÇÃO: Referenciando a coluna exata que existe na tabela fotovoltaicos
    FOREIGN KEY(ID_SISTEMAS) REFERENCES fotovoltaicos (ID_fotovoltaicos)
);