<?php
session_start();

$id_etudiant = isset($_SESSION['id_etudiant']) ? $_SESSION['id_etudiant'] : null;
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : null;
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : null;
$date = isset($_SESSION['date_naissance']) ? $_SESSION['date_naissance'] : null;
$nom_filiere = isset($_SESSION['nom_filiere']) ? $_SESSION['nom_filiere'] : null;

unset($_SESSION['id_etudiant']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
unset($_SESSION['date_naissance']);
unset($_SESSION['nom_filiere']);
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
    <link rel="stylesheet" href="../css/table.css">
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
        <a href="./cherchst.php" style="background-color: #575757;">Chercher Etudiant</a>
        <a href="./suppst.php">Supprimer Etudiant</a>
        <a href="./listst.php">Lister Etudiants</a>
    </nav>

    <form action="../includes/Sthandl/cherchst.inc.php" method="post" id="form">
        <label for="name" id="lab">Nom</label><br><br>
        <input type="text" id="inp" name="nom" placeholder="Le Nom..." require><br><br><br>
        
        <label for="prenom" id="lab">Prenom</label><br><br>
        <input type="text" id="inp" name="prenom" placeholder="Le Prenom..." require><br><br><br>

        <?php if ($id_etudiant): ?>
            <center>
                <table id="table">
                    <tr>
                        <th>id_etudiant</th>
                        <th>nom</th>
                        <th>prenom</th>
                        <th>date naissance</th>
                        <th>Filiere</th>
                    </tr>
                    <tr>
                        <td><?php echo $id_etudiant?></td>
                        <td><?php echo $nom?></td>
                        <td><?php echo $prenom?></td>
                        <td><?php echo $date?></td>
                        <td><?php echo $nom_filiere?></td>
                    </tr>
                </table>
            </center>
        <?php endif; ?>
        <br><br>

        <input type="submit" id="sub" value="Cherche">
    </form>
</body>
</html>