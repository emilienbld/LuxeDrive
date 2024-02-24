<?php
// Ouverture de la session
session_start();

// Inclure la configuration de la BDD
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeDrive</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="index">
    <div class="user-info">
        <?php if (isset($nom, $prenom)) : ?>
            <a href="profil.php">Bienvenue, <?= $prenom . ' ' . $nom; ?></a>|
            <a href="deconnexion.php">Déconnexion</a>
        <?php else : ?>
            <a href="connexion.php">Connexion</a> | <a href="inscription.php">Inscription</a>
        <?php endif; ?>
    </div>

    <div class="luxedrive">
        <h1>Bienvenue chez LuxeDrive</h1>
        <p>Depuis 20 ans, LuxeDrive est votre partenaire de confiance pour la location de véhicules de luxe exceptionnels. Notre histoire commence avec la passion de partager le plaisir de conduire des voitures d'exception, alliant élégance, performance et confort.</p>

        <h3>Notre Histoire</h3>
        <p>Fondée en 2002, LuxeDrive a rapidement évolué pour devenir la référence incontestée dans le monde de la location de voitures haut de gamme. Forts de notre engagement envers la satisfaction de nos clients, nous avons élargi notre flotte pour inclure les derniers modèles des marques les plus prestigieuses.</p>

        <h3>Des Véhicules d'Exception</h3>
        <p>Chez LuxeDrive, chaque voiture est choisie avec soin pour offrir une expérience de conduite inégalée. Des supercars aux berlines de luxe, notre flotte est constamment mise à jour pour refléter l'élégance intemporelle et les performances de pointe.</p>

        <h3>Un Service Personnalisé</h3>
        <p>Notre équipe dévouée est là pour rendre votre expérience de location aussi agréable que possible. Nous comprenons que chaque client est unique, c'est pourquoi nous offrons un service personnalisé pour répondre à vos besoins spécifiques.</p>

        <h3>Explorez le Luxe</h3>
        <p>Découvrez notre site et explorez notre collection de véhicules de rêve. Que ce soit pour une occasion spéciale, une escapade en amoureux, ou simplement pour savourer le plaisir de conduire, LuxeDrive vous offre une expérience exceptionnelle à chaque kilomètre.</p>
        <p>Merci de faire partie de notre histoire chez LuxeDrive, où le luxe rencontre la route depuis deux décennies.</p>
    </div>

    <div class="marque-container">
        <?php
        // Récupérer les marques depuis la BDD
        $requete = $pdo->query("SELECT DISTINCT nom_marque, logo FROM marques");

        // Afficher un bouton pour chaque marque
        while ($row = $requete->fetch()) :
            $marque = $row['nom_marque'];
            $logo = $row['logo'];
        ?>
            <a href="model.php?nom=<?= urlencode($marque); ?>" class="marque-button">
                <img src="<?= $logo; ?>" alt="Logo de la marque <?= $marque; ?>">
                <p><?= $marque; ?></p>
            </a>

        <?php endwhile; ?>
    </div>
</body>

</html>