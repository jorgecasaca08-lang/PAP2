<?php
session_start();
// Check if user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: ../login.php");
    exit;
}

$pageTitle = "Dashboard do Utilizador - Alfa Engenharia & Construções";
// Include header from the root
// Since we are in dashboard/ we need to adjust paths for header.php if it uses relative paths
// header.php uses styles/main.css and index.php etc.
// It's better to include it and adjust the paths if necessary or use absolute paths in header.
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/main.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .user-welcome {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .dash-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: var(--shadow-md);
            text-align: center;
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
        }
        .dash-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        .dash-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        .dash-card h3 {
            margin-bottom: 10px;
        }
        .dash-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="logo-container">
        <a href="../index.php" class="logo-link">
            <div class="logo-text">
                <span class="alfa">Alfa</span>
                <span class="subtext">ENGENHARIA & CONSTRUÇÕES</span>
            </div>
        </a>
    </div>
    <nav class="main-nav">
        <a href="../index.php"><i class="fas fa-home"></i> Home</a>
        <a href="../recrutamento.php"><i class="fas fa-user-tie"></i> Recrutamento</a>
        <a href="../admin/logout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </nav>
</header>

<div class="dashboard-container">
    <div class="user-welcome">
        <div>
            <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Este é o seu painel pessoal na Alfa Engenharia & Construções.</p>
        </div>
        <i class="fas fa-user-circle" style="font-size: 4rem; color: #e2e8f0;"></i>
    </div>

    <div class="dashboard-grid">
        <a href="../recrutamento.php" class="dash-card">
            <i class="fas fa-file-invoice"></i>
            <h3>Candidatura / CV</h3>
            <p>Envie o seu currículo para as nossas vagas em aberto.</p>
        </a>

        <a href="../contact.php" class="dash-card">
            <i class="fas fa-envelope-open-text"></i>
            <h3>Suporte / Contacto</h3>
            <p>Tem alguma dúvida? Entre em contacto connosco diretamente.</p>
        </a>

        <a href="../portfolio.php" class="dash-card">
            <i class="fas fa-images"></i>
            <h3>Ver Portefólio</h3>
            <p>Explore os nossos projetos mais recentes.</p>
        </a>
    </div>
</div>

<footer class="main-footer" style="margin-top: 60px;">
    <div class="copyright-line">
        &copy; <?php echo date("Y"); ?> Alfa Engenharia & Construções. Todos os direitos reservados.
    </div>
</footer>

</body>
</html>
