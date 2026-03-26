<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Alfa Engenharia & Construções"; ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/alfa-icon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

<header class="main-header">
    <div class="logo-container">
        <a href="index.php" class="logo-link">
            <div class="logo-text">
                <span class="alfa">Alfa</span>
                <span class="subtext">ENGENHARIA & CONSTRUÇÕES</span>
            </div>
        </a>
    </div>
    <nav class="main-nav">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> Acerca</a>
        <a href="services.php"><i class="fas fa-tools"></i> Serviços</a>
        <a href="portfolio.php"><i class="fas fa-images"></i> Portefólio</a>
        <a href="recrutamento.php"><i class="fas fa-user-tie"></i> Recrutamento</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contactos</a>
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php"><i class="fas fa-chart-line"></i> Admin</a>
            <?php else: ?>
                <a href="dashboard/index.php"><i class="fas fa-user-circle"></i> Dashboard</a>
            <?php endif; ?>
            <a href="admin/logout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i></a>
        <?php else: ?>
            <a href="login.php" target="_blank"><i class="fas fa-lock"></i> Login</a>
        <?php endif; ?>
    </nav>
</header>
