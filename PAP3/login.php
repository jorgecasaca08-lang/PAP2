<?php
session_start();
require_once 'includes/config.php';

// Initialize CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$login_err = '';
if ($mysqli === false) {
    $login_err = "ERROR: Could not connect to the database.";
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $mysqli){
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role, email FROM users WHERE username = ?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $param_username);
        $param_username = $username;

        if($stmt->execute()){
            $stmt->store_result();

            if($stmt->num_rows == 1){
                $stmt->bind_result($id, $username, $hashed_password, $role, $email);
                if($stmt->fetch()){
                    if(password_verify($password, $hashed_password)){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["role"] = $role;
                        $_SESSION["email"] = $email;

                        if($role === 'admin'){
                            header("location: admin.php");
                        } else {
                            header("location: dashboard/index.php");
                        }
                        exit();
                    } else{
                        $login_err = "Nome de utilizador ou palavra-passe inválidos.";
                    }
                }
            } else{
                $login_err = "Nome de utilizador ou palavra-passe inválidos.";
            }
        } else{
            echo "Ups! Algo correu mal. Por favor, tente novamente mais tarde.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Alfa Engenharia & Construções</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding-top: 0;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .login-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #1e293b;
        }
        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-top: 20px;
            border: 1px solid #fecaca;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .back-link:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-header">
        <i class="fas fa-user-shield"></i>
        <h2>Login - Alfa Engenharia & Construções</h2>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="padding: 0; box-shadow: none;">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="form-group" style="margin-bottom: 25px; text-align: left;">
            <label style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-weight: 600; color: #475569; font-size: 1rem;">
                <i class="fas fa-user" style="color: var(--primary-color); width: 20px; text-align: center;"></i> Utilizador
            </label>
            <input type="text" name="username" required placeholder="Nome de utilizador" style="width: 100%; box-sizing: border-box; display: block; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
        </div>
        <div class="form-group" style="margin-bottom: 30px; text-align: left;">
            <label style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-weight: 600; color: #475569; font-size: 1rem;">
                <i class="fas fa-lock" style="color: var(--primary-color); width: 20px; text-align: center;"></i> Palavra-passe
            </label>
            <input type="password" name="password" required placeholder="Sua senha" style="width: 100%; box-sizing: border-box; display: block; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
        </div>
        <div>
            <button type="submit" class="btn" style="width: 100%; font-size: 1.1rem; padding: 16px;">Entrar</button>
        </div>
    </form>
    <?php
    if(!empty($login_err)){
        echo '<div class="alert-danger"><i class="fas fa-exclamation-circle"></i> ' . $login_err . '</div>';
    }
    ?>
    <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Voltar ao site</a>
</div>
</body>
</html>