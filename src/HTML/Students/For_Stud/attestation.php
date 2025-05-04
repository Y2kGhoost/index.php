<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../includes/auth.inc.php';
requireRole('student');
require_once '../../../includes/dbh.inc.php';

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT e.nom, e.prenom, e.date_naissance, u.username 
                       FROM etudiants e 
                       JOIN users u ON e.user_id = u.id 
                       WHERE e.user_id = ?");
$stmt->execute([$userId]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de Scolarité</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" defer></script>
    <script src="../../../script/download.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            min-height: 100vh;
        }

        .attestation-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 140px);
            padding: 2rem;
        }

        .attestation-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            transition: all 0.3s ease;
        }

        .attestation-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .attestation-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
        }

        .school-logo {
            width: 120px;
            height: auto;
            display: block;
            margin: 0 auto 2rem;
        }

        .attestation-title {
            font-size: 2rem;
            color: #1e40af;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 1rem;
        }

        .attestation-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
        }

        .attestation-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #374151;
            text-align: justify;
            margin-bottom: 2rem;
        }

        .attestation-signature {
            text-align: right;
            font-style: italic;
            margin-bottom: 2rem;
            color: #4b5563;
        }

        .download-btn {
            display: block;
            margin: 0 auto;
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.4);
        }

        .official-stamp {
            width: 120px;
            height: 120px;
            position: absolute;
            bottom: 70px;
            right: 100px;
            opacity: 0.2;
            transform: rotate(-15deg);
        }

        .top-nav {
            background: linear-gradient(90deg, #1f2937, #111827);
            padding: 0.5rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sub-nav {
            background: linear-gradient(90deg, #374151, #1f2937);
            padding: 0.25rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .nav-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: translateX(3px);
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="container mx-auto flex overflow-x-auto justify-between items-center">
            <a href="./stud_for_stud_lol.php" class="nav-link text-white px-6 py-4 bg-gray-700 hover:bg-gray-600 transition-colors whitespace-nowrap flex items-center">
                <i class="fas fa-users mr-2"></i>Étudiants
            </a>
            <div class="ml-auto flex items-center">
                <button id="dark-mode-toggle" class="nav-link text-white px-4 py-2 hover:bg-gray-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-moon mr-2"></i>Mode Sombre
                </button>
            </div>
            <div class="flex">
                <button class="nav-link text-white px-4 py-2 hover:bg-gray-700 transition-colors whitespace-nowrap">
                    <i class="fas fa-sign-out-alt mr-2"></i><a href="../../login.php">Déconnexion</a>
                </button>
            </div>
        </div>
    </nav>

    <!-- Sub Navigation -->
    <nav class="sub-nav">
        <div class="container mx-auto flex overflow-x-auto">
            <a href="./Liste_etud.php" class="nav-link text-white px-6 py-3 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-list mr-2"></i>Lister les notes
            </a>
            <a href="./attestation.php" class="nav-link text-white px-6 py-3 bg-gray-600 hover:bg-gray-500 transition-colors whitespace-nowrap">
                <i class="fas fa-file-alt mr-2"></i>Attestation
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="attestation-container">
        <div id="attestation" 
             class="attestation-card"
             data-nom="<?php echo htmlspecialchars($etudiant['nom']); ?>"
             data-prenom="<?php echo htmlspecialchars($etudiant['prenom']); ?>"
             data-date-naissance="<?php echo htmlspecialchars($etudiant['date_naissance']); ?>"
             data-username="<?php echo htmlspecialchars($etudiant['username']); ?>">

            <img src="../../../assets/ests logo.png" alt="Logo du collège" class="school-logo">
            <h1 class="attestation-title">Attestation de Scolarité</h1>

            <div class="attestation-content">
                <p class="mb-4">
                    Nous certifions que <strong><?php echo htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']); ?></strong>,
                    né(e) le <strong><?php echo date('d/m/Y', strtotime($etudiant['date_naissance'])); ?></strong>,
                    est inscrit(e) en tant qu'étudiant(e) dans notre établissement pour l'année scolaire en cours.
                </p>

                <p class="mb-6">
                    Cette attestation est délivrée à la demande de l'intéressé(e) pour servir et valoir ce que de droit.
                </p>
            </div>

            <p class="attestation-signature">Fait le <?php echo date("d/m/Y"); ?></p>

            <!-- Simulated stamp/seal effect -->
            <div class="official-stamp">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="#1e40af" stroke-width="2" />
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#1e40af" stroke-width="1" />
                    <text x="50" y="40" text-anchor="middle" fill="#1e40af" font-size="8">ÉCOLE SUPÉRIEURE</text>
                    <text x="50" y="50" text-anchor="middle" fill="#1e40af" font-size="8">DE TECHNOLOGIE</text>
                    <text x="50" y="60" text-anchor="middle" fill="#1e40af" font-size="8">SALE</text>
                </svg>
            </div>

            <button id="download-btn" class="download-btn">
                <i class="fas fa-download mr-2"></i>Télécharger en PDF
            </button>
        </div>
    </div>
    <script src="../../../script/dark_shi.js"></script>
</body>
</html>
