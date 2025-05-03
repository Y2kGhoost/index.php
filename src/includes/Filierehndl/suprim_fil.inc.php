<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_fil = filter_input(INPUT_POST, "id_fil", FILTER_VALIDATE_INT);

    if (!$id_fil) {
        $_SESSION['error'] = "Veuillez sélectionner une filière valide.";
        header("Location: ../../HTML/Filieres/suprimfl.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";
        
        // Check if filière exists
        $stmt_filiere = $pdo->prepare("SELECT nom_filiere FROM filieres WHERE id_filiere = ?");
        $stmt_filiere->execute([$id_fil]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if (!$filiere) {
            $_SESSION['error'] = "Filière introuvable.";
            header("Location: ../../HTML/Filieres/suprimfl.php");
            exit;
        }

        // Check if filière has associated matières or students
        $check_matiere = $pdo->prepare("SELECT COUNT(*) FROM matieres WHERE id_filiere = ?");
        $check_matiere->execute([$id_fil]);
        
        $check_etudiant = $pdo->prepare("SELECT COUNT(*) FROM etudiants WHERE id_filiere = ?");
        $check_etudiant->execute([$id_fil]);

        if ($check_matiere->fetchColumn() > 0 || $check_etudiant->fetchColumn() > 0) {
            $_SESSION['error'] = "Impossible de supprimer: filière contient des matières ou étudiants.";
            header("Location: ../../HTML/Filieres/suprimfl.php");
            exit;
        }

        // Delete filière
        $stmt = $pdo->prepare("DELETE FROM filieres WHERE id_filiere = ?");
        $stmt->execute([$id_fil]);

        $_SESSION['nom_fil'] = $filiere['nom_filiere'];
        header("Location: ../../HTML/Filieres/suprimfl.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données";
        error_log("DB Error: " . $e->getMessage());
        header("Location: ../../HTML/Filieres/suprimfl.php");
        exit;
    }
}

header("Location: ../../HTML/Filieres/suprimfl.php");
exit;
?>