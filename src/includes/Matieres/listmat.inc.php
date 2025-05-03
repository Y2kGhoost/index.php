<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_filiere = filter_input(INPUT_POST, "filiere", FILTER_VALIDATE_INT);

    if (!$id_filiere) {
        $_SESSION['error'] = "Filière invalide.";
        header("Location: ../../HTML/Matieres/liste_mat.php");
        exit();
    }

    try {
        require_once "../dbh.inc.php";

        // Fetch filière name
        $query_filiere = "SELECT nom_filiere FROM filieres WHERE id_filiere = ?";
        $stmt_filiere = $pdo->prepare($query_filiere);
        $stmt_filiere->execute([$id_filiere]);
        $filiere_data = $stmt_filiere->fetch(PDO::FETCH_ASSOC);

        if ($filiere_data) {
            // Fetch matières for the filière, with enseignant name (if assigned)
            $query = "SELECT m.id_matiere, m.nom_matiere, e.nom AS nom_enseignant 
                      FROM matieres m
                      LEFT JOIN enseignants e ON m.id_enseignant = e.id_enseignant
                      WHERE m.id_filiere = ?
                      ORDER BY m.nom_matiere";

            $stmt = $pdo->prepare($query);
            $stmt->execute([$id_filiere]);
            $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['subjects'] = $subjects;
            $_SESSION['filiere'] = [
                'id_filiere' => $id_filiere,
                'nom_filiere' => $filiere_data['nom_filiere']
            ];
            $_SESSION['success'] = "Matières trouvées pour la filière sélectionnée.";
        } else {
            $_SESSION['error'] = "Filière introuvable.";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données : " . $e->getMessage();
    }

    // Redirect after processing
    header("Location: ../../HTML/Matieres/liste_mat.php");
    exit();
} else {
    // Invalid request method
    header("Location: ../../HTML/Matieres/liste_mat.php");
    exit();
}
