<?php
session_start();
require_once '../../includes/auth.inc.php';
requireRole('admin');

$nom_fil = $_SESSION['nom_fil'] ?? null;
$error = $_SESSION['error'] ?? null;

// Load filières for dropdown
try {
    require_once "../../includes/dbh.inc.php";
    $stmt = $pdo->query("SELECT id_filiere, nom_filiere FROM filieres ORDER BY nom_filiere");
    $filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur lors du chargement des filières";
    error_log("DB error: " . $e->getMessage());
    $filieres = [];
}

unset($_SESSION['nom_fil'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Filière</title>
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
            <a href="../Students/students.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <a href="../Enseignant/enseignent.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Enseignants
            </a>
            <a href="../Matieres/matieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-book mr-2"></i>Matières
            </a>
            <a href="filieres.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
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
            <a href="./ajoutfl.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-plus-circle mr-2"></i>Ajouter
            </a>
            <a href="./modifierfl.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="./suprimfl.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-trash-alt mr-2"></i>Supprimer
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-trash-alt mr-2"></i>Supprimer une Filière
                </h2>
                
                <form action="../../includes/Filierehndl/suprim_fil.inc.php" method="post" class="space-y-6">
                    <div>
                        <label for="id_fil" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filière</label>
                        <select name="id_fil" id="id_fil" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Sélectionner une filière</option>
                            <?php foreach ($filieres as $f): ?>
                                <option value="<?= htmlspecialchars($f['id_filiere']) ?>">
                                    <?= htmlspecialchars($f['nom_filiere']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </div>
                </form>

                <!-- Success Message -->
                <?php if ($nom_fil): ?>
                    <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Filière supprimée avec succès!<br>
                                    Nom: <span class="font-bold"><?= htmlspecialchars($nom_fil) ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Error Message -->
                <?php if ($error): ?>
                    <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Échec de suppression!<br>
                                    <span class="font-bold">ID introuvable</span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>