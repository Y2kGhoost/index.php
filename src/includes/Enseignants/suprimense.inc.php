<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_ens = filter_input(INPUT_POST, 'id_ens', FILTER_VALIDATE_INT);
    
    // Check if ID is invalid
    if (!$id_ens) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../HTML/Enseignant/suprimense.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt_nom_prenom = $pdo->prepare("SELECT nom, prenom FROM enseignants WHERE id_enseignant = ?;");
        $stmt_nom_prenom->execute([$id_ens]);
        $nom_prenom = $stmt_nom_prenom->fetch(PDO::FETCH_ASSOC);

        if (!$nom_prenom) {
            $_SESSION['error'] = "Aucun enseignant trouve avec cet ID";
            header("Location: ../../HTML/Enseignant/suprimense.php");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM enseignants WHERE id_enseignant = ?;");
        $stmt->execute([$id_ens]);

        $_SESSION['nom'] = $nom_prenom['nom'];
        $_SESSION['prenom'] = $nom_prenom['prenom'];

        // Redirect after deletion
        header("Location: ../../HTML/Enseignant/suprimense.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Query failed: " . $e->getMessage();
        header("Location: ../../HTML/Enseignant/suprimense.php");
        exit;
    }

} else {
    header("Location: ../../HTML/Enseignant/suprimense.php");
    exit;
}
