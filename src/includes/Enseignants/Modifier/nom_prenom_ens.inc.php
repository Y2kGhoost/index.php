<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_ens = filter_input(INPUT_POST, "id_ens", FILTER_VALIDATE_INT);
    $nom = htmlspecialchars($_POST['newNom']);
    $prenom = htmlspecialchars($_POST['newPrenom']);

    if (!$id_ens) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../../HTML/Enseignant/Modifier/Nom_Prenom.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";
        $stmt = $pdo->prepare("UPDATE enseignants SET nom = ?, prenom = ? WHERE id_enseignant = ?;");
        $stmt->execute([$nom, $prenom, $id_ens]);

        $_SESSION['id_enseignant'] = $id_ens;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;

        header("Location: ../../../HTML/Enseignant/Modifier/Nom_Prenom.php");
        exit;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../../HTML/Enseignant/Modifier/Nom_Prenom.php");
}