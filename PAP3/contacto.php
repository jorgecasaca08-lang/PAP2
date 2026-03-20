<?php
// jules_session_15948597006436413439/contacto.php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - CRM Premium</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <a href="index.php" class="logo">
        <div class="logo-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <span>CRM Premium</span>
    </a>

    <div class="form-container">
        <h2>Contacte-nos</h2>
        <p style="text-align: center; color: #666; margin-bottom: 25px;">Estamos aqui para ajudar com qualquer questão.</p>

        <?php 
        if (isset($_SESSION['success_message'])) {
            echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']); 
        }
        ?>

        <form action="#" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required placeholder="Seu nome">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="seu@email.com">
            </div>
            <div class="form-group">
                <label for="assunto">Assunto</label>
                <input type="text" id="assunto" name="assunto" required placeholder="Como podemos ajudar?">
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea id="mensagem" name="mensagem" required rows="5" placeholder="Sua mensagem detalhada..."></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Enviar Mensagem</button>
            </div>
        </form>
    </div>

    <a href="index.php" style="margin-top: 20px; text-decoration: none; color: var(--primary-color); font-weight: 600;">← Voltar para a Home</a>
</body>
</html>
