<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_ens = htmlspecialchars($_POST["nom"]);
    $prenom_ens = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);

    try {  
        require_once "../dbh.inc.php";

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

        header("Location: ../../Enseignant/ajoutense.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../Enseignant/ajoutense.php");
}

