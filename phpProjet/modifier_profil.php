<?php
session_start();
require_once 'config.php';

// Pour l'exemple, on suppose que l'utilisateur est connecté et son id est stocké en session
$user_id = $_SESSION['user_id'] ?? 1; // À adapter selon votre logique

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $postnom = $_POST['postnom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $genre = $_POST['genre'] ?? '';

    $sql = "UPDATE utilisateurs SET nom=?, postnom=?, prenom=?, email=?, telephone=?, genre=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $postnom, $prenom, $email, $telephone, $genre, $user_id]);
    echo 'success';
    exit;
}

// Récupérer les infos actuelles
$sql = "SELECT nom, postnom, prenom, email, telephone, genre FROM utilisateurs WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();
header('Content-Type: application/json');
echo json_encode($user);
