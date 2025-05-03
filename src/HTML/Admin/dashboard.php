<?php
require_once '../../includes/auth.inc.php';
requireRole('admin'); // or 'teacher', 'student'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../css/output.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-6">
  <h1 class="text-2xl font-bold mb-4">Bienvenue, Administrateur</h1>
  <ul class="space-y-2">
    <li><a href="../Enseignant/" class="text-blue-600 hover:underline">Gérer les enseignants</a></li>
    <li><a href="../Students/" class="text-blue-600 hover:underline">Gérer les étudiants</a></li>
    <li><a href="../Matieres/" class="text-blue-600 hover:underline">Gérer les matières</a></li>
    <li><a href="../Evaluation/" class="text-blue-600 hover:underline">Gérer les évaluations</a></li>
    <li><a href="../Filierehndl/" class="text-blue-600 hover:underline">Gérer les filières</a></li>
    <li><a href="../Admin/admin_approval.php"></a></li>
  </ul>
</body>
</html>