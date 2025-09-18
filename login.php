<?php
session_start();
require_once 'config.php';

// Se già loggato, reindirizza alla pagina admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT id, username, password_hash, nome, cognome FROM admin_users WHERE username = ? AND attivo = 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Login riuscito
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_nome'] = $user['nome'];
                $_SESSION['admin_cognome'] = $user['cognome'];
                
                header('Location: admin.php');
                exit();
            } else {
                $error = 'Username o password non corretti';
            }
        } catch (Exception $e) {
            $error = 'Errore di connessione al database';
        }
    } else {
        $error = 'Inserisci username e password';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'titolo.php'; ?>
    <?php require 'styles/style_admin.php'; ?>
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .login-form .form-group {
            margin-bottom: 20px;
        }
        
        .login-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        .login-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .login-form input:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        .login-btn {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .login-btn:hover {
            background: #45a049;
        }
        
        .error-message {
            background: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
        }
        /* Stili aggiuntivi per l'autenticazione admin */

.admin-header {
    position: relative;
}

.user-info {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.1);
    padding: 10px 15px;
    border-radius: 8px;
    backdrop-filter: blur(5px);
    color: white;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-small {
    padding: 5px 10px !important;
    font-size: 12px !important;
    min-height: auto !important;
}

.user-info .btn-small {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.user-info .btn-small:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Responsive per mobile */
@media (max-width: 768px) {
    .user-info {
        position: static;
        margin-top: 20px;
        justify-content: center;
        background: rgba(255, 255, 255, 0.15);
    }
    
    .admin-header h1 {
        margin-bottom: 10px;
    }
}
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🛠️ Admin Login</h1>
            <p>Accedi al pannello amministrativo</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                       placeholder="Inserisci il tuo username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Inserisci la tua password">
            </div>
            
            <button type="submit" class="login-btn">🔑 Accedi</button>
        </form>
    </div>

    <script>
        // Focus automatico sul primo campo
        document.getElementById('username').focus();
        
        // Gestione invio con Enter
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.login-btn').click();
            }
        });
    </script>
</body>
</html>