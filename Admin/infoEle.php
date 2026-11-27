<?php
// Exemplo: troque pelos dados vindos do seu banco de dados.
// Cada item precisa ter as chaves: nome, idade, especializacao, avaliacao
$eletricistas = $eletricistas ?? [
    ['nome' => 'Carlos Silva', 'idade' => 34, 'especializacao' => 'Instalações residenciais', 'avaliacao' => '4.8'],
    ['nome' => 'Marina Souza', 'idade' => 29, 'especializacao' => 'Manutenção preventiva', 'avaliacao' => '4.5'],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Informações</title>
    <link rel="stylesheet" href="styleinfoEleAdmin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="layout-principal">
        <aside class="barra-menu">
            <a href="index.php" class="logo.png" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeça">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item ">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="acompanhamento.php" class="nav-item">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item">
                    <i></i>
                    <span>Novo Eletricista</span>
                </a>
                <a href="infoEle.php" class="nav-item active">
                    <i></i>
                    <span>Informações dos Eletricistas</span>
                </a>
            </nav>
        </aside>
    <main>
    <header>
        <h1>DADOS DOS ELETRICISTAS</h1>
    </header>
        <div id="area-centro">
        <div class="card-tabela">
            <div class="tabela-rolagem">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Idade</th>
                            <th>Especialização</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($eletricistas)): ?>
                            <tr>
                                <td colspan="4" class="tabela-vazia">Nenhum eletricista cadastrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($eletricistas as $e): ?>
                                <tr>
                                    <td><?= htmlspecialchars($e['nome']) ?></td>
                                    <td><?= (int) $e['idade'] ?></td>
                                    <td><?= htmlspecialchars($e['especializacao']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </main>

</body>
</html>