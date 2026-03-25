<?php
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        echo '<div class="message-grid">';
        while($row = $result->fetch_array()){
            echo '<div class="message-card">';
                echo '<div class="message-header">';
                    echo '<span>ID: #' . htmlspecialchars($row['id']) . '</span>';
                    echo '<span>' . htmlspecialchars($row['created_at']) . '</span>';
                echo '</div>';
                echo '<h4>' . htmlspecialchars($row['subject']) . '</h4>';
                echo '<p><strong>De:</strong> ' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['email']) . ')</p>';
                echo '<div class="message-body">';
                    echo '<p>' . nl2br(htmlspecialchars($row['message'])) . '</p>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        $result->free();
    } else{
        echo "<p>Nenhuma mensagem encontrada.</p>";
    }
} else{
    echo "ERRO: Não foi possível executar $sql. " . $mysqli->error;
}
?>
