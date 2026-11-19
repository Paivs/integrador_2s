<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Checklist</title>

    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styleClientes/styleChecklist.css">
</head>

<body>

    <aside class="barralateral">

        <div class="cabecabarra">
            <div class="logo">
                <span>Electro<strong>Safe</strong></span>
            </div>
        </div>

        <nav class="nav">

            <a href="index.php" class="nav-item">
                <i></i>
                <span>Início</span>
            </a>

            <a href="registro.html" class="nav-item">
                <i></i>
                <span>Registro de não conformidades</span>
            </a>

            <a href="analise.php" class="nav-item">
                <i></i>
                <span>Análise técnica e inspeção</span>
            </a>

      <a href="index.html" class="nav-item active">
                <i></i>
                <span>Checklist</span>
            </a>

      <a href="acompanhamento.php" class="nav-item">
                <i></i>
                <span>Acompanhamento</span>
            </a>

      <a href="indicacao.php" class="nav-item">
                <i></i>
                <span>Indicação</span>
            </a>

        </nav>

    </aside>

    <div class="conteudo">

        <header>
            <h1>ELECTROSAFE</h1>
            <p>SISTEMA DE INSPEÇÃO ELÉTRICA</p>
        </header>

        <main>

            <h2>CHECKLIST DE MATERIAIS</h2>

            <p class="descricao">
                Marque os equipamentos que já foram conferidos.
            </p>

            <div class="progresso">
                <h3>PROGRESSO DA INSPEÇÃO</h3>
                <p>Confira os materiais abaixo:</p>
            </div>

            <div class="lista">

                <label class="item">
                    <input type="checkbox">
                    <span>Alicate Universal</span>
                </label>

                <label class="item">
                    <input type="checkbox">
                    <span>Chave Phillips</span>
                </label>

                <label class="item">
                    <input type="checkbox">
                    <span>Multímetro</span>
                </label>

                <label class="item">
                    <input type="checkbox">
                    <span>Alicate Amperímetro</span>
                </label>

                <label class="item">
                    <input type="checkbox">
                    <span>Fita Isolante</span>
                </label>
        <label class="item">
                    <input type="checkbox">
                    <span>Óculos de Proteção</span>
                </label>

                <label class="item">
                    <input type="checkbox">
                    <span>Luvas de Proteção</span>
                </label>

            </div>

            <button onclick="alert('Checklist conferida!')">
                FINALIZAR CHECKLIST
            </button>

        
        </main>

        <footer>
            ELECTROSAFE © 2026 - SEGURANÇA E CONFIABILIDADE
        </footer>

    </div>

    

</body>
</html>