<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etud = filter_input(INPUT_POST, "id_etud", FILTER_VALIDATE_INT);
    $id_mat = filter_input(INPUT_POST, "id_mat", FILTER_VALIDATE_INT);
    $date = htmlspecialchars($_POST["date"]);
    $note = filter_input(INPUT_POST, "note", FILTER_VALIDATE_FLOAT);

    try {
        require_once "../dbh.inc.php";

        // Fetch student
        $stmt_nom_prenom = $pdo->prepare("SELECT nom, prenom FROM etudiants WHERE id_etudiant = ?;");
        $stmt_nom_prenom->execute([$id_etud]);
        $nom_prenom = $stmt_nom_prenom->fetch(PDO::FETCH_ASSOC);

        if (!$nom_prenom) {
            $_SESSION['error'] = "Étudiant introuvable.";
            header("Location: ../../HTML/Evaluation/Ajouteval.php");
            exit;
        }

        // Fetch subject
        $stmt_mat = $pdo->prepare("SELECT nom_matiere FROM matieres WHERE id_matiere = ?;");
        $stmt_mat->execute([$id_mat]);
        $matiere = $stmt_mat->fetch(PDO::FETCH_ASSOC);

        if (!$matiere) {
            $_SESSION['error'] = "Matière introuvable.";
            header("Location: ../../HTML/Evaluation/Ajouteval.php");
            exit;
        }

        // Insert evaluation
        $stmt_add = $pdo->prepare("INSERT INTO evaluations (id_etudiant, id_matiere, note, date_evaluation) VALUES (?, ?, ?, ?);");
        $stmt_add->execute([$id_etud, $id_mat, $note, $date]);

        $_SESSION['succes'] = "Évaluation ajoutée pour " . htmlspecialchars($nom_prenom['nom']) . " " . htmlspecialchars($nom_prenom['prenom']) . " en " . htmlspecialchars($matiere['nom_matiere']) . " (Note: $note)";

        header("Location: ../../HTML/Evaluation/Ajouteval.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données: " . $e->getMessage();
        header("Location: ../../HTML/Evaluation/Ajouteval.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../HTML/Evaluation/Ajouteval.php");
    exit;
}
