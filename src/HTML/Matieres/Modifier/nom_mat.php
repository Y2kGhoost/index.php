<?php
session_start();

$id_mat = isset($_SESSION['id_mat']) ? $_SESSION['id_mat'] : null;
$newNom = isset($_SESSION['newNom']) ? $_SESSION['newNom'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

unset($_SESSION['id_mat']);
unset($_SESSION['newNom']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
    <link rel="stylesheet" href="../../../css/output.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../../home.php">Acceuil</a>
        <a href="../../Students/students.php">Etudiants</a>
        <a href="../../Enseignant/enseignent.php">Enseignants</a>
        <a href="../matieres.php" style="background-color: #575757;">Matières</a>
        <a href="../../Filieres/filieres.php">Filières</a>
        <a href="../../Notes/Note_stu.php">Relever du note</a>
    </nav>
    <nav id="secMenu">
        <a href="../ajoutmatie.php">Ajouter Matière</a>
        <a href="../modifmatie.php" style="background-color: #575757;">Modifier Matière</a>
        <a href="../suprimematie.php">Supprimer Matière</a>
    </nav>
    <nav id="secMenu">
        <a href="./nom_mat.php" style="background-color: #575757;">Nom Matiere</a>
        <a href="./fil_mat.php">Filiere Matiere</a>
        <a href="./ens_mat.php">Enseignant Matiere</a>
    </nav>

    <form action="../../../includes/Matieres/Modifier/nom_mat.inc.php" method="post" id="form">
        <label for="id_mat" id="lab">ID Matiere</label><br><br>
        <input type="number" name="id_mat" id="inp" placeholder="ID Matiere..."><br><br><br>

        <label for="newNom" id="lab">Nouveau Nom</label><br><br>
        <input type="text" name="newNom" id="inp" placeholder="Nouveau Nom..."><br><br><br>

        <input type="submit" value="Modifier" id="sub">

        <?php if ($id_mat && $newNom): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Nom Matiere Modifier avec succès<br>
                ID: <?= htmlspecialchars($id_mat) ?> | Nouveau Nom: <?= htmlspecialchars($newNom) ?>
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