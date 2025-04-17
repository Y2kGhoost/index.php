<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
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
        <a href="matieres.php" style="background-color: #575757;">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutmatie.php" style="background-color: #575757;">Ajouter Matière</a>
        <a href="./modfst.php">Modifier Matière</a>
        <a href="./suppst.php">Supprimer Matière</a>
    </nav>

    <form action="../includes/Matieres/matiehandl.inc.php" method="post" id="form" name="insert">
        <label for="name" id="lab">Nom</label><br><br>
        <input type="text" id="inp" name="nom_matiere" placeholder="Le Nom..." require><br><br><br>
        
        <label for="nom_fil" id="lab">Nom de la filiere</label><br><br>
        <input type="text" id="inp" name="nom_filiere" placeholder="Nom de la filiere..." require><br><br><br>

        <label for="nom_ens" id="lab">Nom de l'enseignant</label><br><br>
        <input type="text" id="inp" name="nom_enseignant" placeholder="Nom de l'enseignant..." require><br><br><br>

        <input type="submit" id="sub" name="subm" value="Valider">
    </form>
</body>
</html>