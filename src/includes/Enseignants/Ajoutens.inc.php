<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_ens = htmlspecialchars($_POST["nom"]);
    $prenom_ens = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);

    try {  
        require_once "../dbh.inc.php";

        if (empty($nom_ens) || empty($prenom_ens) || empty($email)) {
            $_SESSION['error'] = "Tous les champs doivent être remplis.";
            header("Location: ../../HTML/Enseignant/ajoutense.php");
            die();
        }

        $query = "INSERT INTO enseignants (nom, prenom, email) 
        VALUES (?, ?, ?);";

        $smtm = $pdo->prepare($query);
        $smtm->execute([$nom_ens, $prenom_ens, $email]);

        $id_enseignant = $pdo->lastInsertId();

        $_SESSION['id_enseignant'] = $id_enseignant;
        $_SESSION['nom'] = $nom_ens;
        $_SESSION['prenom'] = $prenom_ens;
        $_SESSION['email'] = $email;

        $pdo = null;
        $smtm = null;

        header("Location: ../../HTML/Enseignant/ajoutense.php");
        die();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'ajout de l'enseignant: " . $e->getMessage();
        header("Location: ../../HTML/Enseignant/ajoutense.php");
        die();
    }
} else {
    $_SESSION['error'] = "La requête n'est pas valide.";
    header("Location: ../../HTML/Enseignant/ajoutense.php");
    die();
}
