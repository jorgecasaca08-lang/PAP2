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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin/styles.css">
</head>
<body>

<div class="sidebar">
    <h2><i class="fas fa-tools"></i> Admin</h2>
    <p>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    <hr style="border: 0.5px solid #e2e8f0; margin: 20px 0;">
    <ul class="nav-links">
        <li><a href="admin.php?section=dashboard" <?php echo (isset($_GET['section']) && $_GET['section'] == 'dashboard') ? 'class="active"' : ''; ?>><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li><a href="admin.php?section=messages" <?php echo (!isset($_GET['section']) || $_GET['section'] == 'messages') ? 'class="active"' : ''; ?>><i class="fas fa-envelope"></i> Mensagens</a></li>
        <li><a href="admin.php?section=quotes" <?php echo (isset($_GET['section']) && $_GET['section'] == 'quotes') ? 'class="active"' : ''; ?>><i class="fas fa-file-invoice-dollar"></i> Orçamentos</a></li>
        <li><a href="admin.php?section=portfolio" <?php echo (isset($_GET['section']) && $_GET['section'] == 'portfolio') ? 'class="active"' : ''; ?>><i class="fas fa-images"></i> Portefólio</a></li>
        <li><a href="admin.php?section=users" <?php echo (isset($_GET['section']) && $_GET['section'] == 'users') ? 'class="active"' : ''; ?>><i class="fas fa-users"></i> Utilizadores</a></li>
        <li><a href="index.php"><i class="fas fa-external-link-alt"></i> Ver Site</a></li>
        <li><a href="admin/logout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
    </ul>
</div>

<div class="content">
    <?php
    $section = $_GET['section'] ?? 'dashboard';

    switch($section){
        case 'dashboard':
            // Fetch stats for dashboard
            $total_messages = 0;
            $total_quotes = 0;
            $total_users = 0;

            if($mysqli){
                $total_messages = $mysqli->query("SELECT id FROM messages")->num_rows;
                $total_quotes = $mysqli->query("SELECT id FROM quotes")->num_rows;
                $total_users = $mysqli->query("SELECT id FROM users")->num_rows;
            }

            echo "<h1>Painel Geral</h1>";
            echo "<div class='stats-grid'>";
            echo "<div class='stat-card'><h3>Mensagens</h3><div class='value'>$total_messages</div></div>";
            echo "<div class='stat-card'><h3>Orçamentos</h3><div class='value'>$total_quotes</div></div>";
            echo "<div class='stat-card'><h3>Utilizadores</h3><div class='value'>$total_users</div></div>";
            echo "</div>";

            echo "<h2>Ações Rápidas</h2>";
            echo "<div style='display: flex; gap: 20px;'>";
            echo "<a href='admin.php?section=messages' class='btn-primary' style='text-decoration:none;'>Ver Mensagens</a>";
            echo "<a href='admin.php?section=quotes' class='btn-primary' style='text-decoration:none;'>Gerir Orçamentos</a>";
            echo "</div>";
            break;
        case 'messages':
            echo "<h1>Gestão de Mensagens</h1>";
            echo "<section>";
            include 'includes/messages.php';
            echo "</section>";
            break;
        case 'quotes':
            echo "<h1>Gestão de Orçamentos</h1>";
            echo "<section>";
            include 'includes/quote_management.php';
            echo "</section>";
            break;
        case 'portfolio':
            echo "<h1>Gestão de Portefólio</h1>";
            echo "<section>";
            include 'includes/portfolio_management.php';
            echo "</section>";
            break;
        case 'users':
            echo "<h1>Gestão de Utilizadores</h1>";
            echo "<section>";
            include 'includes/user_management.php';
            echo "</section>";
            break;
        default:
            echo "<h1>Bem-vindo ao Dashboard</h1>";
    }
    ?>
</div>

</body>
</html>
