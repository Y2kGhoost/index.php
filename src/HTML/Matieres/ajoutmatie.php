<?php
session_start();

$nom_filiere = isset($_SESSION['nom_filiere']) ? $_SESSION['nom_filiere'] : null;
$nom_matiere = isset($_SESSION['nom_matiere']) ? $_SESSION['nom_matiere'] : null;
$nom_ens = isset($_SESSION['nom_enseignant']) ? $_SESSION['nom_enseignant'] : null;

unset($_SESSION['nom_filiere']);
unset($_SESSION['nom_matiere']);
unset($_SESSION['nom_enseignant']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
    <link rel="stylesheet" href="../../css/MainMenu.css">
    <link rel="stylesheet" href="../../css/secMenu.css">
    <link rel="stylesheet" href="../../css/body.css">
    <link rel="stylesheet" href="../../css/form.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="../Enseignant/enseignent.php">Enseignants</a>
        <a href="matieres.php" style="background-color: #575757;">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
        <a href="../Notes/Note_stu.php">Relever du note</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutmatie.php" style="background-color: #575757;">Ajouter Matière</a>
        <a href="./modifmatie.php">Modifier Matière</a>
        <a href="./suprimematie.php">Supprimer Matière</a>
    </nav>

    <form action="../../includes/Matieres/Ajout_matie.inc.php" method="post" id="form" name="insert">
        <label for="name" id="lab">Nom</label><br><br>
        <input type="text" id="inp" name="nom_matiere" placeholder="Le Nom..." require><br><br><br>
        
        <label for="nom_fil" id="lab">ID Filiere</label><br><br>
        <input type="number" id="inp" name="id_fil" placeholder="ID filiere..." require><br><br><br>

        <label for="nom_ens" id="lab">ID Enseignant</label><br><br>
        <input type="number" id="inp" name="id_ens" placeholder="ID Enseignant..." require><br><br><br>

        <input type="submit" id="sub" name="subm" value="Valider">

        <?php if ($nom_ens && $nom_filiere && $nom_matiere): ?>
            <p id="lab" style="color: green; font-weight: bold">
                ✔️ Matiere Ajouter avec succes <br>
                Nom Matiere: <?= htmlspecialchars($nom_matiere) ?> | Nom Filiere: <?= htmlspecialchars($nom_filiere) ?> | Nom Enseignant: <?= htmlspecialchars($nom_ens) ?>
            </p>
        <?php endif; ?>
    </form>
</body>
</html>