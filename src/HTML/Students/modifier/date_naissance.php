<?php
session_start();
$id_etudiant = isset($_SESSION['id_etudiant']) ? $_SESSION['id_etudiant'] : null;
$date_naissance = isset($_SESSION['date_naissance']) ? $_SESSION['date_naissance'] : null;

unset($_SESSION['id_etudiant']);
unset($_SESSION['date_naissance']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etudiants</title>
    <link rel="stylesheet" href="../../../css/body.css">
    <link rel="stylesheet" href="../../../css/MainMenu.css">
    <link rel="stylesheet" href="../../../css/secMenu.css">
    <link rel="stylesheet" href="../../../css/form.css">
    
</head>
<body>
    <nav id="mainMenu">
        <a href="../../../home.php">Acceuil</a>
        <a href="../students.php" style="background-color: #575757;">Etudiants </a>
        <a href="../../Enseignant/enseignent.php">Enseignants</a>
        <a href="../../Matieres/matieres.php">Matières</a>
        <a href="../../Filieres/filieres.php">Filières</a>
        <a href="../../Notes/Note_stu.php">Relever du note</a>
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
        <a href="./date_naissance.php" style="background-color: #575757;">Date de naissnace</a>
        <a href="./filiere.php">Filiere</a>
    </nav>

    <form action="../../../includes/Sthandl/Modifier/date-naissace-modif.inc.php" method="post" id="form">
        <label for="id" id="lab">ID Etudiant</label><br><br>
        <input type="number" name="id_etudiant" id="inp" placeholder="ID Etudiant..."><br><br><br>

        <label for="date-naissance" id="lab">Nouveau Date De Naissance</label><br><br>
        <input type="date" id="inp" name="date_naissance"><br><br><br>

        <input type="submit" value="Modifier" id="sub">

        <?php if ($id_etudiant && $date_naissance): ?>
            <p id="lab" style="color: green; font-weight: bold;">
                ✔️ Étudiant modifié avec succès<br>
                ID: <?= htmlspecialchars($id_etudiant) ?> | Date De Naissance: <?= htmlspecialchars($date_naissance) ?>
            </p>
        <?php endif; ?>
    </form>
</body>
</html>