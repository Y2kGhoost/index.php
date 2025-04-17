<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_ens = filter_input(INPUT_POST, 'id_enseignant', FILTER_VALIDATE_INT);
    
    if (!$id_ens) {
        die("ID invalide.");
        header("Location: ../../Enseignant/suprimense.php");
        exit;
    }
    try {
        require_once "../dbh.inc.php";

        $stmt_nom_prenom = $pdo->prepare("SELECT nom, prenom FROM enseignants WHERE id_enseignant = ?;");
        $stmt_nom_prenom->execute([$id_ens]);
        $nom_prenom = $stmt_nom_prenom->fetch(PDO::FETCH_ASSOC);
        if (!$nom_prenom) {
            error_log("Aucun enseignat trouve avec cet ID.");
            header("Location: ../../Enseignant/suprimense.php");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM enseignants WHERE id_enseignant = ?;");
        $stmt->execute([$id_ens]);

        $_SESSION['nom'] = $nom_prenom['nom'];
        $_SESSION['prenom'] = $nom_prenom['prenom'];

        header("Location: ../../Enseignant/suprimense.php");
        exit;
    } catch (PDOException $e) {
        error_log("Error de base de donnees: " . $e->getMessage());
        header("Location: ../../Enseignant/suprimense.php");
        exit;
    }

} else {
    header("Location: ../../Enseignant/suprimense.php");
    exit;
}

