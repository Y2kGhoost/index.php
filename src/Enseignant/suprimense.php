<?php
session_start();
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : null;
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

unset($_SESSION['nom']);
unset($_SESSION['prenom']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignants</title>
    <link rel="stylesheet" href="../css/MainMenu.css">
    <link rel="stylesheet" href="../css/secMenu.css">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="enseignent.php" style="background-color: #575757;">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutense.php">Ajouter Enseignant</a>
        <a href="./modifense.php">Modifier Enseignant</a>
        <a href="./suprimense.php" style="background-color: #575757;">Supprimer Enseignant</a>
    </nav>

    <form action="../includes/Enseignants/suprimense.inc.php" method="post" id="form">
        <label for="id_enseignant" id="lab">ID Enseignant</label><br><br>
        <input type="number" name="id_ens" id="inp" placeholder="ID Enseignant"><br><br><br>

        <input type="submit" value="Supprimer" id="sub">
        <?php if($nom && $prenom): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Enseignant Suprimmer avec succès<br>
                Nom: <?= htmlspecialchars($nom) ?> | Prenom: <?= htmlspecialchars($prenom) ?>
            </p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p id="lab" style="color: red; font-weight: bold">
                ❌ Enseignant Suprimmer avec echec <br>
                ID Introvable
            </p>
        <?php endif; ?>
    </form>
</body>
</html>