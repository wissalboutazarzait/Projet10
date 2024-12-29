<?php include('config.php'); ?>

<?php
$conn = new mysqli("localhost", "root", "", "gestion_produit");

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

$clients = $conn->query("SELECT  id_client, nom_client FROM client");
$produits = $conn->query("SELECT id_produit, Libellé FROM produit");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = $_POST['id_client']; 
    $id_produit = $_POST['id_produit'];
    $date_commande = $_POST['date_commande'];
    $etat = $_POST['etat'];
    $facture = $_POST['facture'];
    $mode_paiement = $_POST['mode_paiement'];
    $date_livraison = $_POST['date_livraison'];

    $sql = "INSERT INTO commande (id_client, id_produit, date_commande, etat, facture, mode_paiement, date_livraison) 
        VALUES ('$id_client', '$id_produit', '$date_commande', '$etat', '$facture', '$mode_paiement', '$date_livraison')";
  if ($conn->query($sql) === TRUE) {
    $order_success = $translations['order_success'];
    echo "<script>alert('Order added successfully');window.location.href='commande.php';</script>";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <title><?php echo htmlspecialchars($translations['add an Order']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2980B9;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, select {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        .actions input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions input[type="reset"] {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions a {
            padding: 20px 20px;
            background-color: #2980B9;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            line-height: 0.3;
            
        }

        .actions a:hover,
        .actions input[type="submit"]:hover,
        .actions input[type="reset"]:hover {
            background-color: #3e8e41;
        }

        .actions input[type="reset"]:hover {
            background-color: #d32f2f;
        }

        .actions a:hover {
            background-color: #21618C;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($translations['add an Order']); ?></h2>

        <form action="#" method="post">
        <label for="id_client"><?php echo htmlspecialchars($translations['customer']); ?></label>
    
    <select id="id_client" name="id_client" required>
    <option value=""><?php echo htmlspecialchars($translations['select a customer']); ?></option>
    <?php
    while ($client = $clients->fetch_assoc()) {
        echo "<option value='" . $client['id_client'] . " " . $client['nom_client'] . "'>" . $client['id_client'] . " " . $client['nom_client'] . "</option>";
    }
    ?>
</select>
          <label for="id_produit"><?php echo htmlspecialchars($translations['product']); ?></label>
<select id="id_produit" name="id_produit" required>
    <option value=""><?php echo htmlspecialchars($translations['select a product']); ?></option>
    <?php
    while ($produit = $produits->fetch_assoc()) {
        $id_produit = htmlspecialchars($produit['id_produit'], ENT_QUOTES, 'UTF-8');
        $libelle = htmlspecialchars($produit['Libellé'], ENT_QUOTES, 'UTF-8');
        echo "<option value='$id_produit'>$id_produit - $libelle</option>";
    }
    ?>
</select>
            <label for="date_commande"><?php echo htmlspecialchars($translations['order Date']); ?></label>
            <input type="date" id="date_commande" name="date_commande" required>

            <label for="etat"><?php echo htmlspecialchars($translations['state']); ?></label>
            <select id="etat" name="etat" required>
                <option value="En cours"><?php echo htmlspecialchars($translations['in progress']); ?></option>
                <option value="Expédié"><?php echo htmlspecialchars($translations['shipped']); ?></option>
                <option value="Livré"><?php echo htmlspecialchars($translations['delivered']); ?></option>
                <option value="Annulé"><?php echo htmlspecialchars($translations['cancelled']); ?></option>
            </select>

            <label for="facture"><?php echo htmlspecialchars($translations['invoice']); ?></label>
            <input type="text" id="facture" name="facture">
           
            <label for="mode_paiement"><?php echo htmlspecialchars($translations['payment Method']); ?></label>
            <select id="mode_paiement" name="mode_paiement" >
             <option value=""><?php echo htmlspecialchars($translations['select a payment method']); ?></option>
             <option value="Carte de crédit"><?php echo htmlspecialchars($translations['credit card']); ?></option>
             <option value="Paypal"><?php echo htmlspecialchars($translations['paypal']); ?></option>
             <option value="Virement bancaire"><?php echo htmlspecialchars($translations['wire transfer']); ?></option>
             <option value="Chèque"><?php echo htmlspecialchars($translations['cheque']); ?></option>
             <option value="Espèces"><?php echo htmlspecialchars($translations['cash']); ?></option>
            </select>



            <label for="date_livraison"><?php echo htmlspecialchars($translations['delivery date']); ?></label>
            <input type="date" id="date_livraison" name="date_livraison">

            <div class="actions">
                <input type="submit" value="<?php echo htmlspecialchars($translations['add']); ?>">
                <input type="reset" value="<?php echo htmlspecialchars($translations['reset']); ?>">
                <a href="commande.php"><?php echo htmlspecialchars($translations['return']); ?></a>
            </div>
        </form>
    </div>
</body>
</html>
