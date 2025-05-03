<?php
session_start();
require_once '../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            
            // ADMIN-SPECIFIC VERIFICATION
            if ($user['role'] === 'admin') {
                // Check if admin_approved exists and is TRUE (1)
                $isApproved = isset($user['admin_approved']) ? (bool)$user['admin_approved'] : true;
                
                if (!$isApproved) {
                    die("Your admin account requires approval. Please contact the system administrator.");
                }
                
                // Check if is_verified exists and is TRUE (1)
                $isVerified = isset($user['is_verified']) ? (bool)$user['is_verified'] : true;
                
                if (!$isVerified) {
                    die("Please verify your email first.");
                }
            }

            // Start secure session
            session_regenerate_id(true);
            $_SESSION = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'is_admin' => ($user['role'] === 'admin'),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'last_activity' => time()
            ];

            // Redirect based on role
            $redirectMap = [
                'admin' => './Admin/dashboard.php',
                'teacher' => '../HTML/Enseignant/dashboard.php', 
                'student' => '../HTML/Students/dashboard.php'
            ];
            
            if (isset($redirectMap[$user['role']])) {
                header("Location: " . $redirectMap[$user['role']]);
                exit();
            }
            
        } else {
            $error = "Invalid username or password";
        }
    } catch (PDOException $e) {
        $error = "Database error. Please try again later.";
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
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
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

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .dark .animated-bg {
            opacity: 0.10;
            background: linear-gradient(-45deg, #0ea5e9, #8b5cf6, #10b981, #facc15);
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        button:hover {
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="animated-bg"></div>

    <div class="login-container">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 relative z-10">
            <div class="p-8">
                <div class="text-center mb-8">
                    <i class="fas fa-user-shield text-4xl text-blue-600 dark:text-blue-400 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        Connexion au Système
                    </h2>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 dark:text-red-300">
                                    <?php echo htmlspecialchars($error); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nom d'utilisateur
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="username" name="username" required
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"
                                   placeholder="Entrez votre nom d'utilisateur">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Mot de passe
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"
                                   placeholder="Entrez votre mot de passe">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="/forgot-password.php" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                                Mot de passe oublié?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>
                        Nouveau sur la plateforme? 
                        <a href="registre.php" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="../script/dark_shi.js"></script>
</body>
</html>
