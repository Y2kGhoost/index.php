<?php 
session_start();

$id_etudiant = isset($_SESSION['id_etudiant']) ? $_SESSION['id_etudiant'] : null;
$nom_filiere = isset($_SESSION['nom_filiere']) ? $_SESSION['nom_filiere'] : null;

unset($_SESSION['id_etudiant']);
unset($_SESSION['nom_filiere']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etudiants</title>
    <link rel="stylesheet" href="../../css/body.css">
    <link rel="stylesheet" href="../../css/MainMenu.css">
    <link rel="stylesheet" href="../../css/secMenu.css">
    <link rel="stylesheet" href="../../css/form.css">
    
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="../students.php" style="background-color: #575757;">Etudiants </a>
        <a href="../../Enseignant/enseignent.php">Enseignants</a>
        <a href="../../Matieres/matieres.php">Matières</a>
        <a href="../../Filieres/filieres.php">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="../ajoutst.php">Ajouter Etudiant</a>
        <a href="../modfst.php" style="background-color: #575757;">Modifier Etudiant</a>
        <a href="../cherchst.php">Chercher Etudiant</a>
        <a href="../suppst.php">Supprimer Etudiant</a>
        <a href="../listst.php">Lister Etudiants</a>
    </nav>
    <nav id="secMenu">
        <a href="./nom-prenom.php">Nom et Prenom</a>
        <a href="./date_naissance.php">Date de naissnace</a>
        <a href="./filiere.php" style="background-color: #575757;">Filiere</a>
    </nav>

    <form action="../../includes/Sthandl/Modifier/filiere-modif.inc.php" method="post" id="form">
        <label for="id_etudiant" id="lab">ID Etudiant</label><br><br>
        <input type="number" id="inp" name="id_etudiant" placeholder="ID Etudiant"><br><br><br>

        <label for="filiere" id="lab">Nouveau Filiere</label><br><br>
        <input type="text" id="inp" name="filiere" placeholder="Nouveau filiere"><br><br><br>

        <input type="submit" value="Modifier" id="sub">

        <?php if ($id_etudiant && $nom_filiere): ?>
            <p id="lab" style="color: green; font-weight: bold;">
                ✔️ Étudiant modifié avec succès<br>
                ID: <?= htmlspecialchars($id_etudiant) ?> | Filière: <?= htmlspecialchars($nom_filiere) ?>
            </p>
        <?php endif; ?>
    </form>
</body>
</html>