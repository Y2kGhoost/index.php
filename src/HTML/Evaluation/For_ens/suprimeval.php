<?php
session_start();

$succes = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Note</title>
    <link rel="stylesheet" href="../../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../../script/dark_shi.js" defer></script>
</head>
<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./eval_for_ens.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-clipboard-check mr-2"></i>Évaluation
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
            <a href="./ajout_eval.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-plus-circle mr-2"></i>Ajouter Note
            </a>
            <a href="./modifeval.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-edit mr-2"></i>Modifier Note
            </a>
            <a href="./suprimeval.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-trash-alt mr-2"></i>Supprimer Note
            </a>
            <a href="./liste-note.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les notes
            </a>
        </div>
    </nav>

<!-- Main Content -->
<main class="container mx-auto py-8 px-4">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-trash-alt mr-2"></i>Supprimer une Note
            </h2>
            
            <form action="../../../includes/Evaluation/sumpimnote.inc.php" method="post">
                <div class="mb-6">
                    <label for="id_etudiant" class="block text-sm font-medium text-gray-700 mb-2">
                        Identifiant de l'Étudiant
                    </label>
                    <div class="relative rounded-md shadow-sm mb-6">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                        <input type="number" id="id_etudiant" name="id_etud" placeholder="Entrez l'identifiant de l'Étudiant" required
                               class="focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <label for="id_etudiant" class="block text-sm font-medium text-gray-700 mb-2">
                        Identifiant de la Matiere
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                        <input type="number" id="id_etudiant" name="id_mat" placeholder="Entrez l'identifiant de la matiere" required
                               class="focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>

                <?php if ($error): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    <?php echo htmlspecialchars($error); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($succes): ?>
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <span class="font-semibold"><?php echo htmlspecialchars($succes); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>Supprimer
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>