<?php

require_once __DIR__ . '/init.php';
protegerPagina();

$paginaAtual = 'veiculos';
$busca = trim($_GET['busca'] ?? '');
$mensagem = '';

if (($_GET['mensagem'] ?? '') === 'cadastrado') {
    $mensagem = 'Veículo cadastrado com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'editado') {
    $mensagem = 'Veículo atualizado com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'excluido') {
    $mensagem = 'Veículo excluído com sucesso.';
}

// O funcionário enxerga todos. O cliente enxerga somente os próprios veículos.
$sql = 'SELECT veiculos.*, clientes.nome AS proprietario
        FROM veiculos
        INNER JOIN clientes ON clientes.id = veiculos.cliente_id';
$parametros = [];
$filtros = [];

if (usuarioEhCliente()) {
    $filtros[] = 'veiculos.cliente_id = ?';
    $parametros[] = $_SESSION['cliente_id'];
}

if ($busca !== '') {
    $filtros[] = '(veiculos.modelo LIKE ?
                    OR veiculos.marca LIKE ?
                    OR veiculos.placa LIKE ?
                    OR clientes.nome LIKE ?)';
    $termo = '%' . $busca . '%';
    array_push($parametros, $termo, $termo, $termo, $termo);
}

if (count($filtros) > 0) {
    $sql .= ' WHERE ' . implode(' AND ', $filtros);
}

$sql .= ' ORDER BY veiculos.id DESC';
$comando = $pdo->prepare($sql);
$comando->execute($parametros);
$veiculos = $comando->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Veículos | CarCare</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="app">
    <?php include __DIR__ . '/parciais/nav.php'; ?>

    <main class="conteudo">
      <section class="pagina">
        <?php if ($mensagem !== ''): ?>
          <div class="alerta sucesso"><?php echo textoSeguro($mensagem); ?></div>
        <?php endif; ?>

        <header class="cabecalho">
          <div>
            <h1>Proprietários e veículos</h1>
            <p><?php echo usuarioEhFuncionario() ? 'Consulte os veículos dos clientes.' : 'Cadastre e acompanhe seus veículos.'; ?></p>
          </div>

          <?php if (usuarioEhCliente()): ?>
            <a class="botao primario" href="cadastro-veiculo.php">Cadastrar veículo</a>
          <?php endif; ?>
        </header>

        <form class="filtros" action="veiculos.php" method="get">
          <label class="busca">
            <img src="imagens/icone-busca.png" alt="">
            <input name="busca" type="search" value="<?php echo textoSeguro($busca); ?>" placeholder="Buscar por proprietário, placa ou veículo">
          </label>
          <span><?php echo count($veiculos); ?> veículo(s)</span>
        </form>

        <?php if (count($veiculos) === 0): ?>
          <div class="vazio">
            <img class="ilustracao" src="imagens/estado-sem-veiculo.png" alt="Ilustração de carro">
            <h2>Nenhum veículo encontrado</h2>
            <p><?php echo usuarioEhCliente() ? 'Cadastre um veículo para começar.' : 'Nenhum cliente possui veículo cadastrado.'; ?></p>
          </div>
        <?php else: ?>
          <div class="tabela-container">
            <table>
              <thead>
                <tr>
                  <th>Veículo</th>
                  <th>Placa</th>
                  <th>Proprietário</th>
                  <th>Quilometragem</th>
                  <?php if (usuarioEhCliente()): ?><th>Ações</th><?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                  <tr>
                    <td>
                      <strong><?php echo textoSeguro(trim($veiculo['marca'] . ' ' . $veiculo['modelo'])); ?></strong>
                      <small>Ano <?php echo intval($veiculo['ano']); ?></small>
                    </td>
                    <td><span class="placa"><?php echo textoSeguro($veiculo['placa']); ?></span></td>
                    <td><?php echo textoSeguro($veiculo['proprietario']); ?></td>
                    <td><?php echo number_format($veiculo['quilometragem'], 0, ',', '.'); ?> km</td>

                    <?php if (usuarioEhCliente()): ?>
                      <td>
                        <div class="acoes-tabela">
                          <a href="editar-veiculo.php?id=<?php echo $veiculo['id']; ?>">Editar</a>

                          <form action="excluir-veiculo.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $veiculo['id']; ?>">
                            <button type="submit">Excluir</button>
                          </form>
                        </div>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </section>
    </main>
  </div>
</body>
</html>
