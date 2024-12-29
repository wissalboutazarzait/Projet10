<?php include('config.php'); ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

$nom_client = isset($_GET['nom']) ? $_GET['nom'] : '';
$prenom_client = isset($_GET['prenom']) ? $_GET['prenom'] : '';

if ($nom_client && $prenom_client) {
    $stmt = $conn->prepare("DELETE FROM client WHERE nom_client = ? AND prenom = ?");
    $stmt->bind_param("ss", $nom_client, $prenom_client);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => $translations['client_deleted']]);
    } else {
        echo json_encode(['success' => false, 'message' => $translations['delete_error']]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => $translations['missing_params']]);
}

$conn->close();
?>
