<?php

require_once __DIR__ . "/init.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item</title>
    <link rel="stylesheet" href="./css/cadastraObj.css">
</head>

<body>

    <!-- menu -->
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png" alt="FindIt"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.png" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./CadastrarItem.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <div class="lado-direito">
        <h2>Para realizar o cadastro de um novo objeto são necessárias as seguintes etapas:</h2>

        <form action="" method="POST" class="formulario">
            <div class="cadastro">
                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">1.</p>
                        <label for="nome">
                            <h3>Nome do objeto:</h3>
                        </label>
                    </div>

                    <input class="resposta" type="text" id="nome" name="nome" required>
                </div>

                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">2.</p>
                        <label for="descricao">
                            <h3>Descrição do objeto:</h3>
                        </label>
                    </div>

                    <input class="resposta" type="text" id="descricao" name="descricao" required>
                </div>

                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">3.</p>
                        <label for="local">
                            <h3>Local onde foi perdido ou encontrado:</h3>
                        </label>
                    </div>
                    
                    <input class="resposta" type="text" id="local" name="local" required>
                </div>

                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">4.</p>
                        <label for="categoria">
                            <h3>Categoria</h3>
                        </label>
                        
                        <select name="categoria" id="categoria" required>
                           
                            <option value="" disabled selected>Selecione...</option>
                            <option value="acessorios">Acessórios</option>
                            <option value="bolsas_mochilas">Bolsas e Mochilas</option>
                            <option value="documentos">Documentos</option>
                            <option value="eletronicos">Eletrônicos</option>
                            <option value="roupas">Roupas</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>
                </div>

                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">5.</p>
                        <label for="status">
                            <h3>Status atual:</h3>
                        </label>
                        <select name="status" id="status">
                            <option value="perdido">Perdido</option>
                            <option value="encontrado">Encontrado</option>
                        </select>
                    </div>
                </div>

                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">6.</p>
                        <h3>Selecione o ícone do objeto:</h3>
                    </div>
                </div>
            </div>

            <div class="circulos-container">
                <div class="oito">
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🍫" required>🍫</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🥤">🥤</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="⌚">⌚</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🌂">🌂</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="⚽">⚽</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🛼">🛼</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🎮">🎮</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🧸">🧸</label>
                </div>

                <div class="oito">
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="👓">👓</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🧥">🧥</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🧢">🧢</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="👜">👜</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="💄">💄</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="💍">💍</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🎧">🎧</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="📱">📱</label>
                </div>

                <div class="oito">
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="💻">💻</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="📷">📷</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="📚">📚</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="📓">📓</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="💳">💳</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🖊️">🖊️</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🔑">🔑</label>
                    <label class="circulo"><input type="radio" name="emoji_escolhido" value="🔨">🔨</label>
                </div>
            </div>

            <button class="botao" type="submit">Cadastrar</button>
        </form>
    </div>

    <div class="prateleira">
        <img src="imagens/prateleira.jpg" alt="prateleira com objetos guardados">
    </div>
</body>

</html>