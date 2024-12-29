<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "UPDATE produit SET Description = '' WHERE id_produit = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Description supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de la description: " . $conn->error;
    }
}

$conn->close();
?>
