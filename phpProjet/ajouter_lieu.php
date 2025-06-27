<?php include 'config.php'; ?>
<?php ini_set('display_errors', 1);
error_reporting(E_ALL);?>

<form method="POST" action="" enctype="multipart/form-data">
    <input type="text" name="nom" placeholder="Nom du lieu" required><br>
    <input type="text" name="type" placeholder="Type (hôtel,restaurant,...)" required><br>
    <input type="text" name="adresse" placeholder="Adresse" required><br>
    <input type="text" name="prix" placeholder="Prix" required><br>
    <input type="text" name="services" placeholder="Services (wifi,parking,...)" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="number" step="0.1" name="note" placeholder="Note sur 5" required><br>
    <input type="text" name="avis" placeholder="Avis" required><br>
    <input type="file" name="image" accept="image/*" required><br>
    <button type="submit" name="ajouter">Ajouter Lieu</button>
</form>

<?php
if (isset($_POST['ajouter'])) {
    // Récupération des champs
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $adresse = $_POST['adresse'];
    $prix = $_POST['prix'];
    $services = $_POST['services'];
    $description = $_POST['description'];
    $note = $_POST['note'];
    $avis = $_POST['avis'];

    // Affichage pour vérification
    echo '<pre>';
    echo "nom : $nom\n";
    echo "type : $type\n";
    echo "adresse : $adresse\n";
    echo "prix : $prix\n";
    echo "services : $services\n";
    echo "description : $description\n";
    echo "note : $note\n";
    echo "avis : $avis\n";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        echo "image : Votre image a bien été enregisrée !\n";
    } else {
        echo "image : Erreur ou non reçue\n";
    }
    echo '</pre>';
    // Gestion de l'image
    $ajout_ok = false;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $stmt = $pdo->prepare("INSERT INTO lieux (nom, type, adresse, prix, services, description, note, avis, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $type, $adresse, $prix, $services, $description, $note, $avis, $image])) {
            $ajout_ok = true;
        }
    }
    // Message de confirmation ou d'erreur
    if ($ajout_ok) {
        echo '<div style="color:green;font-weight:bold;">Lieu ajouté avec succès !</div>';
    } else {
        echo '<div style="color:red;font-weight:bold;">Erreur lors de l\'ajout du lieu.</div>';
    }
}
?>

