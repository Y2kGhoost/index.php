<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_matiere = htmlspecialchars($_POST["nom_matiere"]);
    $id_filiere = filter_input(INPUT_POST, "id_fil", FILTER_VALIDATE_INT);
    $id_enseignant = filter_input(INPUT_POST, "id_ens", FILTER_VALIDATE_INT);

    if (!$id_enseignant || !$id_filiere) {
        $_SESSION['error'] = "ID invalide";
        header("Location: ../../Matieres/ajoutmatie.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $stmt = $pdo->prepare("INSERT INTO matieres (nom_matiere, id_filiere, id_enseignant) VALUES (?, ?, ?);");
        $stmt->execute([$nom_matiere, $id_filiere, $id_enseignant]);

        $stmt_filiere = $pdo->prepare("SELECT nom_filiere FROM filieres WHERE id_filiere = ?");
        $stmt_filiere->execute([$id_filiere]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);
        $nom_filiere = $filiere ? $filiere['nom_filiere'] : 'Inconnu';

        $stmt_ens = $pdo->prepare("SELECT CONCAT(nom, ' ', prenom) AS nom_complet FROM enseignants WHERE id_enseignant = ?");
        $stmt_ens->execute([$id_enseignant]);
        $enseignant = $stmt_ens->fetch(PDO::FETCH_ASSOC);
        $nom_enseignant = $enseignant ? $enseignant['nom_complet'] : 'Inconnu';

        $_SESSION['nom_matiere'] = $nom_matiere;
        $_SESSION['nom_filiere'] = $nom_filiere;
        $_SESSION['nom_enseignant'] = $nom_enseignant;

        header("Location: ../../Matieres/ajoutmatie.php");
        exit;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../Matieres/ajoutmatie.php");
    exit();
}
