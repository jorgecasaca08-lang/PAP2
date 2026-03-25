<!DOCTYPE html>
<html lang="pt">
<?php
// Calculate base path to ensure assets work in subdirectories
$script_path = $_SERVER['SCRIPT_NAME'];
// Find where the project root is (handle both /PAP3/ and /)
if (strpos($script_path, '/PAP3/') !== false) {
    $relative_path = explode('/PAP3/', $script_path)[1];
} else {
    $relative_path = ltrim($script_path, '/');
}
$num_subdirs = substr_count($relative_path, '/');
$base_url = str_repeat('../', $num_subdirs);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Alfa Engenharia & Construções"; ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo $base_url; ?>assets/ND-Engenharia-branco-azul.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/main.css">
</head>
<body>

<header class="main-header">
    <div class="logo-container">
        <a href="<?php echo $base_url; ?>index.php" class="logo-link">
            <img src="<?php echo $base_url; ?>assets/alfa-logo.png" alt="Alfa Engenharia & Construções Logo" class="logo-image">
        </a>
    </div>
    <nav class="main-nav">
        <a href="<?php echo $base_url; ?>index.php"><i class="fas fa-home"></i> Home</a>
        <a href="<?php echo $base_url; ?>about.php"><i class="fas fa-info-circle"></i> Acerca</a>
        <a href="<?php echo $base_url; ?>services.php"><i class="fas fa-tools"></i> Serviços</a>
        <a href="<?php echo $base_url; ?>portfolio.php"><i class="fas fa-images"></i> Portefólio</a>
        <a href="<?php echo $base_url; ?>contact.php"><i class="fas fa-envelope"></i> Contactos</a>
        <a href="<?php echo $base_url; ?>login.php"><i class="fas fa-lock"></i> Login</a>
    </nav>
</header>
