<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignants</title>
    <link rel="stylesheet" href="../css/MainMenu.css">
    <link rel="stylesheet" href="../css/secMenu.css">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="enseignent.php" style="background-color: #575757;">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutense.php" style="background-color: #575757;">Ajouter Enseignant</a>
        <a href="./modfst.php">Modifier Enseignant</a>
        <a href="./suppst.php">Supprimer Enseignant</a>
    </nav>

    <form action="../includes/Enseignants/enseihandl.inc.php" method="post" id="form">
        <label for="name" id="lab">Nom</label><br><br>
        <input type="text" id="inp" name="nom" placeholder="Le Nom..." require><br><br><br>
        
        <label for="prenom" id="lab">Prenom</label><br><br>
        <input type="text" id="inp" name="prenom" placeholder="Le Prenom..." require><br><br><br>

        <label for="email" id="lab">Email</label><br><br>
        <input type="email" id="inp" name="email" placeholder="Email..." require><br><br><br>

        <input type="submit" id="sub" name="subm" value="Valider">
    </form>
</body>
</html>