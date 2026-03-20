<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Administrador - CRM Admin</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/admin_style.css">
</head>
<body>
    <a href="../index.php" class="logo">
        <div class="logo-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <span>CRM Premium Admin</span>
    </a>
    <div class="form-container">
        <h2>Área Administrativa</h2>

        <?php 
        session_start();
        // Exibir mensagens de feedback
        if (isset($_SESSION['admin_success'])) {
            echo '<p class="success-message">' . $_SESSION['admin_success'] . '</p>';
            unset($_SESSION['admin_success']); 
        }
        if (isset($_SESSION['admin_error'])) {
            echo '<p class="error-message">' . $_SESSION['admin_error'] . '</p>';
            unset($_SESSION['admin_error']);
        }
        ?>

        <form action="processa_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Entrar</button>
            </div>
            <p>Não tem conta de administrador? <a href="registo.php">Crie uma aqui</a>.</p>
        </form>
    </div>
</body>
</html>
