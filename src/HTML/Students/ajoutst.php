<?php
session_start(); 

$id_etudiant = isset($_SESSION['id_etudiant']) ? $_SESSION['id_etudiant'] : null;

unset($_SESSION['id_etudiant']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etudiants</title>
    <link rel="stylesheet" href="../../css/MainMenu.css">
    <link rel="stylesheet" href="../../css/secMenu.css">
    <link rel="stylesheet" href="../../css/body.css">
    <link rel="stylesheet" href="../../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="./students.php" style="background-color: #575757;">Etudiants </a>
        <a href="../Enseignant/enseignent.php">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
        <a href="../Notes/Note_stu.php">Relever du note</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutst.php" style="background-color: #575757;">Ajouter Etudiant</a>
        <a href="./modfst.php">Modifier Etudiant</a>
        <a href="./cherchst.php">Chercher Etudiant</a>
        <a href="./suppst.php">Supprimer Etudiant</a>
        <a href="./listst.php">Lister Etudiants</a>
    </nav>

    <form action="../../includes/Sthandl/Ajoutstd.inc.php" method="post" id="form">
        <label for="name" id="lab">Nom</label><br><br>
        <input type="text" id="inp" name="nom" placeholder="Le Nom..."><br><br><br>
        
        <label for="prenom" id="lab">Prenom</label><br><br>
        <input type="text" id="inp" name="prenom" placeholder="Le Prenom..."><br><br><br>

        <label for="date" id="lab">Date de naissance</label><br><br>
        <input type="date" id="date" name="date"><br><br><br>

        <label for="filiere" id="lab">Filiere</label><br><br>
        <input type="text" id="inp" name="filiere" placeholder="Filiere..."><br><br><br>

        <input type="submit" id="sub" name="subm" value="Valider"><br><br><br>

        <?php if ($id_etudiant): ?>
            <p id="lab">Etudiant id: <strong><?php echo $id_etudiant; ?></strong></p>
        <?php endif; ?>
    </form>

</body>
</html>
