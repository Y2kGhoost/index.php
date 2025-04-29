<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etud = filter_input(INPUT_POST, "id_etud", FILTER_VALIDATE_INT);
    $id_mat = filter_input(INPUT_POST, "id_mat", FILTER_VALIDATE_INT);

    if (!$id_etud) {
        $_SESSION['error'] = "Étudiant intouvable.";
        header("Location ../../HTML/Evaluation/suprimrval.php");
        exit;
    } 
    if (!$id_mat) {
        $_SESSION['error'] = "Matiere Introuvable.";
        header("Location ../../HTML/Evaluation/suprimrval.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt_nom_prenom = $pdo->prepare("SELECT nom, prenom FROM etudiants WHERE id_etudiant = ?;");
        $stmt_nom_prenom->execute([$id_etud]);
        $nom_prenom = $stmt_nom_prenom->fetch(PDO::FETCH_ASSOC);

        if (!$nom_prenom) {
            $_SESSION['error'] = "Aucun étudiant trouvé avec cet ID.";
            header("Location ../../HTML/Evaluation/suprimrval.php");
            exit;
        }

        $stmt_matiere = $pdo->prepare("SELECT nom_matiere FROM matieres WHERE id_matiere = ?;");
        $stmt_matiere->execute([$id_mat]);
        $matiere = $stmt_matiere->fetch(PDO::FETCH_ASSOC);

        if (!$matiere) {
            $_SESSION['error'] = "Aucun matiere trouvé avec cet ID.";
            header("Location ../../HTML/Evaluation/suprimrval.php");
            exit;
        }

        $stmt_delete = $pdo->prepare("DELETE FROM evaluations WHERE id_etudiant = ? AND id_matiere = ?;");
        $stmt_delete->execute([$id_etud, $id_mat]);

        $_SESSION['success'] = "La note de l'étudiant " . htmlspecialchars($nom_prenom['nom']) . " " . htmlspecialchars($nom_prenom['prenom']) . " dans la matiere " . htmlspecialchars($matiere['nom_matiere']) . " a été supprimé avec succès.";

        $stmt_delete = null;
        $stmt_matiere = null;
        $stmt_nom_prenom = null;
        $pdo = null;

        header("Location ../../HTML/Evaluation/suprimrval.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error de requête: " . $e->getMessage();
        header("Location ../../HTML/Evaluation/suprimrval.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location ../../HTML/Evaluation/suprimrval.php");
    exit;
}