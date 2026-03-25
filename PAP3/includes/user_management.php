<?php
// User Management Logic

// Create new user
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])){
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }

    $new_username = trim($_POST['new_username']);
    $new_password = $_POST['new_password'];
    $new_email = trim($_POST['new_email']);
    $new_role = $_POST['new_role'];

    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $user_err = "Este nome de utilizador já existe.";
        } else {
            // Username is available, proceed with insertion
            $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
            if($stmt = $mysqli->prepare($sql)){
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt->bind_param("ssss", $new_username, $hashed_password, $new_email, $new_role);
                if($stmt->execute()){
                    $user_success = "Utilizador criado com sucesso!";
                } else {
                    $user_err = "Erro ao criar utilizador.";
                }
            }
        }
        $stmt->close();
    }
}

// Delete user
if(isset($_GET['delete_user'])){
    // CSRF token validation
    if (!isset($_GET['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
        die('CSRF token validation failed.');
    }

    $user_id_to_delete = $_GET['delete_user'];

    // Prevent admin from deleting themselves
    if($user_id_to_delete == $_SESSION['id']){
        $user_err = "Não pode eliminar o seu próprio utilizador.";
    } else {
        $sql = "DELETE FROM users WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i", $user_id_to_delete);
            if($stmt->execute()){
                $user_success = "Utilizador eliminado com sucesso!";
            } else {
                $user_err = "Erro ao eliminar utilizador.";
            }
            $stmt->close();
        }
    }
}

?>

<div class="user-management">
    <h3>Criar Novo Utilizador</h3>
    <?php
    if(isset($user_err)) echo "<div class='alert alert-danger'>$user_err</div>";
    if(isset($user_success)) echo "<div class='alert alert-success'>$user_success</div>";
    ?>
    <form action="admin.php?section=users" method="post" style="max-width: 100%; background: none; padding: 0; box-shadow: none;">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="form-group" style="margin-bottom: 20px; text-align: left;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4a5568;">Nome de Utilizador:</label>
            <input type="text" name="new_username" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; font-size: 0.95rem;">
        </div>
        <div class="form-group" style="margin-bottom: 20px; text-align: left;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4a5568;">Email:</label>
            <input type="email" name="new_email" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; font-size: 0.95rem;">
        </div>
        <div class="form-group" style="margin-bottom: 20px; text-align: left;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4a5568;">Palavra-passe:</label>
            <input type="password" name="new_password" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; font-size: 0.95rem;">
        </div>
        <div class="form-group" style="margin-bottom: 25px; text-align: left;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #4a5568;">Cargo:</label>
            <select name="new_role" style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; background-color: white; font-size: 0.95rem;">
                <option value="user">Utilizador</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button type="submit" name="create_user" class="btn" style="padding: 12px 30px;">Criar Utilizador</button>
    </form>

    <h3>Utilizadores Existentes</h3>
    <?php
    $sql = "SELECT id, username, email, role FROM users";
    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){
            echo "<table class='table'>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Utilizador</th>";
                        echo "<th>Email</th>";
                        echo "<th>Cargo</th>";
                        echo "<th>Ações</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $result->fetch_array()){
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td>";
                        if($row['id'] != $_SESSION['id']){
                            echo "<a href='admin.php?section=users&delete_user=" . htmlspecialchars($row['id']) . "&csrf_token=" . $_SESSION['csrf_token'] . "' onclick=\"return confirm('Tem a certeza?')\">Eliminar</a>";
                        } else {
                            echo "Atual (Você)";
                        }
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
            echo "</table>";
            $result->free();
        } else{
            echo "<p>Nenhum utilizador encontrado.</p>";
        }
    }
    ?>
</div>
