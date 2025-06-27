<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du lieu</title>
    <link rel="stylesheet" href="afficher_lieux.css">
    <style>
        .details-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 32px 28px;
        }
        .details-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 12px;
            color: #2d3a4b;
        }
        .details-image {
            width: 100%;
            max-height: 320px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 18px;
        }
        .details-label {
            font-weight: bold;
            color: #00a680;
        }
        .details-stars {
            color: #f7b731;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .details-section {
            margin-bottom: 14px;
        }
    </style>
</head>
<body>
<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="details-container">ID de lieu invalide.</div>';
    exit;
}
$id = intval($_GET['id']);
$conn = new mysqli("localhost", "root", "", "dreamex_places");
if ($conn->connect_error) {
    die("<div class='details-container'>Erreur de connexion à la base de données.</div>");
}
$sql = "SELECT * FROM lieux WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($lieu = $result->fetch_assoc()) {
    echo '<div class="details-container">';
    echo '<div class="details-title">' . htmlspecialchars($lieu["nom"]) . '</div>';
    // Correction du chemin de l'image si besoin
    $image_url = htmlspecialchars($lieu["image_url"]);
    if (strpos($image_url, 'images/') !== 0) {
        $image_url = 'images/' . $image_url;
    }
    echo '<img src="' . $image_url . '" class="details-image" alt="Image du lieu">';
    echo '<div class="details-stars">';
    $note = (int)$lieu["note"];
    for ($i = 1; $i <= 5; $i++) {
        echo $i <= $note ? '★' : '☆';
    }
    echo '</div>';
    echo '<div class="details-section"><span class="details-label">Catégorie :</span> ' . htmlspecialchars($lieu["categorie"]) . '</div>';
    echo '<div class="details-section"><span class="details-label">Adresse :</span> ' . htmlspecialchars($lieu["adresse"]) . '</div>';
    echo '<div class="details-section"><span class="details-label">Prix :</span> ' . htmlspecialchars($lieu["prix"]) . '</div>';
    echo '<div class="details-section"><span class="details-label">Services :</span> ' . htmlspecialchars($lieu["services"]) . '</div>';
    echo '<div class="details-section"><span class="details-label">Description :</span> ' . htmlspecialchars($lieu["description"]) . '</div>';
    echo '<div class="details-section"><span class="details-label">Avis :</span> ' . nl2br(htmlspecialchars($lieu["avis"])) . '</div>';
    echo '<a href="afficher_lieux.php" style="display:inline-block;margin-top:18px;color:#00a680;text-decoration:underline;">&larr; Retour à la liste</a>';
    // Ajout du mini stylo et du lien "Ajouter un avis"
    echo '<div style="margin-top:28px;text-align:right;">';
    echo '<span id="ajouter-avis-btn" style="cursor:pointer;color:#00a680;font-weight:500;display:inline-flex;align-items:center;">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#00a680" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" style="margin-right:6px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>Ajouter un avis</span>';
    echo '</div>';
    // Formulaire caché par défaut
    echo '<form id="form-avis" action="ajouter_avis.php" method="POST" style="display:none;margin-top:18px;">';
    echo '<input type="hidden" name="id" value="' . intval($lieu["id"]) . '">';
    echo '<label for="avis" style="display:block;margin-bottom:6px;">Votre avis :</label>';
    echo '<textarea name="avis" id="avis" rows="3" style="width:100%;margin-bottom:10px;resize:vertical;"></textarea>';
    echo '<label for="note" style="display:block;margin-bottom:6px;">Votre note :</label>';
    echo '<div id="note-stars">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<span class="star" data-value="' . $i . '" style="font-size:1.5rem;cursor:pointer;color:#ccc;">★</span>';
    }
    echo '</div>';
    echo '<input type="hidden" name="note" id="note" value="0">';
    echo '<button type="submit" style="margin-top:12px;background:#00a680;color:#fff;border:none;padding:8px 18px;border-radius:6px;cursor:pointer;">Envoyer</button>';
    echo '</form>';
    // Script JS pour afficher/cacher le formulaire et gérer les étoiles
    echo '<script>
    document.getElementById("ajouter-avis-btn").onclick = function() {
        var form = document.getElementById("form-avis");
        form.style.display = (form.style.display === "none") ? "block" : "none";
    };
    var stars = document.querySelectorAll("#note-stars .star");
    var noteInput = document.getElementById("note");
    stars.forEach(function(star, idx) {
        star.addEventListener("click", function() {
            var val = idx + 1;
            noteInput.value = val;
            stars.forEach(function(s, i) {
                s.style.color = (i < val) ? "#f7b731" : "#ccc";
            });
        });
    });
    </script>';
    echo '</div>';
} else {
    echo '<div class="details-container">Lieu non trouvé.</div>';
}
$stmt->close();
$conn->close();
?>
</body>
</html>
