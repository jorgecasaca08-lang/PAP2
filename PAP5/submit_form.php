<?php
// PAP5/submit_form.php
session_start();
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $mysqli) {
    $name = $_POST['Nome'] ?? 'Anónimo';
    $email = $_POST['Email'] ?? '';
    $phone = $_POST['Telefone'] ?? '';
    $subject = $_POST['Assunto'] ?? 'Contacto via Site';
    $message = $_POST['Mensagem'] ?? '';
    $user_id = $_SESSION['id'] ?? null;

    $stmt = $mysqli->prepare("INSERT INTO messages (user_id, name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        header("Location: index.php?message=success");
    } else {
        header("Location: index.php?message=error");
    }
    $stmt->close();
} else {
    header("Location: index.php");
}
?>
