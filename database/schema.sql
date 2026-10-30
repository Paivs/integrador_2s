CREATE database EnergyMonitor;
use EnergyMonitor;
CREATE TABLE salas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome varchar(100) not null,
    setor varchar(100) not null,
    gasto decimal(65, 2) not null,
    meta decimal(65, 2) not null,
    equipamentos int(100) not null,
    areaTotal decimal(65, 2) not null,
    tempoDeUso time not null,
    estado varchar(20) not null
);
CREATE TABLE usuarios(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome varchar(100) not null,
    email varchar(100) not null,
    senha varchar(50) not null,
    permissao varchar(50) not null
);
CREATE TABLE dados(
	ambienteMedidor varchar(100) not null,
    kwh decimal(65, 2) not null,
    blocoAndar varchar(100) not null,
    area decimal(65, 2) not null,
    resposavel varchar(100) not null,
    horario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    origem varchar(100) not null
);