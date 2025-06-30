<?php include 'config.php'; ?>

<?php
$reponse = $pdo->query("SELECT * FROM lieux");

while ($lieu = $reponse->fetch()) {
    echo "<div class='lieu'>";
    echo "<h2>" . htmlspecialchars($lieu['nom']) . "</h2>";
    echo "<p>Type: " . htmlspecialchars($lieu['type']) . "</p>";
    echo "<p>Adresse: " . htmlspecialchars($lieu['adresse']) . "</p>";
    echo "<p>Prix: " . htmlspecialchars($lieu['prix']) . "</p>";
    echo "<p>Services: " . htmlspecialchars($lieu['services']) . "</p>";
    echo "<p>Description: " . htmlspecialchars($lieu['description']) . "</p>";
    echo "<p>Note: " . htmlspecialchars($lieu['note']) . "/5</p>";
    echo "<p>Avis: " . htmlspecialchars($lieu['avis']) . "</p>";

    if ($lieu['image']) {
        $imageData = base64_encode($lieu['image']);
        echo "<img src='data:image/jpeg;base64,$imageData' alt='Image de " . htmlspecialchars($lieu['nom']) . "' />";
    } else {
        echo "<p>Aucune image disponible.</p>";
    }

    echo "</div>";
}
?>
