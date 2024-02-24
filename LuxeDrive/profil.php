<?php
// Ouverture de la session
session_start();

// Inclure la configuration de la BDD
require_once 'config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit();
}

// Récupérer les informations de l'utilisateur
$utilisateur = $_SESSION['utilisateur'];
$idUtilisateur = $utilisateur['idUtilisateur'];
$nom = $utilisateur['nom'];
$prenom = $utilisateur['prenom'];

// Requête pour récupérer la date d'inscription de l'utilisateur
$requeteInscription = $pdo->prepare("SELECT date_inscription FROM utilisateurs WHERE idUtilisateur = ?");
$requeteInscription->execute([$idUtilisateur]);
$dateInscription = $requeteInscription->fetchColumn();

// Requête pour récupérer les réservations de l'utilisateur
$requeteReservations = $pdo->prepare("SELECT r.idReservation, v.modele, m.nom_marque, r.date_debut, r.date_fin, r.montant_total, p.chemin_photo
                                     FROM reservations r
                                     JOIN vehicules v ON r.idVehicule = v.idVehicule
                                     JOIN marques m ON v.idMarque = m.idMarque
                                     LEFT JOIN photos p ON v.idVehicule = p.idVehicule
                                     WHERE r.idUtilisateur = ?
                                     GROUP BY r.idReservation");
$requeteReservations->execute([$idUtilisateur]);
$reservations = $requeteReservations->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= $prenom . ' ' . $nom; ?></title>
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

    <h1>Profil de <?= $prenom . ' ' . $nom; ?></h1>

    <p>Date d'inscription : <?= $dateInscription; ?></p>

    <?php if (!empty($reservations)) : ?>
        <h2>Réservations :</h2>

        <table>
            <thead>
                <tr>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Montant total</th>
                    <th>Photo du véhicule</th>
                    <th>Annuler la réservation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?= $reservation['nom_marque']; ?></td>
                        <td><?= $reservation['modele']; ?></td>
                        <td><?= $reservation['date_debut']; ?></td>
                        <td><?= $reservation['date_fin']; ?></td>
                        <td><?= $reservation['montant_total']; ?> €</td>
                        <td>
                            <?php if ($reservation['chemin_photo']) : ?>
                                <img src="<?= $reservation['chemin_photo']; ?>" alt="Photo du véhicule" class="imgProfil">
                            <?php else : ?>
                                Aucune photo disponible
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Formulaire pour annuler la réservation -->
                            <form method="POST" action="annuler_reservation.php">
                                <input type="hidden" name="idReservation" value="<?= $reservation['idReservation']; ?>">
                                <input type="submit" value="Annuler la réservation" class="btnAnnulerResa">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Message de confirmation
        if (isset($_SESSION['message'])) {
            echo '<p style="color: green;">' . $_SESSION['message'] . '</p>';
            unset($_SESSION['message']); // Effacer le message après l'avoir affiché
        }
        ?>
    <?php else : ?>
        <h2>Aucune réservation pour le moment.</h2>
    <?php endif; ?>
</body>

</html>