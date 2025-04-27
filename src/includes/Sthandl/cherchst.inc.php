<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);

    try {
        require_once "../dbh.inc.php";

        $query = "SELECT * FROM etudiants WHERE nom = ? AND prenom = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nom, $prenom]);

        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            $id_etudiant = $etudiant['id_etudiant'];
            $date = $etudiant['date_naissance'];
            $nom = $etudiant['nom'];
            $prenom = $etudiant['prenom'];
            $id_filiere = $etudiant['id_filiere'];

            $query_filiere = "SELECT nom_filiere FROM filieres WHERE id_filiere = ?";
            $stmt_filiere = $pdo->prepare($query_filiere);
            $stmt_filiere->execute([$id_filiere]);
            $filiere = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

            if ($filiere) {
                $nom_filiere = $filiere['nom_filiere'];
            } else {
                $_SESSION['error'] = "Filière non trouvée.";
                header("Location: ../../HTML/Students/cherchst.php");
                exit();
            }

            $_SESSION['id_etudiant'] = $id_etudiant;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['date_naissance'] = $date;
            $_SESSION['nom_filiere'] = $nom_filiere;

            $_SESSION['success'] = "Étudiant trouvé avec succès.";
            $pdo = null;
            $stmt = null;

            header("Location: ../../HTML/Students/cherchst.php");
            exit();
        } else {
            $_SESSION['error'] = "Étudiant non trouvé.";
            header("Location: ../../HTML/Students/cherchst.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de requête : " . $e->getMessage();
        header("Location: ../../HTML/Students/cherchst.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../HTML/Students/cherchst.php");
    exit();
}
?>
