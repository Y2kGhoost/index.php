<?php
require_once '../includes/dbh.inc.php';
require_once '../includes/auth.inc.php';

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Input validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!in_array($role, ['admin', 'teacher', 'student'])) {
        $error = "Rôle invalide.";
    } else {
        try {
            $pdo->beginTransaction();

            // Check if username or email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                throw new Exception("Nom d'utilisateur ou email déjà utilisé.");
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // For admin registration, require approval
            $adminApproved = ($role === 'admin') ? 0 : 1;
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, admin_approved) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password, $role, $adminApproved]);
            $user_id = $pdo->lastInsertId();

            // Handle role-specific data
            if ($role === 'student') {
                $nom = trim($_POST['nom'] ?? '');
                $prenom = trim($_POST['prenom'] ?? '');
                $date_naissance = $_POST['date_naissance'] ?? '';
                $id_filiere = !empty($_POST['id_filiere']) ? $_POST['id_filiere'] : null;

                if (!$nom || !$prenom || !$date_naissance) {
                    throw new Exception("Champs obligatoires manquants pour l'étudiant.");
                }

                $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, date_naissance, id_filiere, user_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $date_naissance, $id_filiere, $user_id]);
            } elseif ($role === 'teacher') {
                $nom = trim($_POST['nom_teacher'] ?? '');
                $prenom = trim($_POST['prenom_teacher'] ?? '');
                $teacher_email = trim($_POST['email_teacher'] ?? '');

                if (!$nom || !$prenom || !$teacher_email) {
                    throw new Exception("Champs obligatoires manquants pour l'enseignant.");
                }

                $stmt = $pdo->prepare("INSERT INTO enseignants (nom, prenom, email, user_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $teacher_email, $user_id]);
            }

            $pdo->commit();
            
            if ($role === 'admin') {
                $success = "Demande d'inscription admin soumise. Un administrateur existant doit approuver votre compte.";
            } else {
                $success = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
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

        button:hover {
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 1px #10b981;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="animated-bg"></div>

    <div class="login-container">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 relative z-10">
            <div class="p-8">
                <div class="text-center mb-8">
                    <i class="fas fa-user-plus text-4xl text-green-600 dark:text-green-400 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Créer un compte</h2>
                </div>

                <?php if ($error): ?>
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 rounded">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400"></i>
                            <div class="ml-3 text-sm text-red-700 dark:text-red-300"><?= htmlspecialchars($error) ?></div>
                        </div>
                    </div>
                <?php elseif ($success): ?>
                    <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 dark:border-green-400 p-4 rounded">
                        <div class="flex">
                            <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                            <div class="ml-3 text-sm text-green-700 dark:text-green-300"><?= htmlspecialchars($success) ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom d'utilisateur</label>
                        <input type="text" name="username" required class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse e-mail</label>
                        <input type="email" name="email" required class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe</label>
                        <input type="password" name="password" required class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmer mot de passe</label>
                        <input type="password" name="confirm_password" required class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rôle</label>
                        <select name="role" id="role" required class="block w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                            <option value="">-- Sélectionnez un rôle --</option>
                            <option value="student">Étudiant</option>
                            <option value="teacher">Enseignant</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>

                    <div id="student-fields" style="display: none;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                            <input type="text" name="nom" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prénom</label>
                            <input type="text" name="prenom" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de naissance</label>
                            <input type="date" name="date_naissance" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ID Filière (optionnel)</label>
                            <input type="number" name="id_filiere" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                    </div>

                    <div id="teacher-fields" style="display: none;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                            <input type="text" name="nom_teacher" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prénom</label>
                            <input type="text" name="prenom_teacher" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse e-mail</label>
                            <input type="email" name="email_teacher" class="pl-3 py-2 w-full border rounded-md bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full py-3 px-4 rounded-md text-white bg-green-600 hover:bg-green-700 hover:shadow-lg hover:shadow-green-500/30 focus:ring-2 focus:ring-green-500 font-medium text-sm border transition duration-200 ease-in-out">
                            <i class="fas fa-user-plus mr-2"></i> S'inscrire
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>Déjà un compte ?
                        <a href="login.php" class="font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const studentFields = document.getElementById('student-fields');
        const teacherFields = document.getElementById('teacher-fields');

        roleSelect.addEventListener('change', () => {
            studentFields.style.display = roleSelect.value === 'student' ? 'block' : 'none';
            teacherFields.style.display = roleSelect.value === 'teacher' ? 'block' : 'none';
        });
    </script>

    <script src="../script/dark_shi.js"></script>
</body>
</html>
