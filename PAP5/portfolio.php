<?php
$pageTitle = "Portefólio";
include 'includes/header.php';
require_once 'includes/config.php';
?>

<div class="banner">
    <h1>Portefólio de Projetos</h1>
    <h6>Conheça alguns dos projetos que temos desenvolvido ao longo dos anos.</h6>
</div>

<section class="section-light">
    <div class="container">
        <div class="card-container">
            <?php
            if (isset($mysqli) && $mysqli) {
                $sql = "SELECT * FROM portfolio ORDER BY created_at DESC";
                if($result = $mysqli->query($sql)){
                    if($result->num_rows > 0){
                        while($row = $result->fetch_array()){
                            $image_path = htmlspecialchars($row['image_path']);
                            // Ensure path is correct
                            if (!file_exists($image_path) && file_exists('assets/' . basename($image_path))) {
                                $image_path = 'assets/' . basename($image_path);
                            }
                            echo '<div class="card" data-aos="fade-up">';
                            echo '<img src="' . $image_path . '" alt="' . htmlspecialchars($row['title']) . '" onerror="this.src=\'assets/construcao.jpg\'">';
                            echo '<div class="card-content">';
                            echo '<div class="card-category">' . htmlspecialchars($row['category'] ?? 'Geral') . '</div>';
                            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        $result->free();
                    } else {
                        echo "<p>Nenhum projeto no portefólio no momento.</p>";
                    }
                } else {
                    echo "<p>O portefólio está temporariamente indisponível. Tente novamente mais tarde.</p>";
                }
            } else {
                echo "<div class='card' style='text-align: center; padding: 40px;'><h3>Portefólio Indisponível</h3><p>Não foi possível conectar à base de dados para carregar os projetos. Por favor, tente novamente mais tarde.</p></div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
