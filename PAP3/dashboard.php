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
    <link rel="stylesheet" href="styles/main.css">
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .card h3 {
            margin-top: 0;
            color: #0056b3;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .btn-submit {
            background: #0056b3;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-submit:hover { background: #004494; }
        .status-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .status-table th, .status-table td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        .status-pending { color: orange; font-weight: bold; }
        .status-responded { color: green; font-weight: bold; }
        .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }

        header.dash-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <header class="dash-header">
        <div>
            <h1>Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Bem-vindo à sua área reservada.</p>
        </div>
        <div>
            <a href="index.php" class="btn-submit" style="text-decoration: none; background: #6c757d;">Voltar ao Site</a>
            <a href="admin/logout.php" class="btn-submit" style="text-decoration: none; background: #dc3545;">Sair</a>
        </div>
    </header>

    <?php if($success_msg): ?>
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if($error_msg): ?>
        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <div class="grid">
        <!-- Form Pedido de Orçamento -->
        <div class="card">
            <h3>Solicitar Orçamento</h3>
            <form action="dashboard.php" method="post">
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
                <button type="submit" name="request_quote" class="btn-submit">Enviar Pedido</button>
            </form>
        </div>

        <!-- Form Contacto Prioritário -->
        <div class="card">
            <h3>Contacto Prioritário</h3>
            <p style="font-size: 0.85em; color: #666; margin-bottom: 15px;">Como cliente registado, as suas mensagens têm prioridade de resposta.</p>
            <form action="dashboard.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label>Assunto</label>
                    <input type="text" name="subject" required>
                </div>
                <div class="form-group">
                    <label>Mensagem</label>
                    <textarea name="message" rows="5" required></textarea>
                </div>
                <button type="submit" name="priority_contact" class="btn-submit">Enviar Mensagem</button>
            </form>
        </div>
    </div>

    <!-- Seção de Status -->
    <div class="card">
        <h3>Os Meus Orçamentos</h3>
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
                    echo "<td><span class='$status_class'>$status_text</span></td>";
                    echo "<td>$budget_text</td>";
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

</body>
</html>
