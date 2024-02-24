<?php
// Ouverture de la session
session_start();

// Inclure la configuration de la BDD
require_once 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $motDePasse = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    // Requête SQL pour authentifier l'utilisateur
    $requeteAuthentification = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $requeteAuthentification->execute([$email]);
    $utilisateur = $requeteAuthentification->fetch();

    if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
        // L'utilisateur est authentifié
        $_SESSION['utilisateur'] = $utilisateur;
        header('Location: index.php');
        exit();
    } else {
        // L'authentification a échoué
        $messageErreur = 'Adresse email ou mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="connexionInscription">

    <div class="ci-container">
        <h1>Connexion</h1>

        <?php if (isset($messageErreur)) : ?>
            <p><?= $messageErreur; ?></p>
        <?php endif; ?>

        <form action="connexion.php" method="post">
            <div>
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div>
                <button type="submit">Se connecter</button>
            </div>
        </form>
        <a class="ci-link" href="inscription.php">Pas encore inscrit ? Inscrivez-vous ici</a>
    </div>

</body>

</html>