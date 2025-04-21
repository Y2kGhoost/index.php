<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_fil = htmlspecialchars($_POST["nomfil"]);

    try {
        require_once "../dbh.inc.php";

        $query = "INSERT INTO filieres (nom_filiere)
        VALUES (?);";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$nom_fil]);

        $_SESSION['nomfil'] = $nom_fil;

        $pdo = null;
        $stmt = null;

        header("Location: ../../HTML/Filieres/ajoutfl.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../../HTML/Filieres/ajoutfl.php");
}


