<?php include('config.php'); ?>
<?php
$conn = new mysqli("localhost", "root", "", "gestion_produit");

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_commande = $_GET['id'];

    $sql = "SELECT id_commande, id_client, id_produit, date_commande, etat, facture, mode_paiement, date_livraison FROM commande WHERE id_commande = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_commande);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $commande = $result->fetch_assoc();
        } else {
            echo "Commande non trouvée.";
            exit();
        }

        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête: " . $conn->error;
    }

    $sql_produits = "SELECT id_produit, Libellé FROM produit";
    $result_produits = $conn->query($sql_produits);
    $produits = [];
    if ($result_produits->num_rows > 0) {
        while ($row = $result_produits->fetch_assoc()) {
            $produits[] = $row;
        }
    }

    $sql_clients = "SELECT id_client, nom_client FROM client";
    $result_clients = $conn->query($sql_clients);
    $clients = [];
    if ($result_clients->num_rows > 0) {
        while ($row = $result_clients->fetch_assoc()) {
            $clients[] = $row;
        }
    }
} else {
    echo "ID de commande non spécifié.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo htmlspecialchars($translations['modify Order']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }        
        
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-container button,
        .button-container input[type="submit"] {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: auto;
            font-size: 14px;
        }

        .button-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        .button-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .button-container button {
            background-color: #007BFF; 
            color: white;
        }

        .button-container button:hover {
            background-color: #0056b3; 
        }

        .button-container .left-button {
            margin-left: auto; 

        }

        .button-container .right-button {
            margin-right: auto; 
        }

    </style>
</head>
<body>
    <div class="container">
        <form action="update_commande.php" method="POST">
        <h2><?php echo htmlspecialchars($translations['modify Order']); ?></h2>

            <input type="hidden" name="id_commande" value="<?php echo htmlspecialchars($commande['id_commande']); ?>">
            <input type="hidden" name="id_client" value="<?php echo htmlspecialchars($commande['id_client']); ?>">
            
            <label for="id_client"><?php echo htmlspecialchars($translations['customer']); ?></label>
            <select id="id_client" name="id_client" required>
                <?php foreach ($clients as $client): ?>
                    <option value="<?php echo htmlspecialchars($client['id_client']); ?>" 
                        <?php echo ($client['id_client'] == $commande['id_client']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($client['id_client'] . ' - ' . $client['nom_client']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="id_produit"><?php echo htmlspecialchars($translations['product']); ?> </label>
            <select id="id_produit" name="id_produit" required>
                <?php foreach ($produits as $produit): ?>
                    <option value="<?php echo htmlspecialchars($produit['id_produit']); ?>" 
                        <?php echo ($produit['id_produit'] == $commande['id_produit']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($produit['id_produit'] . " - " . $produit['Libellé']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            
            <label for="date_commande"><?php echo htmlspecialchars($translations['order Date']); ?></label>
            <input type="date" id="date_commande" name="date_commande" value="<?php echo htmlspecialchars($commande['date_commande']); ?>" required><br>
            
            <label for="etat"><?php echo htmlspecialchars($translations['state']); ?></label>
            <select id="etat" name="etat" required>
                <option value="En cours" <?php echo ($commande['etat'] == "En cours") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['in progress']); ?></option>
                <option value="Expédié" <?php echo ($commande['etat'] == "Expédié") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['shipped']); ?></option>
                <option value="Livré" <?php echo ($commande['etat'] == "Livré") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['delivered']); ?></option>
                <option value="Annulé" <?php echo ($commande['etat'] == "Annulé") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['cancelled']); ?></option>
            </select><br>

            <label for="facture"><?php echo htmlspecialchars($translations['invoice']); ?></label>
            <input type="text" id="facture" name="facture" value="<?php echo htmlspecialchars($commande['facture']); ?>" required><br>
            
            <label for="mode_paiement"><?php echo htmlspecialchars($translations['payment Method']); ?></label>
            <select id="mode_paiement" name="mode_paiement" required>
                <option value="Carte de crédit" <?php echo ($commande['mode_paiement'] == "Carte de crédit") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['credit card']); ?></option>
                <option value="Paypal" <?php echo ($commande['mode_paiement'] == "Paypal") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['paypal']); ?></option>
                <option value="Virement bancaire" <?php echo ($commande['mode_paiement'] == "Virement bancaire") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['wire transfer']); ?></option>
                <option value="Chèque" <?php echo ($commande['mode_paiement'] == "Chèque") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['cheque']); ?></option>
                <option value="Espèces" <?php echo ($commande['mode_paiement'] == "Espèces") ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['cash']); ?></option>
            </select><br>

            <label for="date_livraison"><?php echo htmlspecialchars($translations['delivery date']); ?></label>
            <input type="date" id="date_livraison" name="date_livraison" value="<?php echo htmlspecialchars($commande['date_livraison']); ?>" ><br>

            <div class="button-container">
                <input type="submit" value="<?php echo htmlspecialchars($translations['edit']); ?>">
                <button type="button" class="left-button"><a href="commande.php" style="text-decoration: none; color: white;"><?php echo htmlspecialchars($translations['return']); ?></a></button>

            </div>
        </form>
    </div>
</body>
</html>
