<?php
session_start();

$enss = $_SESSION['ens'] ?? [];
$error = $_SESSION['error'] ?? null;

unset($_SESSION['ens'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignants</title>
    <link rel="stylesheet" href="../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../script/dark_mod.js" defer></script>
</head>
<body class="bg-gray-50">

    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md dark:bg-gray-800">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="../../home.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-2"></i>Accueil
            </a>
            <a href="../Students/students.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <a href="enseignent.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
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
    <nav class="bg-gray-700 shadow-sm dark:bg-gray-700">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./ajoutense.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-plus mr-2"></i>Ajouter
            </a>
            <a href="./modifense.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-edit mr-2"></i>Modifier
            </a>
            <a href="./suprimense.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-minus mr-2"></i>Supprimer
            </a>
            <a href="./listerens.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        
        <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 dark:text-red-300"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 dark:text-red-200">
                            <?php echo htmlspecialchars($error); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form action="../../includes/Enseignants/lister_ens.inc.php" method="post" id="form">
            <input type="submit" value="Lister" id="sub" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
        </form><br><br><br>
        
        <?php if (count($enss) > 0): ?>
            <center>
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b dark:text-white">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b dark:text-white">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b dark:text-white">Prénom</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b dark:text-white">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($enss as $ens): ?>
                            <tr class="border-b">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white"><?php echo htmlspecialchars($ens['id_enseignant']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white"><?php echo htmlspecialchars($ens['nom']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white"><?php echo htmlspecialchars($ens['prenom']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white"><?php echo htmlspecialchars($ens['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </center>
        <?php endif; ?>
    </main>

</body>
</html>
