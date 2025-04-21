<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_fil = filter_input(INPUT_POST, "id_fil", FILTER_VALIDATE_INT);
    $newFil = htmlspecialchars($_POST['newFil']);

    if (!$id_fil) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../HTML/Filieres/modifierfl.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt = $pdo->prepare("UPDATE filieres SET nom_filiere = ? WHERE id_filiere = ?;");
        $stmt->execute([$newFil, $id_fil]);

        $_SESSION['id_fil'] = $id_fil;
        $_SESSION['newFil'] = $newFil;

        header("Location: ../../HTML/Filieres/modifierfl.php");
        exit;
    } catch (PDOException $e) {
        die ("Error: " . $e->getMessage());
    }
} else {
    header("Location: ../../HTML/Filieres/modifierfl.php");
}