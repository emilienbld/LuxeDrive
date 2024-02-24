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

// Vérifier si le formulaire est soumis avec un identifiant de réservation valide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idReservation'])) {
    $idReservation = $_POST['idReservation'];
    $idUtilisateur = $_SESSION['utilisateur']['idUtilisateur'];

    // Requête pour vérifier si la réservation appartient à l'utilisateur connecté
    $requeteVerification = $pdo->prepare("SELECT * FROM reservations WHERE idReservation = ? AND idUtilisateur = ?");
    $requeteVerification->execute([$idReservation, $idUtilisateur]);

    if ($requeteVerification->rowCount() > 0) {
        // Si la réservation appartient à l'utilisateur alors procéder à l'annulation
        $requeteAnnulation = $pdo->prepare("DELETE FROM reservations WHERE idReservation = ?");
        $requeteAnnulation->execute([$idReservation]);

        // Redirection vers le profil avec un message de confirmation
        $_SESSION['message'] = 'La réservation a été annulée avec succès.';
        header('Location: profil.php');
        exit();
    } else {
        // La réservation ne peut pas être annulée
        $_SESSION['message'] = 'Vous ne pouvez pas annuler cette réservation. Contactez nous pour en savoirs les raisons.';
        header('Location: profil.php');
        exit();
    }
} else {
    // Rediriger vers le profil sans action valide
    header('Location: profil.php');
    exit();
}
