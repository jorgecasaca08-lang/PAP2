<?php
session_start();
// Check if user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: ../login.php");
    exit;
}

$pageTitle = "Dashboard do Utilizador - Alfa Engenharia & Construções";
require_once '../includes/config.php';

$section = $_GET['section'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/main.css">
    <style>
        body { padding-top: 0; display: flex; min-height: 100vh; background: #f1f5f9; }
        .sidebar { width: 260px; background: #1e293b; color: white; padding: 30px 0; display: flex; flex-direction: column; }
        .sidebar h2 { color: white; margin: 0 30px 40px; font-size: 1.5rem; text-align: left; }
        .sidebar .nav-links { list-style: none; padding: 0; flex-grow: 1; }
        .sidebar .nav-links li a { display: block; padding: 15px 30px; color: #94a3b8; text-decoration: none; transition: 0.3s; }
        .sidebar .nav-links li a:hover, .sidebar .nav-links li a.active { background: #334155; color: white; }
        .sidebar .nav-links li a i { margin-right: 12px; width: 20px; text-align: center; }

        .main-content { flex-grow: 1; padding: 40px; box-sizing: border-box; overflow-y: auto; }
        .welcome-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 30px; }

        .form-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .table th { background: #f8fafc; font-weight: 600; }

        .chat-container { display: flex; flex-direction: column; height: 500px; background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .chat-messages { flex-grow: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; }
        .message { max-width: 70%; padding: 12px 16px; border-radius: 12px; font-size: 0.95rem; line-height: 1.4; }
        .message.sent { align-self: flex-end; background: #0056b3; color: white; border-bottom-right-radius: 2px; }
        .message.received { align-self: flex-start; background: #f1f5f9; color: #1e293b; border-bottom-left-radius: 2px; }
        .chat-input { padding: 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 10px; }
        .chat-input input { flex-grow: 1; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

<aside class="sidebar">
    <h2><i class="fas fa-tools"></i> Alfa User</h2>
    <ul class="nav-links">
        <li><a href="index.php?section=dashboard" <?php echo ($section == 'dashboard') ? 'class="active"' : ''; ?>><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="index.php?section=quotes" <?php echo ($section == 'quotes') ? 'class="active"' : ''; ?>><i class="fas fa-file-invoice-dollar"></i> Orçamentos</a></li>
        <li><a href="index.php?section=messages" <?php echo ($section == 'messages') ? 'class="active"' : ''; ?>><i class="fas fa-comments"></i> Chat / Mensagens</a></li>
        <li><a href="index.php?section=settings" <?php echo ($section == 'settings') ? 'class="active"' : ''; ?>><i class="fas fa-cog"></i> Definições</a></li>
        <li style="margin-top: 20px;"><a href="../index.php"><i class="fas fa-external-link-alt"></i> Ver Site</a></li>
        <li><a href="../admin/logout.php" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
    </ul>
</aside>

<main class="main-content">
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $msg = $_GET['message'] ?? '';
        if ($status == 'success') echo "<div class='alert alert-success'>Operação realizada com sucesso! $msg</div>";
        elseif ($status == 'error') echo "<div class='alert alert-danger'>Erro: $msg</div>";
    }

    switch($section) {
        case 'dashboard':
            ?>
            <div class="welcome-card">
                <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>Aqui pode gerir os seus pedidos de orçamento e comunicar com a nossa equipa.</p>
            </div>
            <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="welcome-card" style="text-align: center;">
                    <h3>Meus Pedidos</h3>
                    <?php
                    $count_quotes = $mysqli->query("SELECT COUNT(*) FROM quotes WHERE user_id = " . $_SESSION['id'])->fetch_row()[0];
                    echo "<p style='font-size: 2rem; font-weight: 700; color: #0056b3;'>$count_quotes</p>";
                    ?>
                </div>
                <div class="welcome-card" style="text-align: center;">
                    <h3>Mensagens</h3>
                    <?php
                    $count_msgs = $mysqli->query("SELECT COUNT(*) FROM messages WHERE user_id = " . $_SESSION['id'])->fetch_row()[0];
                    echo "<p style='font-size: 2rem; font-weight: 700; color: #0056b3;'>$count_msgs</p>";
                    ?>
                </div>
            </div>
            <?php
            break;

        case 'quotes':
            ?>
            <h2>Meus Pedidos de Orçamento</h2>
            <div class="form-card" style="margin-bottom: 30px;">
                <h3>Novo Pedido</h3>
                <form action="process_dashboard.php" method="POST">
                    <input type="hidden" name="action" value="request_quote">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group">
                        <label>Serviço Pretendido</label>
                        <input type="text" name="service" required placeholder="Ex: Construção de Moradia, Remodelação...">
                    </div>
                    <div class="form-group">
                        <label>Descrição Detalhada</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn">Pedir Orçamento</button>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Serviço</th>
                        <th>Estado</th>
                        <th>Valor (€)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $mysqli->prepare("SELECT created_at, service, status, budget FROM quotes WHERE user_id = ? ORDER BY created_at DESC");
                    $stmt->bind_param("i", $_SESSION['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                        echo "<td>" . htmlspecialchars($row['service']) . "</td>";
                        $status_label = $row['status'] == 'pending' ? '<span style="color: #f59e0b;">Pendente</span>' : '<span style="color: #10b981;">Respondido</span>';
                        echo "<td>$status_label</td>";
                        echo "<td>" . ($row['budget'] ? number_format($row['budget'], 2, ',', '.') : '---') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            break;

        case 'messages':
            ?>
            <h2>Comunicação / Chat</h2>
            <div class="form-card" style="margin-bottom: 30px;">
                <h3>Nova Mensagem Prioritária</h3>
                <form action="process_dashboard.php" method="POST">
                    <input type="hidden" name="action" value="send_priority_message">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group">
                        <label>Assunto</label>
                        <input type="text" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label>Mensagem</label>
                        <textarea name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn">Enviar com Prioridade</button>
                </form>
            </div>

            <h3>Conversas Ativas</h3>
            <?php
            $sql = "SELECT m.*, (SELECT COUNT(*) FROM messages m2 WHERE m2.parent_id = m.id) as replies
                    FROM messages m
                    WHERE m.user_id = ? AND m.parent_id IS NULL
                    ORDER BY m.created_at DESC";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $conversations = $stmt->get_result();

            while ($conv = $conversations->fetch_assoc()) {
                ?>
                <div class="welcome-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <strong><?php echo htmlspecialchars($conv['subject']); ?></strong>
                            <?php if($conv['is_priority']) echo ' <span style="background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem;">Prioritária</span>'; ?>
                            <p style="margin-top: 10px;"><?php echo nl2br(htmlspecialchars($conv['message'])); ?></p>
                        </div>
                        <span style="font-size: 0.8rem; color: #64748b;"><?php echo date('d/m H:i', strtotime($conv['created_at'])); ?></span>
                    </div>
                    <hr style="border: 0.5px solid #f1f5f9; margin: 15px 0;">
                    <div style="padding-left: 20px; border-left: 3px solid #e2e8f0;">
                        <?php
                        $stmt_replies = $mysqli->prepare("SELECT * FROM messages WHERE parent_id = ? ORDER BY created_at ASC");
                        $stmt_replies->bind_param("i", $conv['id']);
                        $stmt_replies->execute();
                        $replies = $stmt_replies->get_result();
                        while ($reply = $replies->fetch_assoc()) {
                            $role_label = $reply['sender_role'] == 'admin' ? '<strong style="color: #0056b3;">Admin:</strong> ' : '<strong>Eu:</strong> ';
                            echo "<p style='font-size: 0.9rem; margin-bottom: 10px;'>$role_label" . nl2br(htmlspecialchars($reply['message'])) . "</p>";
                        }
                        ?>
                    </div>
                    <form action="process_dashboard.php" method="POST" style="margin-top: 15px; display: flex; gap: 10px; background: none; box-shadow: none; padding: 0;">
                        <input type="hidden" name="action" value="reply_chat">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="parent_id" value="<?php echo $conv['id']; ?>">
                        <input type="hidden" name="subject" value="RE: <?php echo $conv['subject']; ?>">
                        <input type="text" name="message" placeholder="Escreva uma resposta..." required style="flex-grow: 1; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                        <button type="submit" class="btn" style="padding: 8px 15px; font-size: 0.9rem;">Responder</button>
                    </form>
                </div>
                <?php
            }
            break;

        case 'settings':
            ?>
            <h2>Definições de Conta</h2>
            <div class="form-card">
                <h3>Alterar Palavra-passe</h3>
                <form action="process_dashboard.php" method="POST">
                    <input type="hidden" name="action" value="change_password">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group">
                        <label>Palavra-passe Atual</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>Nova Palavra-passe</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirmar Nova Palavra-passe</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn">Atualizar Palavra-passe</button>
                </form>
            </div>
            <?php
            break;
    }
    ?>
</main>

</body>
</html>
