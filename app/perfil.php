<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>findIt. - Perfil do Usuário</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>

    
    <header class="navbar">
        <a href="#" class="logo">
            <span class="logo-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <span class="logo-text">findIt<span class="dot">.</span></span>
        </a>

        <div class="nav-user-icon">
            <i class="fa-solid fa-user"></i>
        </div>

        <nav class="nav-links">
            <a href="#">Sobre</a>
            <a href="#">Objetos guardados</a>
            <a href="#">Dúvidas</a>
            <a href="#">Contato</a>
        </nav>

        <button class="btn-cadastrar">
            <i class="fa-solid fa-circle-plus"></i> Cadastrar Item
        </button>
    </header>
 

    <main class="main-container">
        <section class="profile-card">
            
            
            <div class="avatar-wrapper">
                <div class="avatar-circle">
                    <i class="fa-solid fa-user"></i>
                </div>
                <button class="edit-avatar-btn" title="Editar foto">
                    <i class="fa-solid fa-pencil"></i>
                </button>
            </div>

          
            <div class="info-pill name-pill">
                <span>Nome do usuário</span>
                <button class="edit-icon-btn" title="Editar nome">
                    <i class="fa-solid fa-pencil"></i>
                </button>
            </div>

            
            <div class="info-list">
                
                <div class="info-pill">
                    <div class="pill-left">
                        <i class="fa-solid fa-phone"></i>
                        <span>Telefone</span>
                    </div>
                    <button class="edit-icon-btn" title="Editar telefone">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                </div>

                
                <div class="info-pill">
                    <div class="pill-left">
                        <i class="fa-regular fa-envelope"></i>
                        <span>E-mail</span>
                    </div>
                    <button class="edit-icon-btn" title="Editar e-mail">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                </div>

               
                <div class="info-pill">
                    <div class="pill-left">
                        <i class="fa-solid fa-circle-half-stroke"></i>
                        <span>Tema</span>
                    </div>
                    <label class="theme-switch" title="Alternar tema">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>

                
                <div class="info-pill">
                    <div class="pill-left">
                        <i class="fa-solid fa-house"></i>
                        <span>Rua Azul</span>
                    </div>
                    <button class="edit-icon-btn" title="Editar endereço">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                </div>

                
                <div class="info-pill">
                    <div class="pill-left">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Forma de pagamento</span>
                    </div>
                    <button class="edit-icon-btn" title="Editar pagamento">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                </div>
            </div>

        </section>
    </main>

</body>
</html>