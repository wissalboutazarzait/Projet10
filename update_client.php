<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestion_produit";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Échec de la connexion: " . $conn->connect_error);
    }

    $id_client = $_POST['id_client'];
    $nom_client = $_POST['nom_client'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $numero_telephone = $_POST['numero_telephone'];

    $sql = "UPDATE client SET nom_client = ?, prenom = ?, email = ?, ville = ?, adresse = ?, numero_telephone = ? WHERE id_client = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nom_client, $prenom, $email, $ville, $adresse, $numero_telephone, $id_client);

    if ($stmt->execute()) {
        header("Location: client.php");
    } else {
        echo "Erreur lors de la mise à jour des informations : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
