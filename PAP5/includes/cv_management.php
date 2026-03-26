<?php
// PAP5/includes/cv_management.php

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    exit;
}

// require_once 'includes/config.php'; // Already included by admin.php

if ($mysqli) {
    // Delete CV if requested
    if (isset($_GET['delete_cv'])) {
        // Verify CSRF token
        if (!isset($_GET['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        $id = (int)$_GET['delete_cv'];
        // First get the file path to delete the file
        $stmt = $mysqli->prepare("SELECT cv_path FROM cv_submissions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($cv_path);
        if ($stmt->fetch()) {
            if (file_exists($cv_path)) {
                unlink($cv_path);
            }
        }
        $stmt->close();

        $stmt = $mysqli->prepare("DELETE FROM cv_submissions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        echo "<div style='padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;'>Candidatura eliminada com sucesso.</div>";
    }

    $result = $mysqli->query("SELECT * FROM cv_submissions ORDER BY created_at DESC");

    if ($result->num_rows > 0) {
        echo "<table style='width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
        echo "<thead style='background: #f8fafc; border-bottom: 1px solid #e2e8f0;'>";
        echo "<tr>";
        echo "<th style='padding: 15px; text-align: left;'>Data</th>";
        echo "<th style='padding: 15px; text-align: left;'>Nome</th>";
        echo "<th style='padding: 15px; text-align: left;'>Email</th>";
        echo "<th style='padding: 15px; text-align: left;'>Telefone</th>";
        echo "<th style='padding: 15px; text-align: left;'>Currículo</th>";
        echo "<th style='padding: 15px; text-align: left;'>Ações</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr style='border-bottom: 1px solid #f1f5f9;'>";
            echo "<td style='padding: 15px;'>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
            echo "<td style='padding: 15px;'>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td style='padding: 15px;'>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td style='padding: 15px;'>" . htmlspecialchars($row['phone']) . "</td>";
            echo "<td style='padding: 15px;'><a href='" . htmlspecialchars($row['cv_path']) . "' target='_blank' style='color: #0056b3; text-decoration: none;'><i class='fas fa-file-download'></i> Download</a></td>";
            echo "<td style='padding: 15px;'><a href='admin.php?section=cvs&delete_cv=" . $row['id'] . "&csrf_token=" . ($_SESSION['csrf_token'] ?? '') . "' onclick='return confirm(\"Tem a certeza?\")' style='color: #dc3545;'><i class='fas fa-trash'></i></a></td>";
            echo "</tr>";
            if (!empty($row['message'])) {
                echo "<tr style='border-bottom: 1px solid #f1f5f9; background: #fafafa;'>";
                echo "<td colspan='6' style='padding: 10px 15px; font-size: 0.9em; color: #64748b;'><strong>Mensagem:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</td>";
                echo "</tr>";
            }
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Ainda não foram submetidos currículos.</p>";
    }
} else {
    echo "<p>Erro na ligação à base de dados.</p>";
}
?>
