<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if includes exist and are readable
$authFile = '../../../includes/auth.inc.php';
$dbhFile = '../../../includes/dbh.inc.php';

if (!file_exists($authFile) || !is_readable($authFile)) {
    die('Error: auth.inc.php not found or not readable');
}

if (!file_exists($dbhFile) || !is_readable($dbhFile)) {
    die('Error: dbh.inc.php not found or not readable');
}

// Include files
require_once $authFile;
require_once $dbhFile;

// Ensure user is logged in as a student
try {
    requireRole('student');
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

// Get user ID from session
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    die('Error: User ID not found in session');
}

// Fetch the student's name
try {
    $query = "SELECT nom, prenom FROM etudiants WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $studentName = $student['prenom'] . ' ' . $student['nom'];
    } else {
        $studentName = "Nom inconnu";
        $error = "Aucune information trouvée pour cet étudiant";
    }

    // Fetch the student's subjects and notes
    $query_subjects = "
        SELECT matieres.nom_matiere, eval.note, eval.date_evaluation
        FROM evaluations eval
        JOIN matieres ON eval.id_matiere = matieres.id_matiere
        WHERE eval.id_etudiant = ?
    ";
    $stmt_subjects = $pdo->prepare($query_subjects);
    $stmt_subjects->execute([$userId]);
    $subjects = $stmt_subjects->fetchAll(PDO::FETCH_ASSOC);

    $student_info = $student;
} catch (PDOException $e) {
    $error = "Erreur de base de données: " . $e->getMessage();
    $student_info = null;
    $subjects = [];
}

$success = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Étudiants</title>
    <link rel="stylesheet" href="../../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../../script/dark_shi.js" defer></script>
</head>
<body class="bg-gray-100">
    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex overflow-x-auto justify-between items-center">
            <a href="../Students/For_Stud/stud_for_stud_lol.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap flex items-center">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <div class="ml-auto flex items-center">
                <button id="dark-mode-toggle" class="text-white px-4 py-2 hover:bg-gray-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-moon mr-2"></i>Mode Sombre
                </button>
            </div>
            <div class="flex">
                <button class="text-white px-4 py-2 hover:bg-gray-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-sign-out mr-2"></i><a href="../../login.php">Sign Out</a>
                </button>
            </div>
        </div>
    </nav>

    <!-- Secondary Navigation -->
    <nav class="bg-gray-700 shadow-sm">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./note_etud.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les notes
            </a>
        </div>
    </nav>

    <main class="container mx-auto py-8 px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-list mr-2"></i>Liste des Notes pour <?php echo htmlspecialchars($studentName); ?>
            </h1>

            <?php if ($success) : ?>
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Displaying student information and their notes -->
            <?php if ($student_info): ?>
                <div class="mb-8 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Informations de l'étudiant</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Nom</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($student_info['nom']); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Prénom</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($student_info['prenom']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Displaying student's subjects and their notes -->
                <?php if (!empty($subjects)): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'évaluation</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($subjects as $subject): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($subject['nom_matiere']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($subject['note']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo date('d/m/Y', strtotime($subject['date_evaluation'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-gray-500">
                        <p>Aucune note enregistrée pour cet étudiant.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
