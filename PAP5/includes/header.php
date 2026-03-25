<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Alfa Engenharia & Construções"; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/ND-Engenharia-branco-azul.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

<header class="main-header">
    <div class="logo-container">
        <a href="index.php" class="logo-link">
            <img src="assets/alfa-logo.png" alt="Alfa Engenharia Logo" class="logo-image">
        </a>
    </div>
    <nav class="main-nav">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> Acerca</a>
        <a href="services.php"><i class="fas fa-tools"></i> Serviços</a>
        <a href="portfolio.php"><i class="fas fa-images"></i> Portefólio</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contactos</a>
        <a href="login.php" target="_blank"><i class="fas fa-lock"></i> Login</a>
    </nav>
</header>
