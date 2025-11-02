<?php
session_start();

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: ./Index.php");
    exit();
}

$admin = $_SESSION['admin']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aquestre</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>       
        #toast {
            visibility: hidden;
            min-width: 500px;
            background-color: #f44336; /* vermelho */
            color: #fff;
            text-align: center;
            border-radius: 8px;
            padding: 16px;
            position: fixed;
            z-index: 9999;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        #toast.show {
        visibility: visible;
        opacity: 1;
        }
    </style>
</head>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle" style="display: flex; align-items: center; justify-content: space-between;">
            <!-- Ícone do menu -->
            <i class="bi bi-list" id="header-toggle" style="font-size: 1.5rem; color: #961b80;"></i>
        
            <!-- Texto "Dashboard Aquestre" -->
            <div style="display: flex; align-items: center; margin-left: 1rem;">
                <p style="margin: 0; font-size: 1.2rem; color: #000000;">Sua Dashboard</p>
            </div>
        </div>

    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <!-- Logo e Nome -->
            <div>
                <!-- Lista de Navegação -->
                <div class="nav_list">
                    <a href="dashboard.php" class="nav_link active">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="nav_name">Início</span>
                    </a>
                    <a href="usuario.php" class="nav_link">
                        <i class="bi bi-person-fill"></i>
                        <span class="nav_name">Usuários</span>
                    </a>
                    <a href="paises.php" class="nav_link">
                        <i class="bi bi-globe2"></i>
                        <span class="nav_name">Países</span>
                    </a>
                    <a href="cidades.php" class="nav_link">
                        <i class="bi bi-buildings-fill"></i>
                        <span class="nav_name">Cidades</span>
                    </a>
                   
                </div>
            </div>
            <!-- Logout -->
            <a href="logout.php" class="nav_link">
                <i class="bi bi-box-arrow-left"></i>
                <span class="nav_name">SignOut</span>
            </a>
        </nav>
    </div>
    
    <!--Container Main start-->
    <div class="height-100 bg-light" style="display: flex; justify-content: center; align-items: center; height: 75vh;">
        <div class="welcome-message" style="width: 70%;  padding: 1.5rem; background-color: #ffffff; border-radius: 8px; border-left: 5px solid #ffffff;">
            <h2 style="font-size: 1.8rem; color: #961b80; font-weight: 600;">
                Olá, <?php echo isset($admin['nome']) ? ucwords(strtolower(htmlspecialchars($admin['nome']))) : 'Usuário'; ?>!
            </h2>

            <p style="font-size: 1.2rem; color: #333333e7;">
                Bem-vindo à sua dashboard! Aqui você poderá acessar todas as informações importantes rapidamente.
            </p>
            <p style="font-size: 1rem; color: #333333e7;">
                <strong>Usuários</strong>: Gerencie as contas e permissões dos clientes e membros da equipe.
            </p>
            <p style="font-size: 1rem; color: #333333e7;">
                <strong>Países</strong>: Cadastre, edite ou remova paises do sistema.
            </p>
            <p style="font-size: 1rem; color: #333333e7;">
                <strong>Cidades</strong>: Cadastre, edite, remova as cidades correspondentes a cada país.
            </p>
            <p style="font-size: 1rem; color:#333333e7;">
                Para qualquer dúvida, você sempre pode voltar para esta página ou consultar o menu ao lado! 😊
            </p>
        </div>
    </div>

    <?php 
    $quantidade = $_SESSION['quantidade_acesso'] ?? null; 
    if (isset($quantidade)):
    ?>
        <div id="toast" data-message="Bem-vindo novamente! Esta é a <?= $quantidade ?>ª vez que você entra no nosso site."></div>
    <?php endif; ?>

    <script src="dashboard.js"></script>
<script>
    // Script para o Toast (já existente)
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('toast');
        if (toast && toast.dataset.message) {
            toast.textContent = toast.dataset.message;
            toast.classList.add('show');

            // Esconde o toast depois de 5 segundos
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }
    });
</script>
</body>
</html>