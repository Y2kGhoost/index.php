<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filières</title>
    <link rel="stylesheet" href="../css/MainMenu.css">
    <link rel="stylesheet" href="../css/secMenu.css">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="../Enseignant/enseignent.php">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="filieres.php" style="background-color: #575757;">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutfl.php" style="background-color: #575757;">Ajouter Filiere</a>
        <a href="./modfst.php">Modifier Filiere</a>
        <a href="./suprimfl.php">Supprimer Filiere</a>
    </nav>

    <form action="../includes/Filierehndl/filierehandl.inc.php" method="post" id="form">
        <label for="nom_fil" id="lab">Nom de filieres</label><br><br>
        <input type="text" id="inp" name="nomfil" placeholder="Nom..."><br><br><br>

        <input type="submit" id="sub" value="Valider">
    </form>
</body>
</html>