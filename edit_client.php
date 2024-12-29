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

if (!isset($_GET['nom_client'])) {
    die("Nom du client non spécifié.");
}

$nom_client = $_GET['nom_client'];

$sql = "SELECT * FROM client WHERE nom_client = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nom_client);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

if (!$client) {
    die("Client non trouvé.");
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['edit a client']; ?><</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            max-width: 800px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="email"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
            margin-left: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }

        button, .btn-return {
            padding: 8px 16px; 
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px; 
        }


        button {
            background-color: #4CAF50;
            color: white;
        }
        .btn-return {
            background-color: #2980B9;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-return:hover {
            background-color: #21618C;
        }
    </style>
</head>
<body>
    <form action="update_client.php" method="post">
        <h1><?php echo $translations['edit a customer']; ?></h1>
        <input type="hidden" name="id_client" value="<?php echo $client['id_client']; ?>">

        <input type="text" name="nom_client" placeholder="Nom" value="<?php echo htmlspecialchars($client['nom_client']); ?>" required>
        <input type="text" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars($client['prenom']); ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
        <input type="text" name="ville" placeholder="Ville" value="<?php echo htmlspecialchars($client['ville']); ?>" required>
        <input type="text" name="adresse" placeholder="Adresse" value="<?php echo htmlspecialchars($client['adresse']); ?>" required>
        <input type="text" name="numero_telephone" placeholder="Numéro de Téléphone" value="<?php echo htmlspecialchars($client['numero_telephone']); ?>" required>
        <div class="button-container">
            <button type="submit"><?php echo $translations['edit']; ?></button>
            <a href="client.php" class="btn-return"><?php echo $translations['return']; ?></a>

        </div>
        </form>
    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
    var nom = document.querySelector('input[name="nom_client"]').value;
    var prenom = document.querySelector('input[name="prenom"]').value;
    var email = document.querySelector('input[name="email"]').value;
    var ville = document.querySelector('input[name="ville"]').value;
    var adresse = document.querySelector('input[name="adresse"]').value;
    var numero_telephone = document.querySelector('input[name="numero_telephone"]').value;

    if (nom_client === "" || prenom === "" || email === "" || ville === "" || adresse === "" || numero_telephone === "") {
        alert("Tous les champs doivent être remplis.");
        event.preventDefault(); 
    }
});

    </script>
</body>
</html>
