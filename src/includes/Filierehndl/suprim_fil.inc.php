<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_fil = filter_input(INPUT_POST, "id_fil", FILTER_VALIDATE_INT);

    if (!$id_fil) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../HTML/Filieres/suprimfl.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";
        
        $stmt_filiere = $pdo->prepare("SELECT nom_filiere FROM filieres WHERE id_filiere = ?;");
        $stmt_filiere->execute([$id_fil]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if (!$filiere) {
            $_SESSION['error'] = "Filiere introuvable.";
            header("Location: ../../Filieres/suprimfl.php");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM filieres WHERE id_filiere = ?;");
        $stmt->execute([$id_fil]);

        $_SESSION['nom_fil'] = $filiere['nom_filiere'];

        header("Location: ../../HTML/Filieres/suprimfl.php");
        exit;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../HTML/Filieres/suprimfl.php");
}