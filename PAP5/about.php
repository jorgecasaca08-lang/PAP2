<?php
$pageTitle = "Sobre Nós";
include 'includes/header.php';
?>

<div class="banner">
    <h1>Sobre Nós</h1>
    <h6>Conheça a nossa história, visão e valores</h6>
</div>

<section class="section-light">
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-left">
                <img src="assets/construcao.jpg" alt="Imagem sobre a empresa 1">
            </div>
            <div class="flex-item" data-aos="fade-right">
                <h3>A Nossa História</h3>
                <p>A Alfa Engenharia & Construções foi fundada com o objetivo de transformar sonhos em realidade. Com mais de 20 anos de experiência no setor de engenharia e construção, a nossa missão sempre foi entregar qualidade, confiança e inovação em cada projeto.</p>
                <p>A nossa jornada começou com projetos de menor escala, mas com o tempo fomos ganhando a confiança dos nossos clientes, ampliando a nossa atuação e enfrentando maiores desafios no setor da construção.</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-right">
                <h3>A Nossa Visão</h3>
                <p>A nossa visão é ser uma empresa de referência em engenharia e construção, reconhecida pela qualidade e inovação dos nossos projetos. Estamos sempre à procura de novas soluções e tecnologias que melhorem a eficiência dos nossos processos e a satisfação dos nossos clientes.</p>
                <p>Acreditamos na construção sustentável e num futuro em que os nossos projetos contribuam para o bem-estar das pessoas e para a preservação do meio ambiente.</p>
            </div>
            <div class="flex-item" data-aos="fade-left">
                <img src="assets/camiao.jpg" alt="Imagem sobre a empresa 2">
            </div>
        </div>
    </div>
</section>

<section class="section-light">
    <div class="container">
        <div class="flex-container">
            <div class="flex-item" data-aos="fade-left">
                <img src="assets/casa-obra.jpg" alt="Imagem sobre a empresa 3">
            </div>
            <div class="flex-item" data-aos="fade-right">
                <h3>Os Nossos Valores</h3>
                <p>Na Alfa Engenharia & Construções, os nossos valores fundamentais são a base para todos os nossos projetos. Comprometemo-nos com a qualidade, inovação, integridade e respeito pelos nossos clientes e pela nossa equipa. A transparência e a ética no trabalho são princípios inegociáveis para nós.</p>
                <p>Trabalhamos de forma colaborativa e acreditamos que a confiança mútua é a chave para o sucesso em qualquer projeto. O nosso compromisso com a excelência impulsiona-nos a superar as expectativas dos nossos clientes e a melhorar continuamente.</p>
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