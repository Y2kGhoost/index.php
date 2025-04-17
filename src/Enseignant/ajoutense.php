<?php
session_start();

$id_enseignant = isset($_SESSION['id_enseignant']) ? $_SESSION['id_enseignant'] : null;
$nom_ens = isset($_SESSION['nom']) ? $_SESSION['nom'] : null;
$prenom_ens = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : null;
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

unset($_SESSION['id_enseignant']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
unset($_SESSION['email']);
?>

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
        <a href="./modifense.php">Modifier Enseignant</a>
        <a href="./suprimense.php">Supprimer Enseignant</a>
    </nav>

    <form action="../includes/Enseignants/Ajoutens.inc.php" method="post" id="form">
        <label for="name" id="lab">Nom</label><br><br>
        <input type="text" id="inp" name="nom" placeholder="Le Nom..." require><br><br><br>
        
        <label for="prenom" id="lab">Prenom</label><br><br>
        <input type="text" id="inp" name="prenom" placeholder="Le Prenom..." require><br><br><br>

        <label for="email" id="lab">Email</label><br><br>
        <input type="email" id="inp" name="email" placeholder="Email..." require><br><br><br>

        <input type="submit" id="sub" name="subm" value="Valider">
        <?php if($id_enseignant && $nom_ens && $prenom_ens && $email): ?>
            <p id="lab" style="color: green; font-weight: bold;">
                ✔️ Enseignant Ajouter avec succès<br>
                ID: <?= htmlspecialchars($id_enseignant) ?> | Nom: <?= htmlspecialchars($nom_ens) ?> | Prenom: <?= htmlspecialchars($prenom_ens) ?> | Email: <?= htmlspecialchars($email) ?>
            </p>
        <?php endif; ?>
    </form>
</body>
</html>