<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../HTML/Students/modifier/nom-prenom.php");
    exit;
}

$id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
$nom = trim(htmlspecialchars($_POST['newNom'] ?? ''));
$prenom = trim(htmlspecialchars($_POST['newPrenom'] ?? ''));

if (!$id_etudiant || empty($nom) || empty($prenom)) {
    $_SESSION['error'] = "Données invalides";
    header("Location: ../../../HTML/Students/modifier/nom-prenom.php");
    exit;
}

try {
    require_once "../../dbh.inc.php";
    
    $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ? WHERE id_etudiant = ?");
    $success = $stmt->execute([$nom, $prenom, $id_etudiant]);
    
    if ($success && $stmt->rowCount() > 0) {
        $_SESSION['id_etudiant'] = $id_etudiant;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['success'] = "Modification réussie";
    } else {
        $_SESSION['error'] = "Aucune modification effectuée";
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "Une erreur est survenue";
}

header("Location: ../../../HTML/Students/modifier/nom-prenom.php");
exit;