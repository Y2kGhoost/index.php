<?php
session_start();

$id_ens = isset($_SESSION['id_enseignant']) ? $_SESSION['id_enseignant'] : null;
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : null;
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

unset($_SESSION['id_enseignant']);
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
    <link rel="stylesheet" href="../../css/MainMenu.css">
    <link rel="stylesheet" href="../../css/secMenu.css">
    <link rel="stylesheet" href="../../css/body.css">
    <link rel="stylesheet" href="../../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="../../Students/students.php">Etudiants</a>
        <a href="../enseignent.php" style="background-color: #575757;">Enseignants</a>
        <a href="../../Matieres/matieres.php">Matières</a>
        <a href="../../Filieres/filieres.php">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="../ajoutense.php">Ajouter Enseignant</a>
        <a href="../modifense.php" style="background-color: #575757;">Modifier Enseignant</a>
        <a href="../suprimense.php">Supprimer Enseignant</a>
    </nav>
    <nav id="secMenu">
        <a href="./Nom_Prenom.php" style="background-color: #575757;">Nom et Prenom</a>
        <a href="./Email.php">Email</a>
    </nav>

    <form action="../../includes/Enseignants/Modifier/nom_prenom_ens.inc.php" method="post" id="form">
        <label for="id_ens" id="lab">ID Enseignant</label><br><br>
        <input type="number" id="inp" name="id_ens" placeholder="ID Enseignant"><br><br><br>

        <label for="newNom" id="lab">Nouveau Nom</label><br><br>
        <input type="text" id="inp" name="newNom" placeholder="Nouveau Nom"><br><br><br>

        <label for="newPrenom" id="lab">Nouveau Prenom</label><br><br>
        <input type="text" id="inp" name="newPrenom" placeholder="Nouveau Prenom"><br><br><br>

        <input type="submit" value="Modifier" id="sub">

        <?php if ($id_ens && $nom && $prenom): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Enseignant Modifier avec succès<br>
                ID: <?= htmlspecialchars($id_ens) ?> | Nom: <?= htmlspecialchars($nom) ?> | Prenom: <?= htmlspecialchars($prenom) ?>
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