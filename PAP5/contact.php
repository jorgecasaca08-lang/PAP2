<?php
$pageTitle = "Contactos";
include 'includes/header.php';
?>

<div class="banner">
    <h1>Contacte a Alfa Engenharia & Construções</h1>
    <h6>Estamos aqui para ajudar a transformar as suas ideias em realidade.</h6>
</div>

<section>
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-right">
                <h2>Fale Connosco</h2>
                <form action="submit_form.php" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="Nome" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="Email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="Telefone" required>
                    </div>

                    <div class="form-group">
                        <label for="assunto">Assunto:</label>
                        <input type="text" id="assunto" name="Assunto" required>
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Mensagem:</label>
                        <textarea id="mensagem" name="Mensagem" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn">Enviar Mensagem</button>
                </form>
            </div>
            <div class="flex-item" data-aos="fade-left">
                <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: var(--shadow-lg);">
                    <h2>Informações</h2>

                    <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                        <i class="fas fa-map-marker-alt" style="color: var(--accent-color); font-size: 1.5rem; margin-top: 5px;"></i>
                        <div>
                            <h4 style="margin: 0 0 5px 0;">Endereço</h4>
                            <p style="margin: 0;">Rua Imaginária, 123<br>Castelo de Paiva, Portugal</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                        <i class="fas fa-envelope" style="color: var(--accent-color); font-size: 1.5rem; margin-top: 5px;"></i>
                        <div>
                            <h4 style="margin: 0 0 5px 0;">Email</h4>
                            <p style="margin: 0;"><a href="mailto:jorgecasaca14942@aecpaiva.pt" style="color: var(--primary-color); text-decoration: none;">geral@alfaengenharia.pt</a></p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                        <i class="fas fa-phone-alt" style="color: var(--accent-color); font-size: 1.5rem; margin-top: 5px;"></i>
                        <div>
                            <h4 style="margin: 0 0 5px 0;">Telefone</h4>
                            <p style="margin: 0;">+351 912 345 678</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                        <i class="fas fa-clock" style="color: var(--accent-color); font-size: 1.5rem; margin-top: 5px;"></i>
                        <div>
                            <h4 style="margin: 0 0 5px 0;">Horário</h4>
                            <p style="margin: 0;">Seg - Sex: 9h às 12h / 13h às 18h<br>Sáb - Dom: Fechado</p>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <a href="terms.php" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">Política de Privacidade</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
