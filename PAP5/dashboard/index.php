<?php
session_start();
// Check if user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: ../login.php");
    exit;
}

// Initialize CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
    <link rel="stylesheet" href="../admin/styles.css">
    <style>
        /* Override some admin styles for user dashboard */
        .sidebar { background: #0f172a; }
        .nav-links a.active { background: #0056b3; }
        .stat-card .value { color: #0056b3; }

        .chat-container { display: flex; flex-direction: column; height: 600px; background: white; border-radius: 20px; box-shadow: var(--shadow-lg); border: 1px solid #f1f5f9; overflow: hidden; }
        .chat-header { padding: 25px 30px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .chat-header h3 { margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }

        .chat-messages { flex-grow: 1; padding: 30px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px; background: #fcfcfd; }
        .message-bubble { max-width: 80%; padding: 16px 20px; border-radius: 20px; font-size: 0.95rem; line-height: 1.5; box-shadow: var(--shadow-sm); }
        .message-bubble.sent { align-self: flex-end; background: #0056b3; color: white; border-bottom-right-radius: 4px; }
        .message-bubble.received { align-self: flex-start; background: white; color: #1e293b; border-bottom-left-radius: 4px; border: 1px solid #f1f5f9; }

        .message-info { font-size: 0.75rem; margin-bottom: 6px; display: block; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .sent .message-info { color: rgba(255,255,255,0.7); text-align: right; }
        .received .message-info { color: #94a3b8; }

        .chat-input-area { padding: 25px 30px; background: white; border-top: 1px solid #f1f5f9; }
        .chat-input-wrapper { display: flex; gap: 15px; }
        .chat-input-wrapper input { flex-grow: 1; padding: 14px 20px; border: 2px solid #e2e8f0; border-radius: 12px; font-family: inherit; transition: var(--transition); background: #f8fafc; }
        .chat-input-wrapper input:focus { outline: none; border-color: #0056b3; background: white; box-shadow: 0 0 0 4px rgba(0, 86, 179, 0.1); }

        .priority-badge { background: #fee2e2; color: #ef4444; padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }

        .dashboard-welcome { margin-bottom: 40px; }
        .dashboard-welcome h1 { font-size: 2.25rem; font-weight: 800; color: #0f172a; margin: 0 0 10px 0; letter-spacing: -1px; }
        .dashboard-welcome p { color: #64748b; font-size: 1.1rem; margin: 0; }

        .form-section { max-width: 800px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <h2><i class="fas fa-tools"></i> Alfa User</h2>
    <ul class="nav-links">
        <li><a href="index.php?section=dashboard" <?php echo ($section == 'dashboard') ? 'class="active"' : ''; ?>><i class="fas fa-grid-2"></i> Dashboard</a></li>
        <li><a href="index.php?section=quotes" <?php echo ($section == 'quotes') ? 'class="active"' : ''; ?>><i class="fas fa-file-invoice-dollar"></i> Orçamentos</a></li>
        <li><a href="index.php?section=messages" <?php echo ($section == 'messages') ? 'class="active"' : ''; ?>><i class="fas fa-comments"></i> Chat / Mensagens</a></li>
        <li><a href="index.php?section=settings" <?php echo ($section == 'settings') ? 'class="active"' : ''; ?>><i class="fas fa-user-gear"></i> Definições</a></li>
        <li style="margin-top: 40px;"><a href="../index.php"><i class="fas fa-arrow-left"></i> Voltar ao Site</a></li>
        <li><a href="../admin/logout.php" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Sair da Conta</a></li>
    </ul>
</aside>

<main class="content">
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $msg = $_GET['message'] ?? '';
        if ($status == 'success') echo "<div class='alert' style='background: #dcfce7; color: #166534; padding: 20px; border-radius: 12px; margin-bottom: 30px; font-weight: 600; border: 1px solid #bbf7d0;'>Operação realizada com sucesso! $msg</div>";
        elseif ($status == 'error') echo "<div class='alert' style='background: #fee2e2; color: #991b1b; padding: 20px; border-radius: 12px; margin-bottom: 30px; font-weight: 600; border: 1px solid #fecaca;'>Erro: $msg</div>";
    }

    switch($section) {
        case 'dashboard':
            ?>
            <div class="dashboard-welcome">
                <h1>Olá, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <p>Bem-vindo ao seu painel pessoal de gestão de projetos.</p>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Pedidos de Orçamento</h3>
                    <?php
                    $count_quotes = $mysqli->query("SELECT COUNT(*) FROM quotes WHERE user_id = " . $_SESSION['id'])->fetch_row()[0];
                    echo "<div class='value'>$count_quotes</div>";
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Mensagens Trocadas</h3>
                    <?php
                    $count_msgs = $mysqli->query("SELECT COUNT(*) FROM messages WHERE user_id = " . $_SESSION['id'])->fetch_row()[0];
                    echo "<div class='value'>$count_msgs</div>";
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Candidaturas Submetidas</h3>
                    <?php
                    // Simplified: just checking if there's any CV with this email
                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM cv_submissions WHERE email = (SELECT email FROM users WHERE id = ?)");
                    $stmt->bind_param("i", $_SESSION['id']);
                    $stmt->execute();
                    $count_cvs = $stmt->get_result()->fetch_row()[0];
                    echo "<div class='value'>$count_cvs</div>";
                    ?>
                </div>
            </div>

            <section>
                <h2>Atividade Recente</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Assunto / Serviço</th>
                                <th>Data</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $mysqli->prepare("SELECT 'Orçamento' as type, service as subject, created_at, status FROM quotes WHERE user_id = ?
                                                     UNION
                                                     SELECT 'Mensagem' as type, subject, created_at, '---' as status FROM messages WHERE user_id = ? AND parent_id IS NULL
                                                     ORDER BY created_at DESC LIMIT 5");
                            $stmt->bind_param("ii", $_SESSION['id'], $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><span style='font-weight: 700; color: var(--accent);'>" . $row['type'] . "</span></td>";
                                echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                                echo "<td>" . date('d M, Y', strtotime($row['created_at'])) . "</td>";
                                $status_color = $row['status'] == 'pending' ? '#f59e0b' : '#10b981';
                                echo "<td><span style='color: $status_color; font-weight: 600;'>" . ucfirst($row['status']) . "</span></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <?php
            break;

        case 'quotes':
            ?>
            <div class="dashboard-welcome">
                <h1>Pedidos de Orçamento</h1>
                <p>Solicite novos orçamentos e acompanhe o progresso das suas propostas.</p>
            </div>
            <div class="form-section">
                <section>
                    <h2>Novo Pedido de Orçamento</h2>
                    <form action="process_dashboard.php" method="POST" class="admin-form">
                        <input type="hidden" name="action" value="request_quote">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="form-group">
                            <label>Serviço Pretendido</label>
                            <input type="text" name="service" required placeholder="Ex: Construção de Moradia Unifamiliar">
                        </div>
                        <div class="form-group">
                            <label>Descrição e Detalhes do Projeto</label>
                            <textarea name="description" rows="5" required placeholder="Descreva os materiais, dimensões e localização..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%;">Submeter Pedido de Orçamento</button>
                    </form>
                </section>
            </div>

            <section>
                <h2>Histórico de Orçamentos</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Serviço</th>
                                <th>Data de Pedido</th>
                                <th>Estado</th>
                                <th>Valor Proposto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $mysqli->prepare("SELECT id, created_at, service, status, budget FROM quotes WHERE user_id = ? ORDER BY created_at DESC");
                            $stmt->bind_param("i", $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>#" . $row['id'] . "</td>";
                                echo "<td><strong>" . htmlspecialchars($row['service']) . "</strong></td>";
                                echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                                $status_badge = $row['status'] == 'pending' ?
                                    '<span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">PENDENTE</span>' :
                                    '<span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">RESPONDIDO</span>';
                                echo "<td>$status_badge</td>";
                                echo "<td>" . ($row['budget'] ? '<strong style="font-size: 1.1rem; color: #0f172a;">' . number_format($row['budget'], 2, ',', '.') . ' €</strong>' : '<em>A aguardar análise</em>') . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <?php
            break;

        case 'messages':
            ?>
            <div class="dashboard-welcome">
                <h1>Comunicação Direta</h1>
                <p>Inicie conversas prioritárias com a nossa equipa técnica e acompanhe as respostas.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <div>
                    <section>
                        <h2>Nova Mensagem Prioritária</h2>
                        <form action="process_dashboard.php" method="POST" class="admin-form">
                            <input type="hidden" name="action" value="send_priority_message">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="form-group">
                                <label>Assunto do Contacto</label>
                                <input type="text" name="subject" required placeholder="Ex: Dúvida sobre o projeto #123">
                            </div>
                            <div class="form-group">
                                <label>Mensagem</label>
                                <textarea name="message" rows="5" required placeholder="Escreva aqui a sua questão..."></textarea>
                            </div>
                            <button type="submit" class="btn-primary" style="width: 100%;">Enviar com Prioridade Máxima</button>
                        </form>
                    </section>
                </div>
                <div>
                    <div style="display: flex; flex-direction: column; gap: 30px;">
                    <?php
                    $sql = "SELECT m.* FROM messages m WHERE m.user_id = ? AND m.parent_id IS NULL ORDER BY m.created_at DESC";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("i", $_SESSION['id']);
                    $stmt->execute();
                    $conversations = $stmt->get_result();

                    if($conversations->num_rows == 0) echo "<section><p>Ainda não iniciou nenhuma conversa.</p></section>";

                    while ($conv = $conversations->fetch_assoc()) {
                        ?>
                        <div class="chat-container">
                            <div class="chat-header">
                                <h3><?php echo htmlspecialchars($conv['subject']); ?></h3>
                                <?php if($conv['is_priority']) echo '<span class="priority-badge">Prioritário</span>'; ?>
                            </div>
                            <div class="chat-messages">
                                <div class="message-bubble received">
                                    <span class="message-info">Eu - <?php echo date('d/m H:i', strtotime($conv['created_at'])); ?></span>
                                    <?php echo nl2br(htmlspecialchars($conv['message'])); ?>
                                </div>
                                <?php
                                $stmt_replies = $mysqli->prepare("SELECT * FROM messages WHERE parent_id = ? ORDER BY created_at ASC");
                                $stmt_replies->bind_param("i", $conv['id']);
                                $stmt_replies->execute();
                                $replies = $stmt_replies->get_result();
                                while ($reply = $replies->fetch_assoc()) {
                                    $is_admin = $reply['sender_role'] == 'admin';
                                    $class = $is_admin ? 'received' : 'sent';
                                    $sender_name = $is_admin ? 'Suporte Técnico' : 'Eu';
                                    ?>
                                    <div class="message-bubble <?php echo $class; ?>">
                                        <span class="message-info"><?php echo $sender_name; ?> - <?php echo date('d/m H:i', strtotime($reply['created_at'])); ?></span>
                                        <?php echo nl2br(htmlspecialchars($reply['message'])); ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="chat-input-area">
                                <form action="process_dashboard.php" method="POST" style="margin: 0; box-shadow: none; padding: 0; background: none; border: none; width: 100%; max-width: none;">
                                    <input type="hidden" name="action" value="reply_chat">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="parent_id" value="<?php echo $conv['id']; ?>">
                                    <input type="hidden" name="subject" value="RE: <?php echo $conv['subject']; ?>">
                                    <div class="chat-input-wrapper">
                                        <input type="text" name="message" placeholder="Escreva a sua resposta..." required>
                                        <button type="submit" class="btn-primary" style="padding: 10px 25px;">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
            <?php
            break;

        case 'settings':
            ?>
            <div class="dashboard-welcome">
                <h1>Definições da Conta</h1>
                <p>Mantenha os seus dados de acesso protegidos e atualizados.</p>
            </div>
            <div class="form-section">
                <section>
                    <h2>Segurança e Palavra-passe</h2>
                    <form action="process_dashboard.php" method="POST" class="admin-form">
                        <input type="hidden" name="action" value="change_password">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="form-group">
                            <label>Palavra-passe Atual</label>
                            <input type="password" name="current_password" required placeholder="Digite a sua senha atual">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label>Nova Palavra-passe</label>
                                <input type="password" name="new_password" required placeholder="Nova senha">
                            </div>
                            <div class="form-group">
                                <label>Confirmar Nova Palavra-passe</label>
                                <input type="password" name="confirm_password" required placeholder="Repita a nova senha">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">Atualizar Credenciais de Acesso</button>
                    </form>
                </section>
            </div>
            <?php
            break;
    }
    ?>
</main>

</body>
</html>
