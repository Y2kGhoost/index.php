<?php
session_start();
$students = isset($_SESSION['etudiants']) ? $_SESSION['etudiants'] : [];
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$nom_filiere = isset($_SESSION['nom_filiere']) ? $_SESSION['nom_filiere'] : null;

unset($_SESSION['etudiants']);
unset($_SESSION['error']);
unset($_SESSION['nom_filiere']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etudiants</title>
    <link rel="stylesheet" href="../../css/output.css">

    <style>
        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
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
        <a href="./ajoutst.php">Ajouter Etudiant</a>
        <a href="./modfst.php">Modifier Etudiant</a>
        <a href="./cherchst.php">Chercher Etudiant</a>
        <a href="./suppst.php">Supprimer Etudiant</a>
        <a href="./listst.php" style="background-color: #575757;">Lister Etudiants</a>
    </nav>

    <form action="../../includes/Sthandl/listst.inc.php" method="post" id="form">
        <label for="filiere" id="lab">Filiere</label><br><br>
        <input type="text" name="fil" id="inp" placeholder="Filiere..."><br><br><br>

        <input type="submit" value="Lister" id="sub" name="subm"><br><br><br>

        <?php if ($error) : ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if (!empty($students)): ?>
            <center>
                <table id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Date de Naissance</th>
                            <th>Filiere</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['id_etudiant'])?></td>
                                <td><?php echo htmlspecialchars($student['nom'])?></td>
                                <td><?php echo htmlspecialchars($student['prenom'])?></td>
                                <td><?php echo htmlspecialchars($student['date_naissance'])?></td>
                                <td><?php echo htmlspecialchars($nom_filiere)?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </center>
        <?php endif; ?>
    </form>
</body>
</html>