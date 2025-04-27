<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
    $filiere_name = htmlspecialchars($_POST['filiere']);

    if (!$id_etudiant) {
        $_SESSION['error'] = "ID étudiant invalide.";
        header("Location: ../../../HTML/Students/modifier/modifierfl.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt_filiere = $pdo->prepare("SELECT id_filiere, nom_filiere FROM filieres WHERE nom_filiere = ?");
        $stmt_filiere->execute([$filiere_name]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if ($filiere) {
            $id_filiere = $filiere['id_filiere'];
            $nom_filiere = $filiere['nom_filiere'];

            $stmt = $pdo->prepare("UPDATE etudiants SET id_filiere = ? WHERE id_etudiant = ?");
            $stmt->execute([$id_filiere, $id_etudiant]);

            $_SESSION['id_etudiant'] = $id_etudiant;
            $_SESSION['nom_filiere'] = $nom_filiere;

            header("Location: ../../../HTML/Students/modifier/modifierfl.php");
            exit;
        } else {
            $_SESSION['error'] = "Filière non trouvée.";
            header("Location: ../../../HTML/Students/modifier/modifierfl.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur base de données : " . $e->getMessage();
        header("Location: ../../../HTML/Students/modifier/modifierfl.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../../HTML/Students/modifier/modifierfl.php");
    exit;
}
?>
