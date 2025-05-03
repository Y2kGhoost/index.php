<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_fil = filter_input(INPUT_POST, "id_fil", FILTER_VALIDATE_INT);
    $newFil = trim($_POST['newFil']);

    if (!$id_fil) {
        $_SESSION['error'] = "Veuillez sélectionner une filière valide.";
        header("Location: ../../HTML/Filieres/modifierfl.php");
        exit;
    }

    if (empty($newFil)) {
        $_SESSION['error'] = "Le nouveau nom ne peut pas être vide.";
        header("Location: ../../HTML/Filieres/modifierfl.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        // Verify filière exists
        $stmt_check = $pdo->prepare("SELECT id_filiere FROM filieres WHERE id_filiere = ?");
        $stmt_check->execute([$id_fil]);
        
        if (!$stmt_check->fetch()) {
            $_SESSION['error'] = "Filière introuvable.";
            header("Location: ../../HTML/Filieres/modifierfl.php");
            exit;
        }

        // Check if new name already exists
        $stmt_exists = $pdo->prepare("SELECT id_filiere FROM filieres WHERE nom_filiere = ? AND id_filiere != ?");
        $stmt_exists->execute([$newFil, $id_fil]);
        
        if ($stmt_exists->fetch()) {
            $_SESSION['error'] = "Une filière avec ce nom existe déjà.";
            header("Location: ../../HTML/Filieres/modifierfl.php");
            exit;
        }

        // Update filière
        $stmt = $pdo->prepare("UPDATE filieres SET nom_filiere = ? WHERE id_filiere = ?");
        $stmt->execute([$newFil, $id_fil]);

        $_SESSION['id_fil'] = $id_fil;
        $_SESSION['newFil'] = $newFil;
        header("Location: ../../HTML/Filieres/modifierfl.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données: " . $e->getMessage();
        error_log("DB Error: " . $e->getMessage());
        header("Location: ../../HTML/Filieres/modifierfl.php");
        exit;
    }
}

header("Location: ../../HTML/Filieres/modifierfl.php");
exit;
?>