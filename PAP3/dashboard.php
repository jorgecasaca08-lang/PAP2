<?php
session_start();
// Check if user is logged in and is a regular user (or admin)
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}
require_once 'includes/config.php';

// Initialize CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$user_id = $_SESSION['id'];
$success_msg = '';
$error_msg = '';

// Handle Quote Request
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_quote'])){
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }
    $service = $_POST['service'];
    $description = $_POST['description'];

    $sql = "INSERT INTO quotes (user_id, service, description) VALUES (?, ?, ?)";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("iss", $user_id, $service, $description);
        if($stmt->execute()){
            $success_msg = "Pedido de orçamento enviado com sucesso!";
        } else {
            $error_msg = "Erro ao enviar pedido de orçamento.";
        }
        $stmt->close();
    }
}

// Handle Priority Contact
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['priority_contact'])){
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $name = $_SESSION['username'];
    $email = $_SESSION['email'] ?? "utilizador_" . $user_id . "@alfaengenharia.pt";

    $sql = "INSERT INTO messages (name, email, subject, message, user_id, is_priority) VALUES (?, ?, ?, ?, ?, 1)";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("ssssi", $name, $email, $subject, $message, $user_id);
        if($stmt->execute()){
            $success_msg = "Mensagem prioritária enviada!";
        } else {
            $error_msg = "Erro ao enviar mensagem.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Área de Cliente - Alfa Engenharia & Construções</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="public/css/user_dashboard.css">
</head>
<body>

<div class="dashboard-container">
    <header class="dash-header" data-aos="fade-down">
        <div>
            <h1><i class="fas fa-user-circle"></i> Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Bem-vindo à sua área reservada e segura.</p>
        </div>
        <div>
            <a href="index.php" class="btn-submit" style="text-decoration: none; background: #6c757d;"><i class="fas fa-globe"></i> Voltar ao Site</a>
            <a href="admin/logout.php" class="btn-submit" style="text-decoration: none; background: #dc3545;"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </div>
    </header>

    <?php if($success_msg): ?>
        <div class="alert alert-success" data-aos="zoom-in"><i class="fas fa-check-circle"></i> <?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if($error_msg): ?>
        <div class="alert alert-danger" data-aos="zoom-in"><i class="fas fa-exclamation-triangle"></i> <?php echo $error_msg; ?></div>
    <?php endif; ?>

    <div class="dashboard-grid">
        <!-- Form Pedido de Orçamento -->
        <div class="dashboard-card" data-aos="fade-up">
            <h3><i class="fas fa-file-invoice"></i> Solicitar Orçamento</h3>
            <form action="dashboard.php" method="post" style="padding:0; box-shadow:none; width:100%; max-width:100%;">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label>Tipo de Serviço</label>
                    <select name="service" required>
                        <option value="Construção Civil">Construção Civil</option>
                        <option value="Remodelações">Remodelações</option>
                        <option value="Pintura">Pintura</option>
                        <option value="Eletricidade/Canalização">Eletricidade/Canalização</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Descrição do Projeto</label>
                    <textarea name="description" rows="5" required placeholder="Descreva brevemente o que pretende..."></textarea>
                </div>
                <button type="submit" name="request_quote" class="btn-submit"><i class="fas fa-paper-plane"></i> Enviar Pedido</button>
            </form>
        </div>

        <!-- Form Contacto Prioritário -->
        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="100">
            <h3><i class="fas fa-headset"></i> Contacto Prioritário</h3>
            <p style="font-size: 0.9rem; color: #666; margin-bottom: 25px;">Obrigado por ser nosso cliente. A sua mensagem será tratada com prioridade máxima.</p>
            <form action="dashboard.php" method="post" style="padding:0; box-shadow:none; width:100%; max-width:100%;">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label>Assunto</label>
                    <input type="text" name="subject" required placeholder="Assunto da mensagem">
                </div>
                <div class="form-group">
                    <label>Mensagem</label>
                    <textarea name="message" rows="5" required placeholder="Sua mensagem detalhada..."></textarea>
                </div>
                <button type="submit" name="priority_contact" class="btn-submit"><i class="fas fa-envelope"></i> Enviar Mensagem</button>
            </form>
        </div>
    </div>

    <!-- Seção de Status -->
    <div class="dashboard-card" data-aos="fade-up" data-aos-delay="200">
        <h3><i class="fas fa-history"></i> Os Meus Orçamentos</h3>
        <?php
        $sql = "SELECT * FROM quotes WHERE user_id = ? ORDER BY created_at DESC";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                echo "<table class='status-table'>";
                echo "<thead><tr><th>Data</th><th>Serviço</th><th>Estado</th><th>Valor Estimado</th></tr></thead>";
                echo "<tbody>";
                while($row = $result->fetch_assoc()){
                    $status_class = ($row['status'] == 'pending') ? 'status-pending' : 'status-responded';
                    $status_text = ($row['status'] == 'pending') ? 'Pendente' : 'Respondido';
                    $budget_text = ($row['budget']) ? number_format($row['budget'], 2) . " €" : "---";
                    echo "<tr>";
                    echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['service']) . "</td>";
                    echo "<td><span class='status-badge $status_class'>$status_text</span></td>";
                    echo "<td><strong>$budget_text</strong></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Ainda não solicitou nenhum orçamento.</p>";
            }
            $stmt->close();
        }
        ?>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
</body>
</html>
