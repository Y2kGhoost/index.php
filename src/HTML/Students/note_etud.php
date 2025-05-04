<?php
session_start();
require_once '../../includes/auth.inc.php';
requireRole('admin');

$student_info = isset($_SESSION['student_info']) ? $_SESSION['student_info'] : null;
$subjects = isset($_SESSION['subjects']) ? $_SESSION['subjects'] : [];
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;

// Clear session variables
unset($_SESSION['student_info']);
unset($_SESSION['subjects']);
unset($_SESSION['error']);
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Les Notes</title>
    <link rel="stylesheet" href="../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../script/dark_shi.js" defer></script>
</head>
<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="../../home.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-2"></i>Accueil
            </a>
            <a href="./students.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <a href="../Enseignant/enseignent.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Enseignants
            </a>
            <a href="../Matieres/matieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-book mr-2"></i>Matières
            </a>
            <a href="../Filieres/filieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-graduation-cap mr-2"></i>Filières
            </a>
            <a href="../Evaluation/evaluation.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-clipboard-check mr-2"></i>Évaluation
            </a>
            <div class="ml-auto flex items-center">
                <button id="dark-mode-toggle" class="text-white px-4 py-2 hover:bg-gray-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-moon mr-2"></i>Mode Sombre
                </button>
            </div>
        </div>
    </nav>

    <!-- Secondary Navigation -->
    <nav class="bg-gray-700 shadow-sm">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./ajoutst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-plus mr-2"></i>Ajouter
            </a>
            <a href="./modfst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-edit mr-2"></i>Modifier
            </a>
            <a href="./cherchst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-search mr-2"></i>Chercher
            </a>
            <a href="./suppst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-minus mr-2"></i>Supprimer
            </a>
            <a href="./listst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les etudiants
            </a>
            <a href="./note_etud.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les notes
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-list mr-2"></i>Liste des Notes
            </h1>
            
            <form action="../../includes/Sthandl/note_etud.inc.php" method="post" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div>
                        <label for="id_etud" class="block text-sm font-medium text-gray-700 mb-1">ID Etudiant</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="number" name="id_etud" id="id_etud" placeholder="ID de l'étudiant" 
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md"
                                   value="<?php echo isset($_POST['id_etud']) ? htmlspecialchars($_POST['id_etud']) : ''; ?>" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition-colors">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </div>
            </form>

            <?php if ($error) : ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

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
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Filière</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($student_info['nom_filiere']); ?></p>
                        </div>
                    </div>
                </div>


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
                                            <?php echo htmlspecialchars($subject['matiere']); ?>
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