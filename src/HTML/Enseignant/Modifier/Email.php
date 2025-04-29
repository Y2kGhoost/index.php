<?php
session_start();

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

unset($_SESSION['success']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Email - Enseignants</title>
    <link rel="stylesheet" href="../../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../../script/dark_shi.js" defer></script>
</head>
<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="../../../home.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-2"></i>Accueil
            </a>
            <a href="../../Students/students.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <a href="../enseignent.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Enseignants
            </a>
            <a href="../../Matieres/matieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-book mr-2"></i>Matières
            </a>
            <a href="../../Filieres/filieres.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-graduation-cap mr-2"></i>Filières
            </a>
            <a href="../../Evaluation/evaluation.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
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
            <a href="../ajoutense.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-plus mr-2"></i>Ajouter 
            </a>
            <a href="../modifense.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-user-edit mr-2"></i>Modifier
            </a>
            <a href="../suprimense.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-minus mr-2"></i>Supprimer
            </a>
            <a href="../listerens.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister
            </a>
        </div>
    </nav>

    <!-- Tertiary Navigation -->
    <nav class="bg-gray-600 shadow-inner">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./Nom_Prenom.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-id-card mr-2"></i>Nom et Prénom
            </a>
            <a href="./Email.php" class="text-white px-6 py-4 bg-gray-500 hover:bg-gray-400 transition-colors whitespace-nowrap">
                <i class="fas fa-envelope mr-2"></i>Email
            </a>
        </div>
    </nav>

    <!-- Main Form Section -->
    <main class="container mx-auto py-10 px-4">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">
                <i class="fas fa-envelope mr-2 text-blue-600"></i>Modifier l'Email de l'Enseignant
            </h2>
            <form action="../../../includes/Enseignants/Modifier/email_ens.inc.php" method="post" class="space-y-6">
                <div>
                    <label for="id_ens" class="block text-sm font-medium text-gray-700 mb-1">ID Enseignant</label>
                    <input type="number" id="id_ens" name="id_ens" placeholder="ID de l'enseignant"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Nouvel Email</label>
                    <input type="email" id="email" name="email" placeholder="exemple@domaine.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="text-right">
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
                        <i class="fas fa-save mr-2"></i>Modifier
                    </button>
                </div>
            </form>

            <!-- Success Message -->
            <?php if ($success): ?>
                    <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Enseignant Modifier avec succès! : <span class="font-bold"><?php echo $success; ?></span>
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
                                <i class="fas fa-exclamation-triangle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Erreur: <span class="font-bold"><?php echo htmlspecialchars($error); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
