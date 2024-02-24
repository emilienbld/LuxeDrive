<?php
// Connexion à la BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=location_de_voitures;charset=utf8", "root", "");
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérification si l'utilisateur est connecté
if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $nom = $utilisateur['nom'];
    $prenom = $utilisateur['prenom'];
}
?>
