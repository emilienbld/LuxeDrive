<?php
// Ouverture de la session
session_start();

// Inclure la configuration de la BDD
require_once 'config.php';

if (isset($_GET['nom'])) {
    // Récupérer la marque depuis l'URL
    $marque = $_GET['nom'];
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modèles <?= $marque; ?></title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="user-info">
            <?php if (isset($nom, $prenom)) : ?>
                <a href="profil.php">Bienvenue, <?= $prenom . ' ' . $nom; ?></a>|
                <a href="deconnexion.php">Déconnexion</a>
            <?php else : ?>
                <a href="connexion.php">Connexion</a> | <a href="inscription.php">Inscription</a>
            <?php endif; ?>
        </div>

        <h1>Modèles de la marque <?= $marque; ?></h1>

        <?php
        // Requête pour récupérer les véhicules de la marque spécifiée
        $requete = $pdo->prepare("SELECT * FROM vehicules WHERE idMarque = (SELECT idMarque FROM marques WHERE nom_marque = ?)");
        $requete->execute([$marque]);

        // Afficher les véhicules
        while ($vehicule = $requete->fetch()) :
            // Requête pour récupérer les photos associées à ce véhicule
            $requetePhoto = $pdo->prepare("SELECT chemin_photo FROM photos WHERE idVehicule = ? LIMIT 1");
            $requetePhoto->execute([$vehicule['idVehicule']]);

            // Afficher la première photo du véhicule
            $photo = $requetePhoto->fetch();
        ?>
            <div class="vehicule-container">
                <?php if ($photo) : ?>
                    <img src="<?= $photo['chemin_photo']; ?>" alt="Photo du véhicule" class="vehicule-image">
                <?php endif; ?>

                <div class="vehicule-info">
                    <h2><?= $vehicule['modele']; ?></h2>
                    <p>Année : <?= $vehicule['annee']; ?></p>
                    <p>Couleur : <?= $vehicule['couleur']; ?></p>
                </div>

                <a href="vehicule_details.php?id=<?= $vehicule['idVehicule']; ?>" class="details-button">Voir les détails</a>
            </div>
    <?php endwhile;
    } else {
        header('Location: index.php');
        exit();
    }
    ?>

    </body>

    </html>