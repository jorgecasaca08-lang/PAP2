<?php
session_start();
require_once 'includes/config.php';

// Initialize CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pageTitle = "Recrutamento - Alfa Engenharia & Construções";
include 'includes/header.php';
?>

<div class="banner">
    <h1>Trabalhe Connosco</h1>
    <h6>Junte-se à nossa equipa e ajude-nos a construir o futuro.</h6>
</div>

<section>
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-up">
                <h2 class="text-center">Envie o seu Currículo</h2>
                <p class="text-center">Estamos sempre à procura de novos talentos. Preencha o formulário abaixo e anexe o seu CV.</p>

                <?php
                if (isset($_GET['status'])) {
                    if ($_GET['status'] == 'success') {
                        echo '<div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; border: 1px solid #c3e6cb;">Currículo enviado com sucesso! Entraremos em contacto em breve.</div>';
                    } elseif ($_GET['status'] == 'error') {
                        $msg = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Ocorreu um erro ao enviar o seu currículo. Por favor, tente novamente.';
                        echo '<div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; border: 1px solid #f5c6cb;">' . $msg . '</div>';
                    }
                }
                ?>

                <form action="processa_recrutamento.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                    <div class="form-group">
                        <label for="nome">Nome Completo:</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" required>
                    </div>

                    <div class="form-group">
                        <label for="cv">Anexar Currículo (PDF, DOC, DOCX):</label>
                        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required style="padding: 10px 0;">
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Informações Adicionais / Mensagem:</label>
                        <textarea id="mensagem" name="mensagem" rows="6"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn">Submeter Candidatura</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
