<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $filiere_name = htmlspecialchars($_POST["fil"]);

    try {
        require_once "../dbh.inc.php";

        $stmt_filiere = $pdo->prepare("SELECT id_filiere, nom_filiere FROM filieres WHERE nom_filiere = ?");
        $stmt_filiere->execute([$filiere_name]);
        $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if ($filiere) {
            $id_filiere = $filiere["id_filiere"];
            $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id_filiere = ?");
            $stmt->execute([$id_filiere]);

            $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['etudiants'] = $etudiants;
            $_SESSION['nom_filiere'] = $filiere['nom_filiere'];
            $_SESSION['success'] = "Filière et étudiants trouvés avec succès.";
        } else {
            $_SESSION['error'] = "Filière non trouvée.";
        }

        header("Location: ../../HTML/Students/listst.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de requête : " . $e->getMessage();
        header("Location: ../../HTML/Students/listst.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../HTML/Students/listst.php");
    exit;
}

