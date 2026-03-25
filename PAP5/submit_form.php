<?php
require_once 'includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Use null coalescing operator to avoid undefined index errors
    $name = $_POST['Nome'] ?? 'Não fornecido';
    $email = $_POST['Email'] ?? '';
    $phone = $_POST['Telefone'] ?? null; // Default to null if not provided
    $subject = $_POST['Assunto'] ?? 'Sem assunto';
    $message = $_POST['Mensagem'] ?? '';

    $sql = "INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if($stmt->execute()){
            // Redirect to the homepage with a success message
            header("location: index.php?message=success");
            exit();
        } else{
            echo "ERROR: Could not execute query: $sql. " . $mysqli->error;
        }
    } else{
        echo "ERROR: Could not prepare query: $sql. " . $mysqli->error;
    }

    $stmt->close();
}
$mysqli->close();
?>
