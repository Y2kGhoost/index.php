<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $date = htmlspecialchars($_POST["date"]);
    $filiere_name = htmlspecialchars($_POST["filiere"]);

    try {
        require_once "../dbh.inc.php";

        $query_filiere = "SELECT id_filiere FROM filieres WHERE nom_filiere = ?";
        $stmt_filiere = $pdo->prepare($query_filiere);
        $stmt_filiere->execute([$filiere_name]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if ($filiere) {
            $id_filiere = $filiere['id_filiere'];

            $query = "INSERT INTO etudiants (nom, prenom, date_naissance, id_filiere) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nom, $prenom, $date, $id_filiere]);

            $id_etudiant = $pdo->lastInsertId();

            $_SESSION['id_etudiant'] = $id_etudiant;

            $pdo = null;
            $stmt = null;
            $stmt_filiere = null;

            header("Location: ../../Students/ajoutst.php");
            exit();
        } else {
            die("Filière not found.");
        }

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../Students/ajoutst.php");
}

