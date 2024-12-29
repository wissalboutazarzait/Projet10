<?php include('config.php'); ?>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'gestion_produit');

if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}


$query_produit = "SELECT id_produit, Libellé FROM produit";
$result_produit = $mysqli->query($query_produit);

if (isset($_POST['add_supplier'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $numero_telephone = $_POST['numero_telephone'];
    $email = $_POST['email'];
    $id_produit = $_POST['id_produit'];
    $quantite = $_POST['quantite'];
    $prix_unitaire = $_POST['prix_unitaire'];
    $montant_total = $_POST['montant_total'];
    $date_livraison = $_POST['date_livraison'];

    $query = "INSERT INTO fournisseur (nom, prenom, ville, adresse, numero_telephone, email, id_produit, quantite, prix_unitaire, montant_total, date_livraison) 
              VALUES ('$nom', '$prenom', '$ville', '$adresse', '$numero_telephone', '$email', '$id_produit', '$quantite', '$prix_unitaire', '$montant_total', '$date_livraison')";

    if ($mysqli->query($query)) {
        header('Location: fournisseur.php');
        exit();
    } else {
        echo 'Erreur : ' . $mysqli->error;
    }
}

$produitsQuery = "SELECT id_produit, Libellé FROM produit";
$produitsResult = $mysqli->query($produitsQuery);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($translations['add supplier']); ?></title>
    <style>
     body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    width: 80%; 
    max-width: 1200px; 
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    margin-bottom: 10px; 
}

input[type="text"],
input[type="tel"],
input[type="email"],
input[type="number"],
input[type="date"],
select {
    width: calc(100% - 10px); 
    padding: 8px;  
    margin: 0 0 10px 0; 
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px; 
}

label {
    display: block;
    margin: 5px; 
    font-size: 14px; 
    color: #333;
    
}

button {
    padding: 8px 16px; 
    margin: 8px 3px; 
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-reset {
    background-color: #f44336;
    color: white;
}

.btn-add-supplier {
    background-color: #4CAF50;
    color: white;
}

.back-btn {
    padding: 8px 16px; 
    background-color: #3498DB;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    float: right;
    margin-bottom: 10px; 
}

.back-btn:hover {
    background-color: #2980B9;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px; 
}


    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($translations['add supplier']); ?></h1>
        <button class="back-btn" onclick="window.location.href='fournisseur.php'"><?php echo htmlspecialchars($translations['return']); ?></button>

        <div class="form-container">
            <form id="supplierForm" method="POST" action="#">

                <label for="nom"><?php echo htmlspecialchars($translations['name']); ?></label>
                <input type="text" name="nom" placeholder="<?php echo htmlspecialchars($translations['name']); ?>" required>               
                <label for="prenom"><?php echo htmlspecialchars($translations['first name']); ?></label>
                <input type="text" name="prenom" placeholder="<?php echo htmlspecialchars($translations['first name']); ?>" required>
                <label for="ville"><?php echo htmlspecialchars($translations['city']); ?></label>
                <input type="text" name="ville" placeholder="<?php echo htmlspecialchars($translations['city']); ?>" required>
                <label for="adresse"><?php echo htmlspecialchars($translations['address']); ?></label>
                <input type="text" name="adresse" placeholder="<?php echo htmlspecialchars($translations['address']); ?>" required>
                <label for="numero_telephone"><?php echo htmlspecialchars($translations['phone_number']); ?></label>
                <input type="tel" name="numero_telephone" placeholder="<?php echo htmlspecialchars($translations['phone_number']); ?>" required>
                <label for="email"><?php echo htmlspecialchars($translations['email']); ?></label>
                <input type="email" name="email" placeholder="<?php echo htmlspecialchars($translations['email']); ?>" required>
                <label for="id_produit"><?php echo htmlspecialchars($translations['product']); ?></label>
                  <select name="id_produit" id="<?php echo htmlspecialchars($translations['id product']); ?>" >
                   <option value="" disabled selected hidden><?php echo htmlspecialchars($translations['product_to_supply']); ?></option>
                   <?php while ($produit = $produitsResult->fetch_assoc()): ?>
                   <option value="<?php echo $produit['id_produit']; ?>"><?php echo $produit['Libellé']; ?></option>
                   <?php endwhile; ?>
                  </select>
                <label for="quantite"><?php echo htmlspecialchars($translations['quantity']); ?></label>
                <input type="number" name="quantite" placeholder="<?php echo htmlspecialchars($translations['quantity']); ?>" required>
                <label for="prix_unitaire"><?php echo htmlspecialchars($translations['unit_price']); ?></label>
                <input type="number" name="prix_unitaire" placeholder="<?php echo htmlspecialchars($translations['unit_price']); ?>" required>
                <label for="montant_total"><?php echo htmlspecialchars($translations['total_amount']); ?></label>
                <input type="number" name="montant_total" placeholder="<?php echo htmlspecialchars($translations['total_amount']); ?>" required readonly>
                <label for="date_livraison"><?php echo htmlspecialchars($translations['delivery date']); ?></label>
                <input type="date" name="date_livraison" placeholder="<?php echo htmlspecialchars($translations['delivery date']); ?>" required>
                <div class="btn-container">
                    <button type="submit" name="add_supplier" class="btn btn-add-supplier"><?php echo htmlspecialchars($translations['add']); ?></button>
                    <button type="reset" class="btn btn-reset"><?php echo htmlspecialchars($translations['reset']); ?></button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantiteInput = document.querySelector('input[name="quantite"]');
            const prixUnitaireInput = document.querySelector('input[name="prix_unitaire"]');
            const montantTotalInput = document.querySelector('input[name="montant_total"]');

            function updateMontantTotal() {
                const quantite = parseFloat(quantiteInput.value) || 0;
                const prixUnitaire = parseFloat(prixUnitaireInput.value) || 0;
                montantTotalInput.value = (quantite * prixUnitaire).toFixed(2);
            }

            quantiteInput.addEventListener('input', updateMontantTotal);
            prixUnitaireInput.addEventListener('input', updateMontantTotal);
        });
    </script>
</body>
</html>
