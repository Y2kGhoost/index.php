<?php
session_start();

$nom_fil = isset($_SESSION['nomfil']) ? $_SESSION['nomfil'] : null;

unset($_SESSION['nomfil']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filières</title>
    <link rel="stylesheet" href="../../css/output.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="../Enseignant/enseignent.php">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="filieres.php" style="background-color: #575757;">Filières</a>
        <a href="../Evaluation/evaluation.php">Evaluation</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutfl.php" style="background-color: #575757;">Ajouter Filiere</a>
        <a href="./modifierfl.php">Modifier Filiere</a>
        <a href="./suprimfl.php">Supprimer Filiere</a>
    </nav>

    <form action="../../includes/Filierehndl/Ajout_filiere.inc.php" method="post" id="form">
        <label for="nom_fil" id="lab">Nom de filieres</label><br><br>
        <input type="text" id="inp" name="nomfil" placeholder="Nom..."><br><br><br>

        <input type="submit" id="sub" value="Valider">
        <?php if ($nom_fil): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Filiere Ajouter avec succès<br>
                Nom: <?= htmlspecialchars($nom_fil) ?>
            </p>
        <?php endif; ?>
    </form>
</body>
</html>