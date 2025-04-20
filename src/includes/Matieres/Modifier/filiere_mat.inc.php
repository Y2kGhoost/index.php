<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mat = filter_input(INPUT_POST, "id_mat", FILTER_VALIDATE_INT);
    $newFilId = filter_input(INPUT_POST, "newFil", FILTER_VALIDATE_INT);

    if (!$id_mat || !$newFilId) {
        $_SESSION['error'] = "ID ou Filière invalide.";
        header("Location: ../../../Matieres/Modifier/fil_mat.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt_filiere = $pdo->prepare("SELECT nom_filiere FROM filieres WHERE id_filiere = ?;");
        $stmt_filiere->execute([$newFilId]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if (!$filiere) {
            $_SESSION['error'] = "Filière introuvable.";
            header("Location: ../../../Matieres/Modifier/fil_mat.php");
            exit;
        }

        $stmt = $pdo->prepare("UPDATE matieres SET id_filiere = ? WHERE id_matiere = ?;");
        $stmt->execute([$newFilId, $id_mat]);

        $_SESSION['id_mat'] = $id_mat;
        $_SESSION['newFil'] = $filiere['nom_filiere'];
        $_SESSION['newFilId'] = $newFilId;

        header("Location: ../../../Matieres/Modifier/fil_mat.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
        header("Location: ../../../Matieres/Modifier/fil_mat.php");
        exit;
    }
} else {
    header("Location: ../../../Matieres/Modifier/fil_mat.php");
}
