
<footer class="main-footer">
    <div class="footer-container">

        <!-- Sobre -->
        <div class="footer-column">
            <h4>Alfa Engenharia & Construções</h4>
            <p>Especialistas em transformar a sua visão em realidade através de engenharia de precisão e construção de qualidade.</p>
        </div>

        <!-- Contacto -->
        <div class="footer-column">
            <h4>Contactos</h4>
            <p><i class="fas fa-envelope"></i> <a href="mailto:jorgecasaca14942@aecpaiva.pt">geral@alfaengenharia.pt</a></p>
            <p><i class="fas fa-phone"></i> +351 912 345 678</p>
        </div>

        <!-- Links Rápidos -->
        <div class="footer-column">
            <h4>Links</h4>
            <p><a href="terms.php">Privacidade</a></p>
            <p><a href="https://www.livroreclamacoes.pt/Inicio/" target="_blank">Livro de Reclamações Online</a></p>
        </div>

    </div>

    <!-- Linha de direitos autorais -->
    <div class="copyright-line">
        &copy; <?php echo date("Y"); ?> Alfa Engenharia & Construções - Todos os direitos reservados.
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>

<!-- Modal de Aceitação da Política -->
<div id="politicaModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; display: none; align-items: center; justify-content: center;">
  <div class="modal-content" style="background: white; padding: 40px; border-radius: 12px; max-width: 500px; width: 90%; text-align: center;">
    <i class="fas fa-shield-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 20px;"></i>
    <h2>Privacidade</h2>
    <p>
      Este site utiliza dados de contacto apenas para fins de resposta. Ao continuar, confirma que aceita a nossa
      <a href="terms.php" style="color: var(--accent-color); font-weight: 600;">Política de Privacidade</a>.
    </p>
    <br>
    <button id="accept-privacy" class="btn" onclick="aceitarPolitica()">
      Compreendo e Aceito
    </button>
  </div>
</div>


<!-- Script -->
<script>
  function aceitarPolitica() {
    localStorage.setItem('politicaAceite', 'sim');
    document.getElementById("politicaModal").style.display = "none";
  }

  window.onload = function () {
    const politicaAceite = localStorage.getItem('politicaAceite');
    if (!politicaAceite) {
      document.getElementById("politicaModal").style.display = "flex";
    }
  };
</script>


</body>
</html>
