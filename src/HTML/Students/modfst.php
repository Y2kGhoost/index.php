<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Étudiant</title>
    <link rel="stylesheet" href="../../css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
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
            <a href="./modfst.php" class="text-white px-6 py-4 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-user-edit mr-2"></i>Modifier
            </a>
            <a href="./cherchst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-search mr-2"></i>Chercher
            </a>
            <a href="./suppst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-user-minus mr-2"></i>Supprimer
            </a>
            <a href="./listst.php" class="text-white px-6 py-4 hover:bg-gray-600 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister
            </a>
        </div>
    </nav>

    <!-- Tertiary Navigation -->
    <nav class="bg-gray-600 shadow-sm">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./modifier/nom-prenom.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-signature mr-2"></i>Nom et Prénom
            </a>
            <a href="./modifier/date_naissance.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-birthday-cake mr-2"></i>Date de naissance
            </a>
            <a href="./modifier/filiere.php" class="text-white px-6 py-4 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-graduation-cap mr-2"></i>Filière
            </a>
        </div>
    </nav>

    <script src="../../script/dark_mod.js"></script>
</body>
</html>