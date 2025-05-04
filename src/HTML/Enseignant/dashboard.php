<?php
require_once '../../includes/auth.inc.php';
requireRole('teacher');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Enseignant</title>
  <link rel="stylesheet" href="../../css/output.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="../../script/dark_shi.js"></script>
</head>
<body class="bg-gray-50">
  <nav class="bg-gray-800 shadow-md">
    <div class="container mx-auto flex overflow-x-auto">
      <a href="../Evaluation/For_ens/eval_for_ens.php" class="text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap">
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
        1</button>
      </div>
    </div>
  </nav>

  <main class="container mx-auto py-8 px-4 text-center">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Bonjour, Enseignants
            </h2>
        </div>
  </main>

</body>
</html>