<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_ens = filter_input(INPUT_POST, "id_ens", FILTER_VALIDATE_INT);
    $email = htmlspecialchars($_POST['email']);

    if (!$id_ens) {
        $_SESSION['error'] = "ID invalid.";
        header("Location: ../../../Enseignant/Modifier/Email.php");
        exit;
    }

    try {
        require_once "../../dbh.inc.php";

        $stmt = $pdo->prepare("UPDATE enseignants SET email = ? WHERE id_enseignant = ?;");
        $stmt->execute([$email, $id_ens]);

        $_SESSION['id_enseignant'] = $id_ens;
        $_SESSION['email'] = $email;

        header("Location: ../../../Enseignant/Modifier/Email.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error" . $e->getMessage();
        header("Location: ../../../Enseignant/Modifier/Email.php");
        exit;
    }
} else {
    header("Location: ../../../Enseignant/Modifier/Email.php");
}
