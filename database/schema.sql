-- seed

create database if not exists ElectroSafe;

use ElectroSafe;


create table if not exists  enderecoCliente(
	id INT PRIMARY KEY auto_increment,
    cep VARCHAR(9),
    numero VARCHAR (10),
    rua VARCHAR (60),
    bairro VARCHAR (60),
    cidade VARCHAR (60),
    estado VARCHAR (20),
    complemento VARCHAR (100)
);

create table if not exists usuarios(
	id INT PRIMARY KEY auto_increment,
    nome VARCHAR (100) NOT NULL,
    email VARCHAR (100) NOT NULL unique ,
    data_nascimento DATE, 
    senha VARCHAR (255) NOT NULL,
    cpf VARCHAR (11) NOT NULL unique,
    telefone VARCHAR (20)
);
    


create table if not exists  clientes (
	idUsuario INT PRIMARY KEY,
    idEndereco int NOT NULL,
    -- FK
    foreign key(idEndereco) references enderecoCliente(id),
	foreign key(idUsuario) references usuarios(id)
);

create table if not exists  funcionarios (
	idUsuario INT PRIMARY KEY,
	especializacao VARCHAR(30) NOT NULL,
    -- FK
    foreign key(idUsuario) references usuarios(id)
);

create table if not exists  departamentos(
	id int primary key auto_increment,
    numero INTEGER unique NOT NULL,
    nome VARCHAR (40) NOT NULL,
    dataCriacao DATETIME DEFAULT current_timestamp
    );

create table if not exists   administrador(
    idUsuario INT PRIMARY KEY,
    id_departamento int,
    -- FK
    foreign key (id_departamento) references departamentos(id),
	foreign key (idUsuario) references usuarios(id)
);



    
create table if not exists  funcionario_departamentos(
	id int primary key auto_increment,
    idFuncionario int not null,
    idDepartamento int not null,
    -- FK
    foreign key (idFuncionario) references funcionarios(idUsuario),
	foreign key(idDepartamento) references departamentos(id),
    
    unique (idFuncionario, idDepartamento)
);
create table if not exists  pedidos(
	id int primary key auto_increment,
    idCliente int NOT NULL,
    statusPedido ENUM('ANDAMENTO', 'AGUARDANDO', 'FINALIZADO', 'CANCELADO') DEFAULT 'AGUARDANDO' NOT NULL,
	categoria ENUM('TOMADA', 'ILUMINACAO', 'DISJUNTOR', 'INSTALACAO') NOT NULL,
    descricao text NOT NULL,
    -- FK
    foreign key (idCliente) references clientes(idUsuario)
);

create table if not exists registros(
	id int primary key auto_increment,
    idUsuario int NOT NULL,
	descricao text,
    status_registro ENUM ('ANDAMENTO', 'AGUARDANDO', 'FINALIZADO', 'CANCELADO')  DEFAULT 'AGUARDANDO' NOT NULL,
	data_ocorrencia DATETIME DEFAULT current_timestamp, --
    idDepartamento int,--
    impacto_erro ENUM ('LEVE', 'MODERADO', 'CRITICO') NOT NULL, --
    norma_violada VARCHAR (200), -- 
    origem_desvio VARCHAR (200), -- 
    acao_imediata text, -- Contenção do problema para evitar que piore
    responsavel_Imediato int NOT NULL, -- Responsável por executar a ação imediata
    prazo DATETIME, -- Data maxima para conter o erro.
    analise_erro text,
    acao_corretiva text,
    responsavel_acaoFinal int NOT NULL, -- 
    prazo_limite DATETIME,
    data_verificacao DATETIME NULL,
    eficacia ENUM ('SIM', 'NÃO') default null,
    obs_fechamento text,
    -- FK
    foreign key(idUsuario) references usuarios(id),
    foreign key(idDepartamento) references departamentos(id),
    foreign key(responsavel_Imediato) references funcionarios(idUsuario),
	foreign key(responsavel_acaoFinal) references administrador(idUsuario)
);

create table if not exists analise_tecnica (
	id int primary key auto_increment,
    cliente_analise int, -- Busca os dados do cliente que solicitou a analise
    servicos ENUM ('CONSERTO', 'MONTAGEM', 'AVALIAÇÃO', 'MANUTENÇÃo', 'MODIFICAÇÃO') NOT NULL,
    relatoProblema text,
    -- FK
    foreign key (cliente_analise) references clientes(idUsuario)
    
);
-- views
-- uma view é uma query, porem simplificada, com nome amigavel
CREATE VIEW vw_funcionarios_departamentos AS

SELECT
    f.especializacao,
    d.id AS idDepartamento,
    d.nome AS departamento,
    d.numero AS numeroDepartamento

FROM funcionarios f

INNER JOIN usuarios u
	ON u.id = f.idUsuario
    
INNER JOIN funcionario_departamentos fd
    ON f.idUsuario = fd.idFuncionario

INNER JOIN departamentos d
    ON fd.idDepartamento = d.id;
    