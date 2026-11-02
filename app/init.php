<?php

// A sessão guarda os dados do usuário que fez login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carrega a conexão e as funções básicas de CRUD da estrutura principal.
require_once __DIR__ . '/banco/database.php';
require_once __DIR__ . '/banco/crud.php';

// Impede o acesso de pessoas que ainda não fizeram login.
function protegerPagina()
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Retorna verdadeiro quando o usuário conectado é funcionário.
function usuarioEhFuncionario()
{
    return ($_SESSION['usuario_tipo'] ?? '') === 'funcionario';
}

// Retorna verdadeiro quando o usuário conectado é cliente.
function usuarioEhCliente()
{
    return ($_SESSION['usuario_tipo'] ?? '') === 'cliente';
}

// Protege páginas e ações exclusivas dos funcionários.
function protegerFuncionario()
{
    protegerPagina();

    if (!usuarioEhFuncionario()) {
        http_response_code(403);
        exit('Acesso permitido somente para funcionários.');
    }
}

// Protege páginas e ações exclusivas dos clientes.
function protegerCliente()
{
    protegerPagina();

    if (!usuarioEhCliente()) {
        http_response_code(403);
        exit('Acesso permitido somente para clientes.');
    }
}

// Converte o valor técnico do banco em um texto correto para a tela.
function nomeStatus($status)
{
    $nomes = [
        'Solicitado' => 'Solicitado',
        'Agendado' => 'Agendado',
        'Em andamento' => 'Em andamento',
        'Concluido' => 'Concluído',
        'Cancelado' => 'Cancelado'
    ];

    return $nomes[$status] ?? $status;
}

// Define uma classe CSS simples para cada status.
function classeStatus($status)
{
    $classes = [
        'Solicitado' => 'solicitado',
        'Agendado' => 'agendado',
        'Em andamento' => 'em_andamento',
        'Concluido' => 'concluido',
        'Cancelado' => 'cancelado'
    ];

    return $classes[$status] ?? '';
}

// Evita que códigos HTML sejam executados ao mostrar dados do banco.
function textoSeguro($texto)
{
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}
