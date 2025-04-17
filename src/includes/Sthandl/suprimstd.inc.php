<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etudiant = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id_etudiant) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../Students/suppst.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt_nom_prenom = $pdo->prepare("SELECT nom, prenom FROM etudiants WHERE id_etudiant = ?");
        $stmt_nom_prenom->execute([$id_etudiant]);
        $nom_prenom = $stmt_nom_prenom->fetch(PDO::FETCH_ASSOC);

        if (!$nom_prenom) {
            $_SESSION['error'] = "Aucun étudiant trouvé avec cet ID.";
            header("Location: ../../Students/suppst.php");
            exit;
        }

        $smtm = $pdo->prepare("DELETE FROM etudiants WHERE id_etudiant = ?");
        $smtm->execute([$id_etudiant]);

        $_SESSION['nom'] = $nom_prenom['nom'];
        $_SESSION['prenom'] = $nom_prenom['prenom'];

        $stmt_nom_prenom = null;
        $smtm = null;
        $pdo = null;

        header("Location: ../../Students/suppst.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données : " . $e->getMessage();
        header("Location: ../../Students/suppst.php");
        exit;
    }
} else {
    header("Location: ../../Students/suppst.php");
    exit;
}
