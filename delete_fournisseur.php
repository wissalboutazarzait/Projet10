<?php
$mysqli = new mysqli('localhost', 'root', '', 'gestion_produit');

if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM fournisseur WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $query = "UPDATE fournisseur SET id = id - 1 WHERE id > ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $query = "ALTER TABLE fournisseur AUTO_INCREMENT = 1";
        $mysqli->query($query);

        header('Location: fournisseur.php');
        exit();
    } else {
        echo 'Erreur : ' . $mysqli->error;
    }
} else {
    echo 'ID de fournisseur non spécifié.';
    exit();
}

$mysqli->close();
?>

