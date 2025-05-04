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
        
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .register-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            transition: all 0.3s ease;
        }
        
        .dark .register-card {
            background: rgba(31, 41, 55, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }
        
        .register-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .dark .register-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        
        .register-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #10b981, #059669);
        }
        
        .register-title {
            font-size: 1.75rem;
            color: #059669;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .dark .register-title {
            color: #6ee7b7;
        }
        
        .register-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #059669);
        }
        
        .register-icon {
            font-size: 2.5rem;
            color: #059669;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .dark .register-icon {
            color: #6ee7b7;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .dark .input-label {
            color: #d1d5db;
        }
        
        .register-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
        }
        
        .dark .register-input {
            background-color: rgba(55, 65, 81, 0.8);
            border-color: #4b5563;
            color: #f3f4f6;
        }
        
        .register-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
            outline: none;
            background-color: white;
        }
        
        .dark .register-input:focus {
            background-color: rgba(55, 65, 81, 1);
        }
        
        .register-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
        
        .dark .register-select {
            background-color: rgba(55, 65, 81, 0.8);
            border-color: #4b5563;
            color: #f3f4f6;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        }
        
        .register-btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
        }
        
        .dark .login-link {
            color: #9ca3af;
        }
        
        .login-link a {
            color: #10b981;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: #059669;
        }
        
        .dark .login-link a {
            color: #6ee7b7;
        }
        
        .dark .login-link a:hover {
            color: #10b981;
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
        
        .success-message {
            background-color: #dcfce7;
            border-left: 4px solid #22c55e;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }
        
        .dark .success-message {
            background-color: rgba(21, 128, 61, 0.8);
            border-left-color: #4ade80;
        }
        
        .success-icon {
            color: #22c55e;
            margin-right: 0.75rem;
        }
        
        .dark .success-icon {
            color: #4ade80;
        }
        
        .success-text {
            color: #166534;
        }
        
        .dark .success-text {
            color: #bbf7d0;
        }
        
        .role-fields {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background-color: rgba(241, 245, 249, 0.5);
            border-radius: 0.5rem;
            border-left: 3px solid #10b981;
        }
        
        .dark .role-fields {
            background-color: rgba(31, 41, 55, 0.5);
            border-left-color: #6ee7b7;
        }
    </style>
</head>
<body class="dark:bg-gray-900">
    <div class="animated-bg"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="text-center mb-6">
                <div class="register-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="register-title">Créer un compte</h2>
            </div>

            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle error-icon"></i>
                    <p class="error-text"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php elseif ($success): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle success-icon"></i>
                    <p class="success-text"><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div class="input-group">
                    <label class="input-label">Nom d'utilisateur</label>
                    <input type="text" name="username" required class="register-input dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="input-group">
                    <label class="input-label">Adresse e-mail</label>
                    <input type="email" name="email" required class="register-input dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="input-group">
                    <label class="input-label">Mot de passe</label>
                    <input type="password" name="password" required class="register-input dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="input-group">
                    <label class="input-label">Confirmer mot de passe</label>
                    <input type="password" name="confirm_password" required class="register-input dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="input-group">
                    <label class="input-label">Rôle</label>
                    <select name="role" id="role" required class="register-select dark:bg-gray-700 dark:text-gray-200">
                        <option value="">-- Sélectionnez un rôle --</option>
                        <option value="student">Étudiant</option>
                        <option value="teacher">Enseignant</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>

                <div id="student-fields" class="role-fields">
                    <div class="input-group">
                        <label class="input-label">Nom</label>
                        <input type="text" name="nom" class="register-input dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Prénom</label>
                        <input type="text" name="prenom" class="register-input dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="register-input dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="input-group">
                        <label class="input-label">ID Filière (optionnel)</label>
                        <input type="number" name="id_filiere" class="register-input dark:bg-gradient-700 dark:text-gray-200">
                    </div>
                </div>

                <div id="teacher-fields" class="role-fields">
                    <div class="input-group">
                        <label class="input-label">Nom</label>
                        <input type="text" name="nom_teacher" class="register-input dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Prénom</label>
                        <input type="text" name="prenom_teacher" class="register-input dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Adresse e-mail</label>
                        <input type="email" name="email_teacher" class="register-input dark:bg-gray-700 dark:text-gray-200">
                    </div>
                </div>

                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus mr-2"></i> S'inscrire
                </button>
            </form>

            <div class="login-link">
                <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
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