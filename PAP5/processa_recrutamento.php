<?php
session_start();
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $mensagem = $_POST['mensagem'];

    // Handle file upload
    $target_dir = "uploads/cvs/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $fileName = time() . '_' . basename($_FILES["cv"]["name"]);
    $target_file = $target_dir . $fileName;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["cv"]["size"] > 5000000) { // 5MB limit
        header("Location: recrutamento.php?status=error&message=O ficheiro é demasiado grande (máx 5MB).");
        exit;
    }

    // Allow certain file formats
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        header("Location: recrutamento.php?status=error&message=Apenas são permitidos ficheiros PDF, DOC e DOCX.");
        exit;
    }

    if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
        // Insert into database
        if ($mysqli) {
            $stmt = $mysqli->prepare("INSERT INTO cv_submissions (name, email, phone, cv_path, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $email, $telefone, $target_file, $mensagem);

            if ($stmt->execute()) {
                header("Location: recrutamento.php?status=success");
            } else {
                header("Location: recrutamento.php?status=error&message=Erro ao guardar no banco de dados.");
            }
            $stmt->close();
        } else {
            header("Location: recrutamento.php?status=error&message=Sem ligação à base de dados.");
        }
    } else {
        header("Location: recrutamento.php?status=error&message=Erro ao carregar o ficheiro.");
    }
} else {
    header("Location: recrutamento.php");
}
?>
