<?php
// Start at the top of the file to prevent any output before session
session_start();

// Include required files
require_once "./includes/dbh.inc.php";
require_once "./includes/auth.inc.php";

// Check if user is authenticated admin before proceeding
requireRole('admin');

// Only proceed to load the page content if the auth check passes
try {
    // Get student count
    $queryStudents = "SELECT COUNT(*) as total FROM etudiants";
    $stmtStudents = $pdo->prepare($queryStudents);
    $stmtStudents->execute();
    $studentCount = $stmtStudents->fetch(PDO::FETCH_ASSOC)['total'];

    // Get teacher count
    $queryTeachers = "SELECT COUNT(*) as total FROM enseignants";
    $stmtTeachers = $pdo->prepare($queryTeachers);
    $stmtTeachers->execute();
    $teacherCount = $stmtTeachers->fetch(PDO::FETCH_ASSOC)['total'];

    // Get program count
    $queryPrograms = "SELECT COUNT(*) as total FROM filieres";
    $stmtPrograms = $pdo->prepare($queryPrograms);
    $stmtPrograms->execute();
    $programCount = $stmtPrograms->fetch(PDO::FETCH_ASSOC)['total'];

    // Get recent students
    $queryRecentStudents = "SELECT e.id_etudiant, e.nom, e.prenom, f.nom_filiere 
                           FROM etudiants e 
                           JOIN filieres f ON e.id_filiere = f.id_filiere 
                           ORDER BY e.id_etudiant DESC LIMIT 3";
    $stmtRecentStudents = $pdo->prepare($queryRecentStudents);
    $stmtRecentStudents->execute();
    $recentStudents = $stmtRecentStudents->fetchAll(PDO::FETCH_ASSOC);

    // Get recent evaluations
    $queryRecentEvals = "SELECT et.nom, et.prenom, m.nom_matiere, ev.note, ev.date_evaluation
                        FROM evaluations ev
                        JOIN etudiants et ON ev.id_etudiant = et.id_etudiant
                        JOIN matieres m ON ev.id_matiere = m.id_matiere
                        ORDER BY ev.date_evaluation DESC LIMIT 3";
    $stmtRecentEvals = $pdo->prepare($queryRecentEvals);
    $stmtRecentEvals->execute();
    $recentEvaluations = $stmtRecentEvals->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion Scolaire</title>
    <link rel="stylesheet" href="./css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="./script/dark_shi.js" defer></script>
</head>
<body class="bg-gray-100">
    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./home.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-2"></i>Accueil
            </a>
            <a href="./HTML/Students/students.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <a href="./HTML/Enseignant/enseignent.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Enseignants
            </a>
            <a href="./HTML/Matieres/matieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-book mr-2"></i>Matières
            </a>
            <a href="./HTML/Filieres/filieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-graduation-cap mr-2"></i>Filières
            </a>
            <a href="./HTML/Evaluation/evaluation.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-clipboard-check mr-2"></i>Évaluation
            </a>
            <!-- In your nav element, add this button -->
            <div class="ml-auto flex items-center">
                <button id="dark-mode-toggle" class="text-white px-4 py-2 hover:bg-gray-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-moon mr-2"></i>Mode Sombre
                </button>
                <a href="./HTML/login.php" class="text-white px-4 py-2 bg-red-600 hover:bg-red-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Welcome Banner -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-8 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                <h1 class="text-3xl font-bold mb-2">Bienvenue sur le Tableau de Bord</h1>
                <p class="text-blue-100">Gestion complète de votre établissement scolaire</p>
                <p class="text-blue-100 mt-2">Connecté en tant qu'administrateur: <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Étudiants</p>
                            <p class="text-2xl font-semibold text-gray-800"><?= htmlspecialchars($studentCount ?? 0) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <i class="fas fa-chalkboard-teacher text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Enseignants</p>
                            <p class="text-2xl font-semibold text-gray-800"><?= htmlspecialchars($teacherCount ?? 0) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Filières</p>
                            <p class="text-2xl font-semibold text-gray-800"><?= htmlspecialchars($programCount ?? 0) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Students -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-user-graduate mr-2 text-blue-600"></i>Nouveaux Étudiants
                    </h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php if(!empty($recentStudents)): ?>
                        <?php foreach($recentStudents as $student): ?>
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <p class="font-medium"><?= htmlspecialchars($student['prenom'] . ' ' . $student['nom']) ?></p>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($student['nom_filiere']) ?></p>
                                    <p class="text-xs text-gray-400">ID: <?= htmlspecialchars($student['id_etudiant']) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-gray-500">
                            Aucun étudiant récent
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 text-center border-t border-gray-200">
                    <a href="./HTML/Students/students.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Voir tous les étudiants <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Evaluations -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-clipboard-list mr-2 text-green-600"></i>Dernières Évaluations
                    </h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php if(!empty($recentEvaluations)): ?>
                        <?php foreach($recentEvaluations as $eval): ?>
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <p class="font-medium"><?= htmlspecialchars($eval['prenom'] . ' ' . $eval['nom']) ?></p>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($eval['nom_matiere']) ?> - Note: <?= htmlspecialchars($eval['note']) ?>/20</p>
                                    <p class="text-xs text-gray-400"><?= htmlspecialchars($eval['date_evaluation']) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-gray-500">
                            Aucune évaluation récente
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 text-center border-t border-gray-200">
                    <a href="./HTML/Evaluation/evaluation.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Voir toutes les évaluations <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
</body>
</html>
