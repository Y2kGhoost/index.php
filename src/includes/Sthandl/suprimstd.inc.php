<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etudiant = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id_etudiant) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../HTML/Students/suppst.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt_nom_prenom = $pdo->prepare("SELECT nom, prenom FROM etudiants WHERE id_etudiant = ?");
        $stmt_nom_prenom->execute([$id_etudiant]);
        $nom_prenom = $stmt_nom_prenom->fetch(PDO::FETCH_ASSOC);

        if (!$nom_prenom) {
            $_SESSION['error'] = "Aucun étudiant trouvé avec cet ID.";
            header("Location: ../../HTML/Students/suppst.php");
            exit;
        }

        // Proceed to delete the student
        $stmt_delete = $pdo->prepare("DELETE FROM etudiants WHERE id_etudiant = ?");
        $stmt_delete->execute([$id_etudiant]);

        // Store the name of the student for success message
        $_SESSION['success'] = "L'étudiant " . $nom_prenom['nom'] . " " . $nom_prenom['prenom'] . " a été supprimé avec succès.";

        // Close the database connections
        $stmt_nom_prenom = null;
        $stmt_delete = null;
        $pdo = null;

        header("Location: ../../HTML/Students/suppst.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de requête : " . $e->getMessage();
        header("Location: ../../HTML/Students/suppst.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../HTML/Students/suppst.php");
    exit;
}
?>
