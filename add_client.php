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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom_client'], $_POST['prenom'], $_POST['email'], $_POST['ville'], $_POST['adresse'], $_POST['numero_telephone']) &&
        !empty($_POST['nom_client']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['ville']) && !empty($_POST['adresse']) && !empty($_POST['numero_telephone'])) {

        $nom_client = $_POST['nom_client'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $ville = $_POST['ville'];
        $adresse = $_POST['adresse'];
        $numero_telephone = $_POST['numero_telephone'];

        $sql = "INSERT INTO client (nom_client, prenom, email, ville, adresse, numero_telephone) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nom_client, $prenom, $email, $ville, $adresse, $numero_telephone);

        if ($stmt->execute()) {
            header("Location: client.php");
            exit(); 
        } else {
            echo "Erreur lors de l'ajout du client: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['add_client']; ?></title>
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
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="email"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .back-btn {
            background-color: #3498DB;
            color: white;
        }

        .back-btn:hover {
            background-color: #2980B9;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        /* Styles pour aligner les boutons à gauche et à droite */
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    
    <form action="#" method="post">
        <h1><?php echo $translations['add_customer']; ?></h1>

        <input type="text" name="nom_client" placeholder="<?php echo $translations['name']; ?>" required>
        <input type="text" name="prenom" placeholder="<?php echo $translations['first name']; ?>" required>
        <input type="email" name="email" placeholder="<?php echo $translations['email']; ?>" required>
        <input type="text" name="ville" placeholder="<?php echo $translations['city']; ?>" required>
        <input type="text" name="adresse" placeholder="<?php echo $translations['address']; ?>" required>
        <input type="text" name="numero_telephone" placeholder="<?php echo $translations['phone_number']; ?>" required>
        <div class="form-buttons">
            <button type="submit" class="submit-btn"><?php echo $translations['add']; ?></button>
            <button type="button" class="back-btn" onclick="window.location.href='client.php'"><?php echo $translations['return']; ?></button>
        </div>
    </form>
</body>
</html>
