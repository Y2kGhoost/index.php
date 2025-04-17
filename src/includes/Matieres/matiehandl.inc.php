<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_matiere = htmlspecialchars($_POST["nom_matiere"]);
    $nom_filiere = htmlspecialchars($_POST["nom_filiere"]);
    $nom_enseignant = htmlspecialchars($_POST["nom_enseignant"]);

    try {
        require_once "../dbh.inc.php";

        $query_filiere = "SELECT id_filiere FROM filieres WHERE nom_filiere = ?;";
        $stmt_filiere = $pdo->prepare($query_filiere);
        $stmt_filiere->execute([$nom_filiere]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if ($filiere) {
            $id_filiere = $filiere['id_filiere'];
        } else {
            die("Filiere not found");
        }

        $querey_enseignant = "SELECT id_enseignant FROM enseignants WHERE CONCAT(nom, ' ', prenom) = ?;";
        $stmt_enseignant = $pdo->prepare($querey_enseignant);
        $stmt_enseignant->execute([$nom_enseignant]);
        $enseignant = $stmt_enseignant->fetch(PDO::FETCH_ASSOC);

        if ($enseignant) {
            $id_enseignant = $filiere['id_enseignant'];
        } else {
            die("Enseignant not found");
        }

        $querey = "INSERT INTO matieres (nom_matiere, id_filiere, id_enseignant)
        VALUES (?, ?, ?);";
        $stmt = $pdo->prepare($querey);
        $stmt->execute([$nom_matiere, $nom_filiere, $nom_enseignant]);

        $pdo = null;
        $stmt = null;

        header("Location: ../../Matieres/ajoutmatie.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../Matieres/ajoutmatie.php");
}