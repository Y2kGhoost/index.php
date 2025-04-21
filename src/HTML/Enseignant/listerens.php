<?php
session_start();

$enss = $_SESSION['ens'] ?? [];

unset($_SESSION['ens']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignants</title>
    <link rel="stylesheet" href="../../css/output.css">
</head>
<body>
    <nav id="mainMenu">
        <a href="../../home.php">Acceuil</a>
        <a href="../Students/students.php">Etudiants</a>
        <a href="enseignent.php" style="background-color: #575757;">Enseignants</a>
        <a href="../Matieres/matieres.php">Matières</a>
        <a href="../Filieres/filieres.php">Filières</a>
        <a href="../Notes/Note_stu.php">Relever du note</a>
    </nav>
    <nav id="secMenu">
        <a href="./ajoutense.php">Ajouter Enseignant</a>
        <a href="./modifense.php">Modifier Enseignant</a>
        <a href="./suprimense.php">Supprimer Enseignant</a>
        <a href="./listerens.php">Lister Enseignant</a>
    </nav>

    <form action="../../includes/Enseignants/lister_ens.inc.php" method="post" id="form">
        <input type="submit" value="Lister" id="sub">
    </form><br><br><br>
    <?php if (count($enss) > 0): ?>
        <center>
            <table id="table">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                </tr>
                <?php foreach($enss as $ens): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ens['id_enseignant']) ?></th>
                        <td><?php echo htmlspecialchars($ens['nom']) ?></th>
                        <td><?php echo htmlspecialchars($ens['prenom']) ?></th>
                        <td><?php echo htmlspecialchars($ens['email']) ?></th>
                    </tr>
                <?php endforeach; ?>
            </table>
        </center>
    <?php endif; ?>
</body>
</html>