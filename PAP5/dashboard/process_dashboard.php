<?php
session_start();
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: index.php");
    exit;
}

// 1. Verify Authentication
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../login.php");
    exit;
}

// 2. Verify CSRF Token
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die('CSRF token validation failed.');
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'request_quote':
        $service = trim($_POST['service']);
        $description = trim($_POST['description']);
        $user_id = $_SESSION['id'];

        if (empty($service) || empty($description)) {
            header("location: index.php?section=quotes&status=error&message=Por favor, preencha todos os campos.");
            exit;
        }

        $stmt = $mysqli->prepare("INSERT INTO quotes (user_id, service, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $service, $description);
        if ($stmt->execute()) {
            header("location: index.php?section=quotes&status=success&message=Pedido de orçamento submetido.");
        } else {
            header("location: index.php?section=quotes&status=error&message=Erro ao processar pedido.");
        }
        $stmt->close();
        break;

    case 'send_priority_message':
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);
        $user_id = $_SESSION['id'];
        $name = $_SESSION['username'];
        $email = $_SESSION['email'] ?? 'user@alfa.pt'; // Fallback if email not in session

        if (empty($subject) || empty($message)) {
            header("location: index.php?section=messages&status=error&message=Preencha todos os campos.");
            exit;
        }

        $is_priority = 1;
        $stmt = $mysqli->prepare("INSERT INTO messages (user_id, name, email, subject, message, is_priority) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $user_id, $name, $email, $subject, $message, $is_priority);
        if ($stmt->execute()) {
            header("location: index.php?section=messages&status=success&message=Mensagem prioritária enviada.");
        } else {
            header("location: index.php?section=messages&status=error&message=Erro ao enviar mensagem.");
        }
        $stmt->close();
        break;

    case 'reply_chat':
        $parent_id = (int)$_POST['parent_id'];
        $message = trim($_POST['message']);
        $user_id = $_SESSION['id'];
        $name = $_SESSION['username'];
        $email = $_SESSION['email'] ?? 'user@alfa.pt';
        $subject = $_POST['subject'] ?? 'RE: Chat';

        if (empty($message)) {
            header("location: index.php?section=messages&status=error&message=Mensagem não pode estar vazia.");
            exit;
        }

        $stmt = $mysqli->prepare("INSERT INTO messages (user_id, name, email, subject, message, parent_id, sender_role) VALUES (?, ?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("issssi", $user_id, $name, $email, $subject, $message, $parent_id);
        if ($stmt->execute()) {
            header("location: index.php?section=messages&status=success");
        } else {
            header("location: index.php?section=messages&status=error&message=Erro ao enviar resposta.");
        }
        $stmt->close();
        break;

    case 'change_password':
        $current_pwd = $_POST['current_password'];
        $new_pwd = $_POST['new_password'];
        $confirm_pwd = $_POST['confirm_password'];
        $user_id = $_SESSION['id'];

        if ($new_pwd !== $confirm_pwd) {
            header("location: index.php?section=settings&status=error&message=Novas palavras-passe não coincidem.");
            exit;
        }

        // Check current password
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_pwd);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($current_pwd, $hashed_pwd)) {
            $new_hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $new_hashed_pwd, $user_id);
            if ($stmt->execute()) {
                header("location: index.php?section=settings&status=success&message=Palavra-passe atualizada.");
            } else {
                header("location: index.php?section=settings&status=error&message=Erro ao atualizar base de dados.");
            }
            $stmt->close();
        } else {
            header("location: index.php?section=settings&status=error&message=Palavra-passe atual incorreta.");
        }
        break;

    default:
        header("location: index.php");
        break;
}
?>
