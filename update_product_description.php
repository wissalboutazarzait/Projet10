<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

$id = $_POST['id'];
$description = $_POST['description'];

$sql = "UPDATE produit SET Description = ? WHERE id_produit = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $description, $id);

if ($stmt->execute()) {
    echo "Description mise à jour avec succès.";
} else {
    echo "Erreur: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
