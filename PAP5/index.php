<?php
$pageTitle = "Alfa Engenharia & Construções";
include 'includes/header.php';
?>

<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo '<div class="success-message">A sua mensagem foi enviada com sucesso!</div>';
}
?>

<div class="banner">
    <h1>Bem-vindo à <span>Alfa Engenharia & Construções</span></h1>
    <h6>Soluções completas para a sua construção</h6>
</div>

<section>
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-right">
                <h2>Construindo o Futuro, Juntos</h2>
                <p>
                   Na Alfa Engenharia & Construções - Engenharia e Construções, estamos comprometidos com a qualidade, a inovação e a confiança em cada projeto que abraçamos. Mais do que construir estruturas, construímos relações sólidas com os nossos clientes, baseadas na transparência e no rigor técnico.
                </p>
                <p>
                    A nossa equipa multidisciplinar trabalha com dedicação em todas as fases — desde o estudo inicial até à entrega final — assegurando um acompanhamento personalizado, soluções eficientes e cumprimento rigoroso de prazos e orçamentos.
                </p>
            </div>
            <div class="flex-item" data-aos="fade-left">
                <img src="assets/casa-tijolos.jpg" alt="Imagem de boas-vindas">
            </div>
        </div>
    </div>
</section>

<section class="section-light">
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-left">
                <img src="assets/imagem-obra.jpg" alt="Imagem da equipa ou obra">
            </div>
            <div class="flex-item" data-aos="fade-right">
                <h2>Sobre Nós</h2>
                <p>
                    A Alfa Engenharia & Construções é uma empresa especializada em engenharia e construção civil, que valoriza a excelência técnica e a relação próxima com o cliente. Com uma equipa experiente e comprometida, desenvolvemos projetos residenciais, comerciais e industriais, sempre com foco em qualidade, sustentabilidade e inovação.
                </p>
                <a href="about.php" class="btn" data-aos="zoom-in">Saiba mais sobre nós</a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>Envie-nos uma mensagem</h2>
        <form action="submit_form.php" method="POST">
        <label for="email" data-aos="zoom-in">Email:</label>
        <input type="email" id="email" name="Email" required data-aos="fade-right">

        <label for="assunto" data-aos="zoom-in">Assunto:</label>
        <input type="text" id="assunto" name="Assunto" required data-aos="fade-right">

        <label for="mensagem" data-aos="zoom-in">Mensagem:</label>
        <textarea id="mensagem" name="Mensagem" rows="6" required data-aos="fade-right"></textarea>

        <button type="submit" class="btn" data-aos="zoom-out">Enviar</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>