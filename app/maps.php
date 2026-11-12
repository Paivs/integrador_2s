
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mapa de Oficinas - CarCare</title>

    <link rel="stylesheet" href="css/maps.css">

    <link
        href="https://unpkg.com/maplibre-gl@5.6.1/dist/maplibre-gl.css"
        rel="stylesheet"
    >
</head>

<body>

    <header>
        <h1>CarCare</h1>
        <span>Mapa de Oficinas e Concessionárias</span>
    </header>

    <main>

        <section class="informacoes">
            <h2>Encontre uma concessionária</h2>

            <p>
                Explore concessionárias de grandes marcas nas quais operamos pelo estado de São Paulo.
            </p>
        </section>

        <div id="mapa"></div>

    </main>

    <script src="https://unpkg.com/maplibre-gl@5.6.1/dist/maplibre-gl.js"></script>

    <script>

        // Criando o mapa
        const mapa = new maplibregl.Map({

            container: 'mapa',

            style: 'https://tiles.openfreemap.org/styles/liberty',

            // Estado de São Paulo
            center: [-47.0, -23.2],

            zoom: 6.3

        });

     



        // Concessionárias reais
        const lojas = [

            // MERCEDES-BENZ
            {
                nome: "Carcare Conceição",
                marca: "Carcare",
                endereco: "Av. Hélio Pellegrino, 35, Vila Nova Conceição, São Paulo, SP"
            },
            {
                nome: "Carcare José",
                marca: "Carcare",
                endereco: "Av. Deputado Benedito Matarazzo, 9575, São José dos Campos, SP"
            },
            {
                nome: "Carcare Campinas",
                marca: "Carcare",
                endereco: "Av. Antônio Carlos Couto de Barros, 1555, Campinas, SP"
            },
            {
                nome: "Carcare ABC",
                marca: "Carcare",
                endereco: "Av. Dr. Rudge Ramos, 859, São Bernardo do Campo, SP"
            },
            {
                nome: "Carcare Guarulhos",
                marca: "Carcare",
                endereco: "Rua Eduardo Froner, 1070, Guarulhos, SP"
            },
            {
                nome: "Carcare Sorocaba",
                marca: "Carcare",
                endereco: "SP-270, Km 104, Sorocaba, SP"
            },
            {
                nome: "Carcare Santos",
                marca: "Carcare",
                endereco: "Av. Washington Luís, 78, Vila Mathias, Santos, SP"
            },

            
         
        ];


        // Adicionando os marcadores ao mapa
        mapa.on('load', async function() {

            const limites = new maplibregl.LngLatBounds();

            for (const loja of lojas) {

                try {

                    // Procurando as coordenadas pelo endereço
                    const url = new URL(
                        'https://photon.komoot.io/api/'
                    );

                    url.searchParams.set('q', loja.endereco);
                    url.searchParams.set('limit', '1');

                    const resposta = await fetch(url);

                    if (!resposta.ok) {
                        throw new Error("Erro ao consultar endereço");
                    }

                    const dados = await resposta.json();

                    if (dados.features.length > 0) {

                        const coordenadas =
                            dados.features[0].geometry.coordinates;

                       // Criando o ícone personalizado
const icone = document.createElement('img');

icone.src = 'imagens/icone-carcare.png';
icone.alt = 'CarCare';

icone.style.width = '45px';
icone.style.height = '45px';
icone.style.objectFit = 'contain';
icone.style.cursor = 'pointer';

// Criando o marcador com a imagem
const marcador = new maplibregl.Marker({
    element: icone,
    anchor: 'bottom'
});

marcador
    .setLngLat(coordenadas)
    .setPopup(
        new maplibregl.Popup().setHTML(`
            <h3>${loja.nome}</h3>
            <p><strong>Marca:</strong> ${loja.marca}</p>
            <p>${loja.endereco}</p>
        `)
    )
    .addTo(mapa);

                    }

                    // Pequena pausa entre as consultas
                    await new Promise(resolve =>
                        setTimeout(resolve, 350)
                    );

                } catch (erro) {

                    console.error(
                        "Erro ao localizar:",
                        loja.nome,
                        erro
                    );

                }

            }

            // Ajusta o mapa para mostrar os marcadores encontrados
            if (!limites.isEmpty()) {

                mapa.fitBounds(limites, {
                    padding: 60,
                    maxZoom: 9
                });

            }

            console.log("Mapa CarCare carregado!");

        });


        mapa.on('error', function(evento) {
            console.error('Erro no mapa:', evento.error);
        });

    </script>
 <a href="index.php">Voltar ao menu principal</a>
</body>
</html>
