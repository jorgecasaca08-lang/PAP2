<?php
session_start();
$pageTitle = "Alfa Engenharia & Construções - Inovação e Qualidade";
include 'includes/header.php';
?>

<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo '<div style="background: var(--success); color: white; padding: 15px; text-align: center; border-radius: var(--radius-md); max-width: 600px; margin: 20px auto; font-weight: 600; box-shadow: var(--shadow-lg);">A sua mensagem foi enviada com sucesso!</div>';
}
?>

<div class="banner">
    <div class="container">
        <h1 data-aos="fade-up">Construímos o seu <span>Sucesso</span> com Rigor e Inovação</h1>
        <h6 data-aos="fade-up" data-aos-delay="200">Soluções integradas de engenharia e construção para projetos residenciais, comerciais e industriais de alto padrão.</h6>
        <div class="mt-4" data-aos="fade-up" data-aos-delay="400" style="display: flex; gap: 20px; justify-content: center;">
            <a href="services.php" class="btn">Nossos Serviços</a>
            <a href="contact.php" class="btn" style="background: transparent; border: 2px solid var(--white); box-shadow: none;">Contacte-nos</a>
        </div>
    </div>
</div>

<div class="container" style="position: relative; z-index: 10; margin-top: -80px; display: flex; justify-content: center;">
    <section style="background: white; border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); padding: 80px 60px; width: 100%; max-width: 1120px; margin: 0;">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-right" style="flex: 1.2;">
                <h3 style="color: var(--accent-color); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 2px; margin-bottom: 10px;">Quem Somos</h3>
                <h2 style="text-align: left; margin-bottom: 30px; font-size: 2.75rem; line-height: 1.2;">Comprometidos com a <br><span>Excelência e Confiança</span></h2>
                <p>
                   Na <strong>Alfa Engenharia & Construções</strong>, cada projeto é uma oportunidade de demonstrar o nosso compromisso com a qualidade e a inovação. Mais do que construir estruturas, construímos relações sólidas com os nossos clientes.
                </p>
                <p>
                    A nossa equipa multidisciplinar assegura um acompanhamento personalizado, soluções eficientes e cumprimento rigoroso de prazos e orçamentos em todas as fases da obra.
                </p>
                <a href="about.php" class="btn" style="padding: 14px 35px; font-size: 1rem;">Conhecer a nossa História</a>
            </div>
            <div class="flex-item" data-aos="fade-left" style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <div style="position: relative; width: 100%; max-width: 500px;">
                    <img src="assets/casa-tijolos.jpg" alt="Construção Alfa" style="width: 100%; border-radius: var(--radius-lg); display: block; box-shadow: var(--shadow-lg);">
                    <div style="position: absolute; bottom: -20px; right: -20px; background: #FFD700; color: #0f172a; padding: 25px 30px; border-radius: var(--radius-lg); box-shadow: var(--shadow-xl); text-align: center; border: 5px solid white; z-index: 20;">
                        <p style="font-size: 3rem; font-weight: 900; margin: 0; line-height: 1;">15+</p>
                        <p style="margin: 5px 0 0 0; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; white-space: nowrap;">Anos de Experiência</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="section-light" style="background: #f1f5f9;">
    <div class="container">
        <h3 style="color: var(--accent-color); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 2px; margin-bottom: 10px; text-align: center;">Serviços</h3>
        <h2 style="margin-bottom: 80px;">Soluções Completas de Engenharia</h2>
        <div class="card-container">
            <div class="card" data-aos="fade-up">
                <img src="assets/casa.jpg" alt="Construção Residencial">
                <div class="card-content">
                    <span class="card-category">Construção</span>
                    <h3>Residencial</h3>
                    <p style="font-size: 0.95rem;">Construímos a casa dos seus sonhos com materiais de alta qualidade e design moderno.</p>
                </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/naoresidencial1.png" alt="Construção Comercial">
                <div class="card-content">
                    <span class="card-category">Empresarial</span>
                    <h3>Comercial</h3>
                    <p style="font-size: 0.95rem;">Espaços comerciais inovadores que refletem a identidade da sua marca e otimizam a produtividade.</p>
                </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <img src="assets/construcao.jpg" alt="Manutenção e Obras">
                <div class="card-content">
                    <span class="card-category">Manutenção</span>
                    <h3>Reabilitação</h3>
                    <p style="font-size: 0.95rem;">Transformamos espaços antigos em ambientes modernos e funcionais, respeitando a sua essência.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="background: var(--white);">
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-right">
                <div style="background: var(--bg-light); padding: 50px; border-radius: var(--radius-xl); border: 1px solid #f1f5f9;">
                    <h3 style="color: var(--accent-color); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 2px; margin-bottom: 10px;">Contacte-nos</h3>
                    <h2 style="text-align: left; margin-bottom: 30px;">Pronto para Começar?</h2>
                    <p>Entre em contacto para um orçamento personalizado ou para esclarecer qualquer dúvida sobre o seu projeto.</p>

                    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                        <div style="width: 50px; height: 50px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-md); color: var(--accent-color);">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Telefone</p>
                            <p style="margin: 0; font-weight: 700; color: var(--primary-color);">+351 912 345 678</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-md); color: var(--accent-color);">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Email</p>
                            <p style="margin: 0; font-weight: 700; color: var(--primary-color);">geral@alfaengenharia.pt</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-item" data-aos="fade-left">
                <form action="submit_form.php" method="POST" style="margin: 0; box-shadow: var(--shadow-xl);">
                    <div class="form-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="Nome" required placeholder="Seu nome">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Corporativo</label>
                        <input type="email" id="email" name="Email" required placeholder="exemplo@empresa.com">
                    </div>
                    <div class="form-group">
                        <label for="assunto">Assunto</label>
                        <input type="text" id="assunto" name="Assunto" required placeholder="Como podemos ajudar?">
                    </div>
                    <div class="form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" name="Mensagem" rows="4" required placeholder="Conte-nos sobre o seu projeto..."></textarea>
                    </div>
                    <button type="submit" class="btn" style="width: 100%;">Enviar Pedido de Contacto</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
