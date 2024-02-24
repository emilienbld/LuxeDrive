<?php
// Ouverture de la session
session_start();

// Inclure la configuration de la BDD
require_once 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $motDePasse = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    // Hachage du mdp
    $hashMotDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Requête SQL pour inscrire un nouvel utilisateur
    $requeteInscription = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    $requeteInscription->execute([$nom, $prenom, $email, $hashMotDePasse]);

    // Rediriger vers la page de connexion après l'inscription
    header('Location: connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="connexionInscription">

    <div class="ci-container">
        <h1>Inscription</h1>

        <form action="inscription.php" method="post">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div>
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div>
                <button type="submit">S'inscrire</button>
            </div>
        </form>
        <a class="ci-link" href="connexion.php">Vous avez un compte ? Connectez-vous ici</a>
    </div>

</body>

</html>