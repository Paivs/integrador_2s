<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Gera token CSRF esperado pelo processaRegistro.php
if (empty($_SESSION['csrf_registro'])) {
    $_SESSION['csrf_registro'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_registro'];

// Recupera dados e erros de validação caso o processaRegistro.php tenha retornado
$dados = $_SESSION['registro_form'] ?? [];
$erros = $_SESSION['registro_erros'] ?? [];
unset($_SESSION['registro_form'], $_SESSION['registro_erros']);

$erroUrl   = trim((string) ($_GET['erro'] ?? ''));
$sucessoId = (int) ($_GET['sucesso'] ?? 0);

// Carrega opções do banco para os selects (departamentos, funcionários e administradores)
$departamentos   = [];
$funcionarios    = [];
$administradores = [];

if (isset($pdo) && $pdo instanceof PDO) {
    try {
        $departamentos = $pdo->query('SELECT id, nome FROM departamentos ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        error_log($e->getMessage());
    }

    try {
        $funcionarios = $pdo->query(
            'SELECT u.id, u.nome FROM usuarios u INNER JOIN funcionarios f ON f.idUsuario = u.id ORDER BY u.nome'
        )->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        error_log($e->getMessage());
    }

    try {
        $administradores = $pdo->query(
            'SELECT u.id, u.nome FROM usuarios u INNER JOIN administrador a ON a.idUsuario = u.id ORDER BY u.nome'
        )->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        error_log($e->getMessage());
    }
}

function valorCampo(array $dados, string $chave, string $padrao = ''): string
{
    return htmlspecialchars((string) ($dados[$chave] ?? $padrao), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Registro de Não Conformidades</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylesClientes/styleRegistro.css">
</head>
<body>

    <div class="fundo-video" aria-hidden="true">
        <video autoplay muted loop playsinline preload="metadata">
            <source src="imagens/video.mp4" type="video/mp4">
        </video>
        <div class="fundo-overlay"></div>
    </div>

    <div class="layout-principal">

        <!-- MENU LATERAL IDÊNTICO AO INDEX -->
        <aside class="barra-menu">
            <a href="index.php" class="logo-link" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeca">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav" aria-label="Navegação principal">
                <a href="index.php" class="nav-item"><i></i><span>Início</span></a>
                <a href="registro.php" class="nav-item active" aria-current="page"><i></i><span>Registro de não conformidades</span></a>
                <a href="analise.php" class="nav-item"><i></i><span>Análise técnica e inspeção</span></a>
                <a href="checklist.php" class="nav-item"><i></i><span>Checklist</span></a>
                <a href="acompanhamento.php" class="nav-item"><i></i><span>Acompanhamento</span></a>
                <a href="indicacao.php" class="nav-item"><i></i><span>Indicação</span></a>
            </nav>
        </aside>

        <!-- ÁREA DIREITA -->
        <div class="area-direita">

            <header class="topo">
                <div class="topo__marca">
                    <h1 class="logo">ELECTROSAFE</h1>
                    <p class="topo__sub">Sistema de Inspeção e Segurança Elétrica</p>
                </div>
                <div class="topo__registro">
                    <span class="topo__registro-rotulo">Protocolo</span>
                    <span class="topo__registro-valor">
                        <?= $sucessoId > 0 ? '#' . str_pad((string) $sucessoId, 4, '0', STR_PAD_LEFT) : 'Novo Registro' ?>
                    </span>
                </div>
            </header>

            <main class="conteudo">
                <div class="titulo-pagina">
                    <h2>Registro de Não Conformidade</h2>
                    <p>Preencha os dados técnicos da ocorrência elétrica. Campos com <span class="obrigatorio">*</span> são obrigatórios.</p>
                </div>

                <?php if ($sucessoId > 0): ?>
                    <div class="mensagem mensagem--sucesso" role="status">
                        <p><strong>Sucesso!</strong> Não conformidade registrada sob o protocolo <strong>#<?= $sucessoId ?></strong>.</p>
                    </div>
                <?php endif; ?>

                <?php if ($erroUrl !== ''): ?>
                    <div class="mensagem mensagem--erro" role="alert">
                        <p><?= htmlspecialchars($erroUrl, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($erros)): ?>
                    <div class="mensagem mensagem--erro" role="alert">
                        <p><strong>Corrija os seguintes pontos antes de salvar:</strong></p>
                        <ul style="margin: 8px 0 0 20px;">
                            <?php foreach ($erros as $erro): ?>
                                <li><?= htmlspecialchars((string) $erro, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="processaRegistro.php" method="POST" class="formulario">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

                    <!-- BLOCO 1: IDENTIFICAÇÃO DA OCORRÊNCIA -->
                    <fieldset class="bloco">
                        <legend>1. Identificação da Ocorrência</legend>

                        <div class="campo">
                            <label for="data_ocorrencia">Data da ocorrência <span class="obrigatorio">*</span></label>
                            <input type="date" id="data_ocorrencia" name="data_ocorrencia" value="<?= valorCampo($dados, 'data_ocorrencia', date('Y-m-d')) ?>" required>
                        </div>

                        <div class="campo">
                            <label for="hora_ocorrencia">Hora da ocorrência</label>
                            <input type="time" id="hora_ocorrencia" name="hora_ocorrencia" value="<?= valorCampo($dados, 'hora_ocorrencia', date('H:i')) ?>">
                        </div>

                        <div class="campo">
                            <label for="idDepartamento">Departamento / Setor</label>
                            <select id="idDepartamento" name="idDepartamento">
                                <option value="">Selecione (opcional)...</option>
                                <?php foreach ($departamentos as $dep): ?>
                                    <?php $sel = ((string) ($dados['idDepartamento'] ?? '') === (string) $dep['id']) ? 'selected' : ''; ?>
                                    <option value="<?= (int) $dep['id'] ?>" <?= $sel ?>>
                                        <?= htmlspecialchars((string) $dep['nome'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="status_registro">Status do registro <span class="obrigatorio">*</span></label>
                            <select id="status_registro" name="status_registro" required>
                                <?php
                                $statusAtual = (string) ($dados['status_registro'] ?? 'AGUARDANDO');
                                $statusLista = [
                                    'AGUARDANDO' => 'Aguardando',
                                    'ANDAMENTO'  => 'Em andamento',
                                    'FINALIZADO' => 'Finalizado',
                                    'CANCELADO'  => 'Cancelado',
                                ];
                                foreach ($statusLista as $val => $rotulo):
                                ?>
                                    <option value="<?= $val ?>" <?= $statusAtual === $val ? 'selected' : '' ?>><?= $rotulo ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="local">Local exato <span class="obrigatorio">*</span></label>
                            <input type="text" id="local" name="local" maxlength="100" placeholder="Ex: Subestação Bloco B, Sala de Painéis" value="<?= valorCampo($dados, 'local') ?>" required>
                        </div>

                        <div class="campo">
                            <label for="equipamento">Equipamento / Instalação <span class="obrigatorio">*</span></label>
                            <input type="text" id="equipamento" name="equipamento" maxlength="95" placeholder="Ex: Quadro Geral QGBT-02 / Disjuntor 3" value="<?= valorCampo($dados, 'equipamento') ?>" required>
                        </div>

                        <div class="campo campo--cheio">
                            <label for="norma_violada">Norma técnica violada (NR-10, NBR 5410, etc.)</label>
                            <input type="text" id="norma_violada" name="norma_violada" maxlength="200" placeholder="Ex: NR-10 item 10.2.8 - Ausência de barramento isolado" value="<?= valorCampo($dados, 'norma_violada') ?>">
                        </div>

                        <div class="campo campo--cheio">
                            <fieldset class="grupo-risco">
                                <legend>Nível de risco / Impacto <span class="obrigatorio">*</span></legend>
                                <?php $impactoAtual = (string) ($dados['impacto_erro'] ?? ''); ?>
                                <div class="opcoes-risco">
                                    <input type="radio" id="risco_leve" name="impacto_erro" value="LEVE" <?= $impactoAtual === 'LEVE' ? 'checked' : '' ?> required>
                                    <label for="risco_leve" class="chip chip--baixo">Leve (Baixo)</label>

                                    <input type="radio" id="risco_moderado" name="impacto_erro" value="MODERADO" <?= $impactoAtual === 'MODERADO' ? 'checked' : '' ?>>
                                    <label for="risco_moderado" class="chip chip--medio">Moderado (Médio)</label>

                                    <input type="radio" id="risco_critico" name="impacto_erro" value="CRITICO" <?= $impactoAtual === 'CRITICO' ? 'checked' : '' ?>>
                                    <label for="risco_critico" class="chip chip--critico">Crítico (Alto)</label>
                                </div>
                            </fieldset>
                        </div>

                        <div class="campo campo--cheio">
                            <label for="descricao">Descrição detalhada da não conformidade <span class="obrigatorio">*</span></label>
                            <textarea id="descricao" name="descricao" rows="4" minlength="10" placeholder="Descreva detalhadamente o desvio encontrado, condições de risco e evidências..." required><?= valorCampo($dados, 'descricao') ?></textarea>
                        </div>
                    </fieldset>

                    <!-- BLOCO 2: AÇÃO IMEDIATA -->
                    <fieldset class="bloco">
                        <legend>2. Contenção e Ação Imediata</legend>

                        <div class="campo campo--cheio">
                            <label for="acao_imediata">Ação imediata tomada</label>
                            <textarea id="acao_imediata" name="acao_imediata" rows="3" placeholder="Ex: Isolamento da área, desligamento do circuito, sinalização de bloqueio..."><?= valorCampo($dados, 'acao_imediata') ?></textarea>
                        </div>

                        <div class="campo">
                            <label for="responsavel_Imediato">Responsável pela ação imediata (Funcionário) <span class="obrigatorio">*</span></label>
                            <select id="responsavel_Imediato" name="responsavel_Imediato" required>
                                <option value="">Selecione o funcionário...</option>
                                <?php foreach ($funcionarios as $func): ?>
                                    <?php $sel = ((string) ($dados['responsavel_Imediato'] ?? '') === (string) $func['id']) ? 'selected' : ''; ?>
                                    <option value="<?= (int) $func['id'] ?>" <?= $sel ?>>
                                        <?= htmlspecialchars((string) $func['nome'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="prazo">Prazo da ação imediata</label>
                            <input type="date" id="prazo" name="prazo" value="<?= valorCampo($dados, 'prazo') ?>">
                        </div>
                    </fieldset>

                    <!-- BLOCO 3: ANÁLISE DE CAUSA E AÇÃO CORRETIVA FINAL -->
                    <fieldset class="bloco">
                        <legend>3. Análise Técnica e Ação Corretiva Final</legend>

                        <div class="campo campo--cheio">
                            <label for="analise_erro">Análise de causa raiz</label>
                            <textarea id="analise_erro" name="analise_erro" rows="3" placeholder="Identifique a causa técnica ou operacional que originou a não conformidade..."><?= valorCampo($dados, 'analise_erro') ?></textarea>
                        </div>

                        <div class="campo">
                            <label for="responsavel_acaoFinal">Responsável pela ação final (Administrador) <span class="obrigatorio">*</span></label>
                            <select id="responsavel_acaoFinal" name="responsavel_acaoFinal" required>
                                <option value="">Selecione o administrador...</option>
                                <?php foreach ($administradores as $adm): ?>
                                    <?php $sel = ((string) ($dados['responsavel_acaoFinal'] ?? '') === (string) $adm['id']) ? 'selected' : ''; ?>
                                    <option value="<?= (int) $adm['id'] ?>" <?= $sel ?>>
                                        <?= htmlspecialchars((string) $adm['nome'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="prazo_limite">Prazo limite para correção</label>
                            <input type="date" id="prazo_limite" name="prazo_limite" value="<?= valorCampo($dados, 'prazo_limite') ?>">
                        </div>
                    </fieldset>

                    <!-- BLOCO 4: VERIFICAÇÃO E ENCERRAMENTO -->
                    <fieldset class="bloco">
                        <legend>4. Verificação de Eficácia e Fechamento</legend>

                        <div class="campo">
                            <label for="data_verificacao">Data da verificação</label>
                            <input type="date" id="data_verificacao" name="data_verificacao" value="<?= valorCampo($dados, 'data_verificacao') ?>">
                        </div>

                        <div class="campo">
                            <label for="eficacia">A ação foi eficaz?</label>
                            <?php $eficaciaAtual = (string) ($dados['eficacia'] ?? ''); ?>
                            <select id="eficacia" name="eficacia">
                                <option value="" <?= $eficaciaAtual === '' ? 'selected' : '' ?>>Pendente de verificação</option>
                                <option value="SIM" <?= $eficaciaAtual === 'SIM' ? 'selected' : '' ?>>Sim</option>
                                <option value="NÃO" <?= $eficaciaAtual === 'NÃO' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div class="campo campo--cheio">
                            <label for="obs_fechamento">Observações de fechamento</label>
                            <textarea id="obs_fechamento" name="obs_fechamento" rows="2" placeholder="Parecer final da inspeção..."><?= valorCampo($dados, 'obs_fechamento') ?></textarea>
                        </div>
                    </fieldset>

                    <div class="acoes">
                        <a href="index.php" class="botao botao--secundario">Cancelar</a>
                        <button type="submit" class="botao botao--primario">Salvar Não Conformidade</button>
                    </div>
                </form>
            </main>

            <footer class="rodape">
                <p>ELECTROSAFE © 2026 - SEGURANÇA E CONFIABILIDADE</p>
            </footer>

        </div>
    </div>

</body>
</html>