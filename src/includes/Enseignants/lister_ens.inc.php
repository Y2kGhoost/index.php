<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        require_once "../dbh.inc.php";
        $stmt = $pdo->prepare("SELECT * FROM enseignants;");
        $stmt->execute();
        $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['ens'] = $enseignants;

        header("Location: ../../HTML/Enseignant/listerens.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: ../../HTML/Enseignant/listerens.php");
        exit;
    }
} else {
    header("Location: ../../HTML/Enseignant/listerens.php");
    exit;
}
