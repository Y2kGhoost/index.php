<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_etud = filter_input(INPUT_POST, "id_etud", FILTER_VALIDATE_INT);

    if (!$id_etud) {
        $_SESSION['error'] = "ID étudiant invalide.";
        header("Location: ../../HTML/Students/note_etud.php");
        exit;
    }

    try {
        require_once "../dbh.inc.php";

        $query = "
            SELECT 
                e.nom, 
                e.prenom, 
                f.nom_filiere,
                m.nom_matiere,
                ev.note,
                ev.date_evaluation
            FROM 
                etudiants e
            JOIN 
                filieres f ON e.id_filiere = f.id_filiere
            LEFT JOIN 
                evaluations ev ON e.id_etudiant = ev.id_etudiant
            LEFT JOIN 
                matieres m ON ev.id_matiere = m.id_matiere
            WHERE 
                e.id_etudiant = ?
            ORDER BY 
                m.nom_matiere, ev.date_evaluation
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_etud]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // Organize data for display
            $student_info = [
                'nom' => $results[0]['nom'],
                'prenom' => $results[0]['prenom'],
                'nom_filiere' => $results[0]['nom_filiere']
            ];
            
            $subjects = [];
            foreach ($results as $row) {
                if ($row['nom_matiere']) {
                    $subjects[] = [
                        'matiere' => $row['nom_matiere'],
                        'note' => $row['note'],
                        'date_evaluation' => $row['date_evaluation']
                    ];
                }
            }

            $_SESSION['student_info'] = $student_info;
            $_SESSION['subjects'] = $subjects;
            $_SESSION['success'] = "Informations de l'étudiant trouvées avec succès.";
        } else {
            $_SESSION['error'] = "Aucun étudiant trouvé avec cet ID.";
        }

        header("Location: ../../HTML/Students/note_etud.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de requête : " . $e->getMessage();
        header("Location: ../../HTML/Students/note_etud.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: ../../HTML/Students/note_etud.php");
    exit;

}

?>

 



