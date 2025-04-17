<?php
session_start();

$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : null;
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : null;

unset($_SESSION['nom']);
unset($_SESSION['prenom']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etudiants</title>
    <link rel="stylesheet" href="../css/MainMenu.css">
    <link rel="stylesheet" href="../css/secMenu.css">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../home.php">Acceuil</a>
        <a href="./students.php" style="background-color: #575757;">Etudiants </a>
        <a href="../Enseignant/enseignent.php">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutst.php">Ajouter Etudiant</a>
        <a href="./modfst.php">Modifier Etudiant</a>
        <a href="./cherchst.php">Chercher Etudiant</a>
        <a href="./suppst.php" style="background-color: #575757;">Supprimer Etudiant</a>
        <a href="./listst.php">Lister Etudiants</a>
    </nav>

    <form action="../includes/Sthandl/suprimstd.inc.php" method="post" id="form">
        <label for="id_etudiant" id="lab">Identifient D'etudiant</label><br><br>
        <input type="number" id="inp" placeholder="Identifient..." name="id"><br><br><br>
        <?php if ($nom && $prenom):?>
            <p id="lab">Etudiant Supprimer: <?php echo htmlspecialchars($nom . ' ' . $prenom);?></p>
        <?php endif;?>
        <input type="submit" id="sub" value="Supprimer">
    </form>
</body>
</html>