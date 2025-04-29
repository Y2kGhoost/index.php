<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_ens = filter_input(INPUT_POST, "id_ens", FILTER_VALIDATE_INT);
    $email = htmlspecialchars($_POST['email']);

    if (!$id_ens) {
        $_SESSION['error'] = "ID invalide.";
        header("Location: ../../../HTML/Enseignant/Modifier/Email.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt = $pdo->prepare("UPDATE enseignants SET email = ? WHERE id_enseignant = ?;");
        $stmt->execute([$email, $id_ens]);

        if ($stmt->rowCount() === 0) {
            $_SESSION['error'] = "Aucune modification effectuée. L'identifiant est peut-être incorrect.";
        } else {
            $_SESSION['success'] = "Email mis à jour avec succès pour l'enseignant ID $id_ens.";
        }

        header("Location: ../../../HTML/Enseignant/Modifier/Email.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Échec de la requête : " . $e->getMessage();
        header("Location: ../../../HTML/Enseignant/Modifier/Email.php");
        exit;
    }
} else {
    header("Location: ../../../HTML/Enseignant/Modifier/Email.php");
    exit;
}
