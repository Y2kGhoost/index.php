<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mat = filter_input(INPUT_POST, "id_mat", FILTER_VALIDATE_INT);
    $newNom = htmlspecialchars($_POST['newNom']);

    if (!$id_mat) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../../HTML/Matieres/Modifier/nom_mat.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt = $pdo->prepare("UPDATE matieres SET nom_matiere = ? WHERE id_matiere = ?;");
        $stmt->execute([$newNom, $id_mat]);

        $_SESSION['id_mat'] = $id_mat;
        $_SESSION['newNom'] = $newNom;

        header("Location: ../../../HTML/Matieres/Modifier/nom_mat.php");
        exit;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
        header("Location: ../../../HTML/Matieres/Modifier/nom_mat.php");
        exit;
    }
} else {
    header("Location: ../../../HTML/Matieres/Modifier/nom_mat.php");
}