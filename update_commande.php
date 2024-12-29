<?php
include('config.php');

$conn = new mysqli("localhost", "root", "", "gestion_produit");

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_commande = $_POST['id_commande'];
    $id_client = $_POST['id_client'];
    $id_produit = $_POST['id_produit'];
    $date_commande = $_POST['date_commande'];
    $etat = $_POST['etat'];
    $facture = $_POST['facture'];
    $mode_paiement = $_POST['mode_paiement'];
    $date_livraison = $_POST['date_livraison'];

    $sql = "UPDATE commande SET id_client = ?, id_produit = ?, date_commande = ?, etat = ?, facture = ?, mode_paiement = ?, date_livraison = ? WHERE id_commande = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iisssssi", $id_client, $id_produit, $date_commande, $etat, $facture, $mode_paiement, $date_livraison, $id_commande);
        
        if ($stmt->execute()) {
            header("Location: commande.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête: " . $conn->error;
    }
}

$conn->close();
?>
