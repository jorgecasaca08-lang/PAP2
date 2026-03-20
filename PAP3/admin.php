<?php
session_start();
// Check if user is logged in and is an admin
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin'){
    header("location: login.php");
    exit;
}
require_once 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrativo - Alfa Engenharia & Construções</title>
    <link rel="stylesheet" href="admin/styles.css">
    <style>
        .sidebar {
            width: 250px;
            float: left;
            background: #f8f9fa;
            padding: 20px;
            min-height: 100vh;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .nav-links {
            list-style: none;
            padding: 0;
        }
        .nav-links li {
            margin-bottom: 10px;
        }
        .nav-links a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .nav-links a:hover, .nav-links a.active {
            background: #007bff;
            color: #white;
        }
        .nav-links a.active { color: white; }
        .nav-links a:hover { color: white; }

        .section-card {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <p>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    <hr>
    <ul class="nav-links">
        <li><a href="admin.php?section=messages" <?php echo (!isset($_GET['section']) || $_GET['section'] == 'messages') ? 'class="active"' : ''; ?>>Mensagens</a></li>
        <li><a href="admin.php?section=quotes" <?php echo (isset($_GET['section']) && $_GET['section'] == 'quotes') ? 'class="active"' : ''; ?>>Orçamentos</a></li>
        <li><a href="admin.php?section=portfolio" <?php echo (isset($_GET['section']) && $_GET['section'] == 'portfolio') ? 'class="active"' : ''; ?>>Portefólio</a></li>
        <li><a href="admin.php?section=users" <?php echo (isset($_GET['section']) && $_GET['section'] == 'users') ? 'class="active"' : ''; ?>>Utilizadores</a></li>
        <li><a href="index.php">Ver Site</a></li>
        <li><a href="admin/logout.php" style="color: #dc3545;">Sair</a></li>
    </ul>
</div>

<div class="content">
    <?php
    $section = $_GET['section'] ?? 'messages';

    switch($section){
        case 'messages':
            echo "<h1>Gestão de Mensagens</h1>";
            echo "<div class='section-card'>";
            include 'includes/messages.php';
            echo "</div>";
            break;
        case 'quotes':
            echo "<h1>Gestão de Orçamentos</h1>";
            echo "<div class='section-card'>";
            include 'includes/quote_management.php';
            echo "</div>";
            break;
        case 'portfolio':
            echo "<h1>Gestão de Portefólio</h1>";
            echo "<div class='section-card'>";
            include 'includes/portfolio_management.php';
            echo "</div>";
            break;
        case 'users':
            echo "<h1>Gestão de Utilizadores</h1>";
            echo "<div class='section-card'>";
            include 'includes/user_management.php';
            echo "</div>";
            break;
        default:
            echo "<h1>Bem-vindo ao Dashboard</h1>";
    }
    ?>
</div>

</body>
</html>
