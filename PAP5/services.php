<?php
$pageTitle = "Serviços";
include 'includes/header.php';
?>

<div class="banner">
    <h1>Os nossos Serviços</h1>
    <h6>Soluções completas para a sua construção</h6>
</div>

<section class="section-light" style="background: var(--bg-light);">
    <div class="container">
        <h3 style="color: var(--accent-color); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 2px; margin-bottom: 10px; text-align: center;">O que Fazemos</h3>
        <h2 style="margin-bottom: 80px;">Nossas Soluções</h2>
        <div class="card-container">
            <div class="card" data-aos="fade-up">
                <div style="overflow: hidden;">
                    <img src="assets/construcao.jpg" alt="Construção Civil">
                </div>
                <div class="card-content">
                    <div class="card-category"><i class="fas fa-hammer"></i> Engenharia</div>
                    <h3>Construção Civil</h3>
                    <p>Executamos projetos de construção de raiz, desde moradias a edifícios comerciais, garantindo qualidade e rigor em todas as fases da obra.</p>
                    <a href="contact.php" style="margin-top: auto; color: var(--accent-color); text-decoration: none; font-weight: 700; font-size: 0.9rem;">Solicitar Proposta <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="100">
                <div style="overflow: hidden;">
                    <img src="assets/casa-obra.jpg" alt="Reabilitação de Edifícios">
                </div>
                <div class="card-content">
                    <div class="card-category"><i class="fas fa-paint-roller"></i> Renovação</div>
                    <h3>Reabilitação de Edifícios</h3>
                    <p>Recuperamos e modernizamos edifícios antigos, preservando a sua identidade arquitetónica e adaptando-os às necessidades atuais.</p>
                    <a href="contact.php" style="margin-top: auto; color: var(--accent-color); text-decoration: none; font-weight: 700; font-size: 0.9rem;">Solicitar Proposta <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div style="overflow: hidden;">
                    <img src="assets/imagem-obra.jpg" alt="Gestão de Projetos">
                </div>
                <div class="card-content">
                    <div class="card-category"><i class="fas fa-clipboard-check"></i> Gestão</div>
                    <h3>Gestão de Projetos</h3>
                    <p>Oferecemos um serviço completo de gestão de projetos, coordenando todas as equipas e processos para garantir o cumprimento de prazos e orçamentos.</p>
                    <a href="contact.php" style="margin-top: auto; color: var(--accent-color); text-decoration: none; font-weight: 700; font-size: 0.9rem;">Solicitar Proposta <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
