<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM produit WHERE id_produit = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $sql = "SET @count = 0";
        $conn->query($sql);

        $sql = "UPDATE produit SET id_produit = @count := (@count + 1)";
        $conn->query($sql);

        $sql = "ALTER TABLE produit AUTO_INCREMENT = 1";
        $conn->query($sql);

        header("Location: Dashbord.php");
        exit();
    } else {
        echo "Erreur lors de la suppression d'un produit': " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
