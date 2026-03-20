<?php
// Quote Management Logic

// Update quote with budget
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quote'])){
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }

    $quote_id = $_POST['quote_id'];
    $budget = $_POST['budget'];

    $sql = "UPDATE quotes SET budget = ?, status = 'responded' WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("di", $budget, $quote_id);
        if($stmt->execute()){
            $quote_success = "Orçamento atualizado com sucesso!";
        } else {
            $quote_err = "Erro ao atualizar orçamento.";
        }
        $stmt->close();
    }
}
?>

<div class="quote-management">
    <?php
    if(isset($quote_err)) echo "<div class='alert alert-danger'>$quote_err</div>";
    if(isset($quote_success)) echo "<div class='alert alert-success'>$quote_success</div>";
    ?>

    <h3>Pedidos de Orçamento</h3>
    <?php
    $sql = "SELECT q.*, u.username FROM quotes q JOIN users u ON q.user_id = u.id ORDER BY q.created_at DESC";
    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){
            echo "<table class='table'>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Utilizador</th>";
                        echo "<th>Serviço</th>";
                        echo "<th>Descrição</th>";
                        echo "<th>Orçamento (€)</th>";
                        echo "<th>Estado</th>";
                        echo "<th>Ação</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $result->fetch_array()){
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['service']) . "</td>";
                        echo "<td>" . nl2br(htmlspecialchars($row['description'])) . "</td>";
                        echo "<td>" . ($row['budget'] ? number_format($row['budget'], 2) . " €" : "Pendente") . "</td>";
                        echo "<td>" . ($row['status'] == 'pending' ? "<span style='color: orange;'>Pendente</span>" : "<span style='color: green;'>Respondido</span>") . "</td>";
                        echo "<td>";
                        ?>
                        <form action="admin.php?section=quotes" method="post" style="background: none; padding: 0; margin: 0; border: none;">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="quote_id" value="<?php echo $row['id']; ?>">
                            <input type="number" step="0.01" name="budget" placeholder="Valor" required style="width: 80px; padding: 5px; margin-bottom: 5px;">
                            <input type="submit" name="update_quote" value="Enviar" class="btn" style="padding: 5px 10px; font-size: 12px;">
                        </form>
                        <?php
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
            echo "</table>";
            $result->free();
        } else{
            echo "<p>Nenhum pedido de orçamento encontrado.</p>";
        }
    }
    ?>
</div>
