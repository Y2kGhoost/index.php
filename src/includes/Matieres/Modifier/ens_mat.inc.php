<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mat = filter_input(INPUT_POST, "id_mat", FILTER_VALIDATE_INT);
    $newEnsId = filter_input(INPUT_POST, "newEns", FILTER_VALIDATE_INT);

    if (!$id_mat || !$newEnsId) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../../HTML/Matieres/Modifier/ens_mat.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        // Get enseignant name from ID
        $stmt_ens = $pdo->prepare("SELECT nom, prenom FROM enseignants WHERE id_enseignant = ?");
        $stmt_ens->execute([$newEnsId]);
        $ens = $stmt_ens->fetch(PDO::FETCH_ASSOC);

        if (!$ens) {
            $_SESSION['error'] = "Enseignant introuvable.";
            header("Location: ../../../HTML/Matieres/Modifier/ens_mat.php");
            exit;
        }

        // Update matiere
        $stmt = $pdo->prepare("UPDATE matieres SET id_enseignant = ? WHERE id_matiere = ?;");
        $stmt->execute([$newEnsId, $id_mat]);

        $_SESSION['id_mat'] = $id_mat;
        $_SESSION['newEns'] = $newEnsId;
        $_SESSION['newEnsName'] = $ens['nom'] . " " . $ens['prenom'];

        header("Location: ../../../HTML/Matieres/Modifier/ens_mat.php");
        exit;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
        header("Location: ../../../HTML/Matieres/Modifier/ens_mat.php");
        exit;
    }
} else {
    header("Location: ../../../HTML/Matieres/Modifier/ens_mat.php");
}
