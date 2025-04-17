<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
    $nom = htmlspecialchars($_POST['newNom']);
    $prenom = htmlspecialchars($_POST['newPrenom']);

    if (!$id_etudiant) {
        die("ID invalide");
        header("Location: ../../../Students/modifier/nom-prenom.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ? WHERE id_etudiant = ?;");
        $stmt->execute([$nom, $prenom, $id_etudiant]);

        $_SESSION['id_etudiant'] = $id_etudiant;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;

        header("Location: ../../../Students/modifier/nom-prenom.php");
    } catch (PDOException $e) {
        error_log("Error de base de donnees: " . $e->getMessage());
    }
} else {
    header("Location: ../../../Students/modifier/nom-prenom.php");
}