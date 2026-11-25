$pagina_atual = 'inicio';
$estilo_css = 'style';
require_once 'cabecalho.php';
?>

<html>
    <head>
        <title>Doce Encontro</title>
      <link rel="stylesheet" href="style.css">
      </head>
    <body>
        <div class="banner-principal">
    <section class="secao-boas-vindas banner-texto">
        <div class="etiqueta-destaque">O CANTINHO MAIS CHARMOSO DA CIDADE</div>

        <h1 class="titulo-hero">
            Onde o afeto encontra o <br>
            <span class="destaque-rosa">sabor inesquecível</span>
        </h1>

        <p class="descricao-hero">
            Bem-vindo à <strong>Lanchonete Doce Encontro</strong>. Delicie-se com nossos cafés artesanais frescos e salgados especiais.
        </p>

        <a href="cardapio.php" class="botao-verde-grande">
            Ver Cardápio Completo (<?= count($produtos) ?> itens)
        </a>
    </section>

    <div class="banner-imagem">
        <img src="./imagem/image.png" alt="Interior da Lanchonete Doce Encontro">
    </div>
</div>
</body>
</html>