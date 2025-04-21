<?php
session_start();

$id_fil = isset($_SESSION['id_fil']) ? $_SESSION['id_fil'] : null;
$newFil = isset($_SESSION['newFil']) ? $_SESSION['newFil'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

unset($_SESSION['id_fil'], $_SESSION['newFil'], $_SESSION['error']);
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
        <a href="../Notes/Note_stu.php">Relever du note</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutfl.php">Ajouter Filiere</a>
        <a href="./modifierfl.php" style="background-color: #575757;">Modifier Filiere</a>
        <a href="./suprimfl.php">Supprimer Filiere</a>
    </nav>

    <form action="../../includes/Filierehndl/modif_fil.inc.php" method="post" id="form">
        <label for="id_fil" id="lab">ID Filiere</label><br><br>
        <input type="number" name="id_fil" id="inp" placeholder="ID Filiere..."><br><br><br>

        <label for="newFil" id="lab">Nouveau Nom Filiere</label><br><br>
        <input type="text" name="newFil" id="inp" placeholder="Nouveau Nom Filiere..."><br><br><br>

        <input type="submit" value="Modifier" id="sub">

        <?php if ($id_fil && $newFil): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Filiere Modifier avec succès<br>
                ID: <?= htmlspecialchars($id_fil) ?> | Nom filiere: <?= htmlspecialchars($newFil) ?>
            </p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p id="lab" style="color: red; font-weight: bold">
                ❌ Filiere Suprimmer avec echec <br>
                ID Introvable
            </p>
        <?php endif; ?>
    </form>
</body>
</html>