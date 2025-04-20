<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mat = filter_input(INPUT_POST, "id_mat", FILTER_VALIDATE_INT);

    if (!$id_mat) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../Matieres/suprimematie.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt_matiere = $pdo->prepare("SELECT nom_matiere FROM matieres WHERE id_matiere = ?;");
        $stmt_matiere->execute([$id_mat]);
        $matiere = $stmt_matiere->fetch(PDO::FETCH_ASSOC);

        if (!$matiere) {
            $_SESSION['error'] = "Matière introuvable.";
            header("Location: ../../Matieres/suprimematie.php");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM matieres WHERE id_matiere = ?;");
        $stmt->execute([$id_mat]);

        $nom_mat = $matiere['nom_matiere'];

        $_SESSION['deleted_matiere'] = $nom_mat;

        header("Location: ../../Matieres/suprimematie.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
        header("Location: ../../Matieres/suprimematie.php");
        exit;
    }
} else {
    header("Location: ../../Matieres/suprimematie.php");
}
