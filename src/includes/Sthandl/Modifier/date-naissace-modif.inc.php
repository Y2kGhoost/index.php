<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);

    if (!$id_etudiant) {
        $_SESSION['error'] = "ID étudiant invalide.";
        header("Location: ../../../HTML/Students/modifier/date_naissance.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt = $pdo->prepare("UPDATE etudiants SET date_naissance = ? WHERE id_etudiant = ?;");
        $stmt->execute([$date_naissance, $id_etudiant]);

        $_SESSION['id_etudiant'] = $id_etudiant;
        $_SESSION['date_naissance'] = $date_naissance;
        $_SESSION['success'] = "Date de naissance mise à jour avec succès.";

        header("Location: ../../../HTML/Students/modifier/date_naissance.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur base de données : " . $e->getMessage();
        header("Location: ../../../HTML/Students/modifier/date_naissance.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../../HTML/Students/modifier/date_naissance.php");
    exit;
}
?>
