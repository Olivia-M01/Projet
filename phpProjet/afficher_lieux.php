<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des lieux</title>
    <link rel="stylesheet" href="afficher_lieux.css">
</head>
<body>
    <div class="lieux-container">
    <?php
    //Connection à la base de données
    $conn = new mysqli("localhost", "root", "", "dreamex_places");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }lchars($lieu["image_url"]);
            if (strpos($image_url, 'images/') !== 0) {
                $image_url = 'images/' . $image_url;
            }
            echo '<img src="' . $image_url . '" class="lieu-image" alt="Image du lieu">';
            echo '<div class="lieu-content">';
            echo '<div class="lieu-title">' . htmlspecialchars($lieu["nom"]) . '</div>';
            echo '<div class="lieu-stars">';
            $note = (int)$lieu["note"];
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $note ? '★' : '☆';
            }
            echo '</div>';
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


    // Récupération des lieux
    $sql = "SELECT * FROM lieux";
    $result = $conn->query($sql);

    //Affichage
    if ($result->num_rows > 0) {
        while ($lieu = $result->fetch_assoc()) {
            echo '<div class="lieu-card">';
            // Correction du chemin de l'image si besoin
            $image_url = htmlspecia