<?php
session_start();

$nom_mat = isset($_SESSION['deleted_matiere']) ? $_SESSION['deleted_matiere'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

unset($_SESSION['deleted_matiere']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
    <link rel="stylesheet" href="../../css/output.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="../Enseignant/enseignent.php">Enseignants</a>
        <a href="matieres.php" style="background-color: #575757;">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
        <a href="../Evaluation/evaluation.php">Evaluation</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutmatie.php">Ajouter Matière</a>
        <a href="./modifmatie.php">Modifier Matière</a>
        <a href="./suprimematie.php" style="background-color: #575757;">Supprimer Matière</a>
    </nav>

    <form action="../../includes/Matieres/suprim_matie.inc.php" method="post" id="form">
        <label for="id_mat" id="lab">ID Matiere</label><br><br>
        <input type="number" name="id_mat" id="inp" placeholder="ID Matiere..."><br><br><br>

        <input type="submit" value="Suprimer" id="sub">

        <?php if ($nom_mat): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Matiere Suprimer avec succes <br>
                Nom Matiere: <?= htmlspecialchars($nom_mat) ?>
            </p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p id="lab" style="color: red; font-weight: bold">
                ❌ Matiere Suprimmer avec echec <br>
                ID Introvable
            </p>
        <?php endif; ?>
    </form>
</body>
</html>