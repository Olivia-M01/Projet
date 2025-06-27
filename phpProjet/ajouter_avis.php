<?php
// Ce script reçoit un avis et une note, puis les ajoute à la base de données pour le lieu donné.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['avis'], $_POST['note'])) {
    $id = intval($_POST['id']);
    $avis = trim($_POST['avis']);
    $note = intval($_POST['note']);
    $conn = new mysqli("localhost", "root", "", "dreamex_places");
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données.");
    }
    // Ici, on suppose que la table 'lieux' contient un champ 'avis' (texte) et 'note' (entier)
    // Pour un vrai système multi-avis, il faudrait une table 'avis' séparée
    $sql = "UPDATE lieux SET avis = CONCAT(IFNULL(avis,''), '\n', ?) , note = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $avis, $note, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: details.php?id=" . $id);
    exit;
} else {
    echo "Erreur lors de l'envoi de l'avis.";
}
