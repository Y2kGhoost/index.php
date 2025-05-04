<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // DASHBOARD REDIRECTION
        if ($user['role'] === 'admin') {
            header("Location: ../home.php");
        } elseif ($user['role'] === 'teacher') {
            header("Location: ../HTML/Enseignant/dashboard.php");
        } elseif ($user['role'] === 'student') {
            header("Location: ../HTML/Students/dashboard.php");
        } else {
            // fallback
            header("Location: ../home.php");
        }
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }
        
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: linear-gradient(-45deg, #3b82f6, #10b981, #9333ea, #f59e0b);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            opacity: 0.15;
        }
        
        .dark .animated-bg {
            opacity: 0.10;
            background: linear-gradient(-45deg, #0ea5e9, #8b5cf6, #10b981, #facc15);
        }
        
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            transition: all 0.3s ease;
        }
        
        .dark .login-card {
            background: rgba(31, 41, 55, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }
        
        .login-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .dark .login-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        
        .login-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
        }
        
        .login-title {
            font-size: 1.75rem;
            color: #1e40af;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .dark .login-title {
            color: #93c5fd;
        }
        
        .login-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
        }
        
        .login-icon {
            font-size: 2.5rem;
            color: #1e40af;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .dark .login-icon {
            color: #93c5fd;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #6b7280;
        }
        
        .login-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
        }
        
        .dark .login-input {
            background-color: rgba(55, 65, 81, 0.8);
            border-color: #4b5563;
            color: #f3f4f6;
        }
        
        .login-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
            outline: none;
            background-color: white;
        }
        
        .dark .login-input:focus {
            background-color: rgba(55, 65, 81, 1);
        }
        
        .login-btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.4);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 0.5rem;
        }
        
        .forgot-password {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #1e40af;
        }
        
        .dark .forgot-password {
            color: #93c5fd;
        }
        
        .dark .forgot-password:hover {
            color: #3b82f6;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
        }
        
        .dark .register-link {
            color: #9ca3af;
        }
        
        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #1e40af;
        }
        
        .dark .register-link a {
            color: #93c5fd;
        }
        
        .dark .register-link a:hover {
            color: #3b82f6;
        }
        
        .error-message {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }
        
        .dark .error-message {
            background-color: rgba(127, 29, 29, 0.8);
            border-left-color: #f87171;
        }
        
        .error-icon {
            color: #ef4444;
            margin-right: 0.75rem;
        }
        
        .dark .error-icon {
            color: #f87171;
        }
        
        .error-text {
            color: #b91c1c;
        }
        
        .dark .error-text {
            color: #fca5a5;
        }
    </style>
</head>
<body class="dark:bg-gray-900">
    <div class="animated-bg"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-6">
                <div class="login-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2 class="login-title">Connexion au Système</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle error-icon"></i>
                    <p class="error-text"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="username" name="username" required
                           class="login-input dark:bg-gray-700 dark:text-gray-200"
                           placeholder="Nom d'utilisateur">
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" required
                           class="login-input dark:bg-gray-700 dark:text-gray-200"
                           placeholder="Mot de passe">
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input id="remember-me" name="remember-me" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                        <label for="remember-me" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            Se souvenir de moi
                        </label>
                    </div>

                    <a href="/forgot-password.php" class="text-sm forgot-password">
                        Mot de passe oublié?
                    </a>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                </button>
            </form>

            <div class="register-link">
                <p>
                    Nouveau sur la plateforme? 
                    <a href="registre.php" class="font-medium">Créer un compte</a>
                </p>
            </div>
        </div>
    </div>

    <script src="../script/dark_shi.js"></script>
</body>
</html>