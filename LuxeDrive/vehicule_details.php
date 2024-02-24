<?php
// Ouverture de la session
session_start();
// Inclure la configuration de la BDD
require_once 'config.php';

// Définir $idUtilisateur si l'utilisateur est connecté
$idUtilisateur = isset($_SESSION['utilisateur']) ? $_SESSION['utilisateur']['idUtilisateur'] : null;

// Définir $idAssurance en fonction de la valeur postée
$idAssurance = isset($_POST['assurance']) ? $_POST['assurance'] : null;

// Initialiser $details
$details = null;

// Initialisation des variables
$message = '';
$messageColor = '';
$dispo = false;

if (isset($_GET['id'])) {
    $idVehicule = $_GET['id'];

    // Requête pour récupérer les détails du véhicule avec la jointure
    $requeteDetails = $pdo->prepare("SELECT v.*, c.nom_carburant FROM vehicules v
                                    JOIN carburants c ON v.idCarburant = c.idCarburant
                                    WHERE v.idVehicule = ?");
    $requeteDetails->execute([$idVehicule]);

    // Vérifier si la requête a renvoyé des résultats
    if ($requeteDetails->rowCount() > 0) {
        // Récupérer les détails du véhicule
        $details = $requeteDetails->fetch();

        // Requête pour récupérer le chemin de la première photo du véhicule
        $requetePhotos = $pdo->prepare("SELECT chemin_photo FROM photos WHERE idVehicule = ?");
        $requetePhotos->execute([$idVehicule]);

        // Récupérer le chemin de la première photo
        $photos = $requetePhotos->fetch();
        $cheminPhoto = $photos['chemin_photo'];

        // Vérifier si le formulaire de réservation est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les dates de début et de fin soumises
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];

            $dateActuelle = date('Y-m-d');

            // Vérifier si la date de fin n'est pas inférieure à la date de début
            if (strtotime($dateFin) < strtotime($dateDebut)) {
                $message = 'La date de fin doit être postérieure à la date de début.';
                $messageColor = 'red';
            } elseif (strtotime($dateDebut) < strtotime($dateActuelle)) {
                // Vérifier si la date de début n'est pas déjà passée (peux louer pour le jour j)
                $message = 'La date de début ne peut pas être antérieure à la date actuelle.';
                $messageColor = 'red';
            } else {
                // Effectuer la requête pour vérifier la disponibilité
                $requeteDisponibilite = $pdo->prepare("SELECT * FROM reservations WHERE idVehicule = ? AND (
                (date_debut <= ? AND date_fin >= ?) OR
                (date_debut <= ? AND date_fin >= ?) OR
                (date_debut >= ? AND date_fin <= ?)
            )");

                $requeteDisponibilite->execute([
                    $idVehicule, $dateDebut, $dateDebut,
                    $dateFin, $dateFin,
                    $dateDebut, $dateFin
                ]);

                // Vérifier le résultat de la requête
                if ($requeteDisponibilite->rowCount() > 0) {
                    // Le véhicule n'est pas disponible
                    $message = 'Ce véhicule n\'est pas disponible pour les dates sélectionnées.<br>Nous vous invitons à choisir d\'autres dates ou un autre véhicule.';
                    $messageColor = 'red';
                } else {
                    // Le véhicule est disponible
                    $message = 'Votre réservation à bien été pris en compte.<br>Retrouvez la dans votre profil.';
                    $messageColor = 'green';
                    $dispo = true;

                    // Calculer le montant_total
                    $nombreJours = (strtotime($dateFin) - strtotime($dateDebut)) / (60 * 60 * 24) + 1;
                    $prixJournalier = $details['prix_journalier'];

                    // Récupérer le tarif quotidien de l'assurance sélectionnée depuis la BDD
                    $requeteTarifAssurance = $pdo->prepare("SELECT tarif_quotidien FROM assurances WHERE idAssurance = ?");
                    $requeteTarifAssurance->execute([$idAssurance]);
                    $tarifAssurance = $requeteTarifAssurance->fetchColumn();

                    // Calculer le montant total
                    $montantTotal = $nombreJours * ($prixJournalier + $tarifAssurance);

                    // Requête pour ajouter la réservation dans la table reservations
                    $requeteReservation = $pdo->prepare("
                    INSERT INTO reservations (idVehicule, idUtilisateur, date_debut, date_fin, idAssurance, montant_total)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");

                    $requeteReservation->execute([$idVehicule, $idUtilisateur, $dateDebut, $dateFin, $idAssurance, $montantTotal]);
                }
            }
        }
    } else {
        // Aucun résultat trouvé
        echo "Véhicule non trouvé.";
    }
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Véhicule <?= $details['modele']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="user-info">
        <?php if (isset($nom) && isset($prenom)) : ?>
            <a href="profil.php">Bienvenue, <?= $prenom . ' ' . $nom; ?></a>|
            <a href="deconnexion.php">Déconnexion</a>
        <?php else : ?>
            <a href="connexion.php">Connexion</a> | <a href="inscription.php">Inscription</a>
        <?php endif; ?>
    </div>

    <?php if ($details) : ?>
        <h1>Détails du véhicule <?= $details['modele']; ?></h1>

        <!-- Afficher la première photo du véhicule -->
        <div class="details-container">
            <img src="<?= $cheminPhoto; ?>" alt="Photo du véhicule <?= $details['modele']; ?>">

            <!-- Div pour les caractéristiques -->
            <div class="caracteristiques">
                <h3>Nom : <?= $details['modele']; ?></h3>
                <p>Couleur : <?= $details['couleur']; ?></p>
                <p>Transmission : <?= $details['transmission']; ?></p>
                <p>Carburant : <?= $details['nom_carburant']; ?></p>
                <p>Disponibilité : <?= ($details['disponible'] ? 'Disponible ' : 'Indisponible ') . $details['disponible'] . ' exemplaire(s) en stock.'; ?></p>
            </div>
        </div>

        <!-- Afficher les autres photos du véhicule -->
        <div class="photos-container">
            <?php
            while ($photos = $requetePhotos->fetch()) : ?>
                <img src="<?= $photos['chemin_photo']; ?>" alt="Photo du véhicule" class="rounded-image">
            <?php endwhile; ?>
        </div>

        <?php if (isset($_SESSION['utilisateur'])) : ?>
            <!-- Afficher le prix de la location -->
            <p class="prix">Prix de la location : <?= $details['prix_journalier']; ?> € / jour</p>

            <!-- L'utilisateur est connecté, afficher le formulaire de réservation -->
            <form method="POST" class="assuResa">
                <div class="assurance">
                    <?php
                    // Requête pour récupérer les descriptions de toutes les assurances
                    $requeteAssurances = $pdo->query("SELECT nom_assurance, description, tarif_quotidien FROM assurances");

                    // Afficher les descriptions des assurances
                    while ($assurance = $requeteAssurances->fetch()) : ?>
                        <p><b><?= $assurance['nom_assurance']; ?></b><br>
                            Description : <?= $assurance['description']; ?><br>
                            Prix : <?= $assurance['tarif_quotidien']; ?> € / jour</p>
                    <?php endwhile; ?>
                </div>

                <div class="reservation">
                    <label for="date_debut">Date de début :</label>
                    <input type="date" name="date_debut" required>
                    <label for="date_fin">Date de fin :</label>
                    <input type="date" name="date_fin" required>

                    <!-- Liste déroulante des assurances -->
                    <label for="assurance">Choisir une assurance :</label>
                    <select name="assurance" id="assurance">
                        <?php
                        // Requête pour récupérer les assurances
                        $requeteAssurances = $pdo->query("SELECT idAssurance, nom_assurance FROM assurances");

                        // Afficher les options de la liste déroulante
                        while ($assurance = $requeteAssurances->fetch()) {
                            echo '<option value="' . $assurance['idAssurance'] . '">' . $assurance['nom_assurance'] . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Bouton Réserver -->
                    <input type="submit" value="Réserver">
                    <p style="color: <?= $messageColor; ?>"><?= $message; ?></p>
                </div>
            </form>
        <?php else : ?>
            <!-- L'utilisateur n'est pas connecté, afficher le message pour se connecter/inscrire -->
            <p class="prix">Pour réserver ce véhicule, veuillez vous <a href="connexion.php">Connecter</a> ou vous <a href="inscription.php">Inscrire</a>.</p>
        <?php endif; ?>
    <?php else : ?>
        <p>Véhicule non trouvé.</p>
    <?php endif; ?>
</body>

</html>