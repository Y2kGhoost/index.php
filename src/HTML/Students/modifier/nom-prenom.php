<?php
session_start();
$id_etudiant = isset($_SESSION['id_etudiant']) ? $_SESSION['id_etudiant'] : null;
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : null;
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

unset($_SESSION['id_etudiant']);
unset($_SESSION['error']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Nom et Prénom</title>
    <link rel="stylesheet" href="../../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../../script/dark_shi.js" defer></script>
</head>
<body class="bg-gray-100">
    <!-- Main Navigation -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="../../../home.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-2"></i>Accueil
            </a>
            <a href="../students.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <a href="../../Enseignant/enseignent.php" class="text-white px-6 py-4 hover:bg-gray-700 transition-colors whitespace-nowrap">
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
            <a href="./listst.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les etudiants
            </a>
            <a href="../note_etud.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les notes
            </a>
        </div>
    </nav>

    <!-- Tertiary Navigation -->
    <nav class="bg-gray-600 shadow-sm">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./nom-prenom.php" class="text-white px-6 py-4 bg-gray-500 hover:bg-gray-400 transition-colors whitespace-nowrap">
                <i class="fas fa-signature mr-2"></i>Nom et Prénom
            </a>
            <a href="./date_naissance.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-birthday-cake mr-2"></i>Date de naissance
            </a>
            <a href="./filiere.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-graduation-cap mr-2"></i>Filière
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-user-edit mr-2"></i>Modifier Nom et Prénom
            </h2>
            
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

            <form action="../../../includes/Sthandl/Modifier/nom-prenom-modif.inc.php" method="post">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="id_etudiant" class="block text-sm font-medium text-gray-700 mb-1">ID Étudiant</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="number" id="id_etudiant" name="id_etudiant" placeholder="ID de l'étudiant" required
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    
                    <div>
                        <label for="newNom" class="block text-sm font-medium text-gray-700 mb-1">Nouveau Nom</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-signature text-gray-400"></i>
                            </div>
                            <input type="text" id="newNom" name="newNom" placeholder="Nouveau nom de l'étudiant"
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    
                    <div>
                        <label for="newPrenom" class="block text-sm font-medium text-gray-700 mb-1">Nouveau Prénom</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-signature text-gray-400"></i>
                            </div>
                            <input type="text" id="newPrenom" name="newPrenom" placeholder="Nouveau prénom de l'étudiant"
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <?php if ($nom && $prenom): ?>
                    <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Étudiant modifié avec succès<br>
                                    <span class="font-semibold">ID: <?= htmlspecialchars($id_etudiant) ?></span> | 
                                    <span class="font-semibold">Nom: <?= htmlspecialchars($nom) ?></span> | 
                                    <span class="font-semibold">Prénom: <?= htmlspecialchars($prenom) ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-8 flex justify-end">
                    <button type="submit" name="modif" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-save mr-2"></i>Modifier
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>