<?php
// PAP5/includes/messages.php

// 1. Handle Admin Reply
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_reply'])) {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }

    $parent_id = (int)$_POST['parent_id'];
    $user_id = (int)$_POST['user_id'];
    $message = trim($_POST['message']);
    $subject = trim($_POST['subject']);
    $admin_name = "Administrador";
    $admin_email = "admin@alfa.pt";

    if (!empty($message)) {
        $stmt = $mysqli->prepare("INSERT INTO messages (user_id, name, email, subject, message, parent_id, sender_role) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
        $stmt->bind_param("issssi", $user_id, $admin_name, $admin_email, $subject, $message, $parent_id);
        if ($stmt->execute()) {
            $msg_success = "Resposta enviada com sucesso!";
        } else {
            $msg_error = "Erro ao enviar resposta.";
        }
        $stmt->close();
    }
}

// 2. Fetch all main messages (not replies)
$sql = "SELECT * FROM messages WHERE parent_id IS NULL ORDER BY is_priority DESC, created_at DESC";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        if(isset($msg_success)) echo "<div class='alert alert-success'>$msg_success</div>";
        if(isset($msg_error)) echo "<div class='alert alert-danger'>$msg_error</div>";

        echo '<div class="message-grid" style="display: grid; grid-template-columns: 1fr; gap: 20px;">';
        while($row = $result->fetch_assoc()){
            $priority_style = $row['is_priority'] ? 'border-left: 5px solid #dc3545; background-color: #fff5f5;' : 'border-left: 5px solid #e2e8f0;';
            echo '<div class="message-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); ' . $priority_style . '">';
                echo '<div class="message-header" style="display: flex; justify-content: space-between; margin-bottom: 15px; color: #64748b; font-size: 0.85rem;">';
                    echo '<span>ID: #' . htmlspecialchars($row['id']) . '</span>';
                    echo '<span>' . date('d/m/Y H:i', strtotime($row['created_at'])) . '</span>';
                echo '</div>';

                $priority_tag = $row['is_priority'] ? ' <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 50px; font-size: 0.75rem; text-transform: uppercase;">Prioritária</span>' : '';
                echo '<h4 style="margin: 0 0 10px 0; font-size: 1.25rem;">' . htmlspecialchars($row['subject']) . $priority_tag . '</h4>';
                echo '<p style="margin-bottom: 15px;"><strong>De:</strong> ' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['email']) . ')</p>';
                echo '<div class="message-body" style="padding: 15px; background: #f8fafc; border-radius: 8px; margin-bottom: 20px;">';
                    echo '<p>' . nl2br(htmlspecialchars($row['message'])) . '</p>';
                echo '</div>';

                // Display Chat History if any
                $stmt_replies = $mysqli->prepare("SELECT * FROM messages WHERE parent_id = ? ORDER BY created_at ASC");
                $stmt_replies->bind_param("i", $row['id']);
                $stmt_replies->execute();
                $replies = $stmt_replies->get_result();
                if($replies->num_rows > 0){
                    echo '<div class="chat-history" style="margin-bottom: 20px; padding-left: 20px; border-left: 2px solid #cbd5e1;">';
                    echo '<h5 style="margin-bottom: 10px; color: #64748b;">Conversa:</h5>';
                    while($reply = $replies->fetch_assoc()){
                        $sender_label = $reply['sender_role'] == 'admin' ? '<strong style="color: #0056b3;">Admin:</strong> ' : '<strong>' . htmlspecialchars($reply['name']) . ':</strong> ';
                        echo '<p style="font-size: 0.9rem; margin-bottom: 8px;">' . $sender_label . nl2br(htmlspecialchars($reply['message'])) . '</p>';
                    }
                    echo '</div>';
                }

                // Reply Form (only for logged in users messages or if we want to allow replying to anyone)
                if($row['user_id']){
                    echo '<form action="admin.php?section=messages" method="post" style="display: flex; gap: 10px; background: none; padding: 0; box-shadow: none; border: none;">';
                        echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
                        echo '<input type="hidden" name="parent_id" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="user_id" value="' . $row['user_id'] . '">';
                        echo '<input type="hidden" name="subject" value="RE: ' . $row['subject'] . '">';
                        echo '<input type="text" name="message" placeholder="Responder a esta mensagem..." required style="flex-grow: 1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">';
                        echo '<button type="submit" name="admin_reply" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">Responder</button>';
                    echo '</form>';
                }
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
