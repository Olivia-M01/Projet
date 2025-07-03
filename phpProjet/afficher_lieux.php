<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des lieux</title>
    <link rel="stylesheet" href="afficher_lieux.css">
</head>
<body>
    <button onclick="window.history.back();" style="position:fixed;top:18px;left:18px;z-index:1000;background:#cca12c;color:#fff;border:none;border-radius:5px;padding:8px 16px;cursor:pointer;font-weight:500;"><i class="fa fa-arrow-left"></i> Retour</button>
    <div class="lieux-container">
    <?php
    // Connection à la base de données
    $conn = new mysqli("localhost", "root", "", "dreamex_places");
    if ($conn->connect_error) {
        die("Connexion perdue: " . $conn->connect_error);
    }

    // Récupération du type depuis l'URL
    $categorie = isset($_GET['type']) ? $_GET['type'] : '';
    $recherche = isset($_GET['recherche']) ? trim($_GET['recherche']) : '';
    if (!empty($recherche)) {
        $rech = $conn->real_escape_string($recherche);
        $sql = "SELECT * FROM lieux WHERE nom LIKE '%$rech%' OR categorie LIKE '%$rech%' OR adresse LIKE '%$rech%' OR description LIKE '%$rech%'";
    } else if (!empty($categorie)) {
        // Accepte les variantes avec espace ou underscore
        $categorie_sql = $conn->real_escape_string($categorie);
        $categorie_sql_alt = str_replace('_', ' ', $categorie_sql);
        $sql = "SELECT * FROM lieux WHERE categorie='$categorie_sql' OR categorie='$categorie_sql_alt'";
    } else {
        $sql = "SELECT * FROM lieux";
    }
    $result = $conn->query($sql);
    if (!$result) {
        die("Erreur SQL : " . $conn->error);
    }

    // Affichage
    if ($result->num_rows > 0) {
        while ($lieu = $result->fetch_assoc()) {
            echo '<div class="lieu-card">';
            //Affichage de l'imagre
            $image_url = $lieu["image_url"];
            echo "<img src='" . htmlspecialchars($image_url) . "' alt='Image du lieu' class='lieu-image'>";
        
            //Info du lieu
            echo "<div class='lieu-content'>";
            echo "<div class='lieu-nom'>" . htmlspecialchars($lieu["nom"]) . "</div>";

            $note = (int)$lieu["note"];
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $note ? '★' : '☆';
            }
            echo '<div class="lieu-description">' . htmlspecialchars($lieu["description"]) . '</div>';
            echo '<div class="lieu-categorie" style="font-size:0.95rem;color:#666;margin-bottom:8px;"><strong>Catégorie :</strong> ' . htmlspecialchars($lieu["categorie"]) . '</div>';
            echo '<a href="details.php?id=' . urlencode($lieu["id"]) . '" class="lieu-btn">En savoir plus</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "Aucun lieu trouvé.";
    }

    $conn->close();
    ?>
    </div>
</body>
</html>