<?php include('config.php'); ?>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'gestion_produit');

if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query_produit = "SELECT id_produit, Libellé FROM produit";
    $result_produit = $mysqli->query($query_produit);

    $query = "SELECT * FROM fournisseur WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $fournisseur = $result->fetch_assoc();
    } else {
        echo 'Fournisseur non trouvé.';
        exit();
    }
} else {
    echo 'ID de fournisseur non spécifié.';
    exit();
}

if (isset($_POST['update_supplier'])) {
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

    $query = "UPDATE fournisseur SET nom = ?, prenom = ?, ville = ?, adresse = ?, numero_telephone = ?, email = ?, id_produit = ?, quantite = ?, prix_unitaire = ?, montant_total = ?, date_livraison = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssssssddsi", $nom, $prenom, $ville, $adresse, $numero_telephone, $email, $id_produit, $quantite, $prix_unitaire, $montant_total, $date_livraison, $id);
    
    if ($stmt->execute()) {
        header('Location: fournisseur.php');
        exit();
    } else {
        echo 'Erreur : ' . $mysqli->error;
    }
}
$produitsQuery = "SELECT id_produit,Libellé FROM produit";
$produitsResult = $mysqli->query($produitsQuery);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['edit a supplier']; ?><</title>
    <link rel="stylesheet" href="edit_fournisseur.css">
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form input[type="text"],
form input[type="tel"],
form input[type="email"],
form input[type="number"],
form input[type="date"],
select {

    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

form input[type="number"][readonly] {
    background-color: #e9ecef;
    cursor: not-allowed;
}

.btn-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: #ffffff;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-reset {
    background-color: #dc3545;
    margin: 0 auto;
}

.btn-update-supplier {
    background-color: #28a745;
}

.btn-return {
    background-color: #007bff; 
}

.btn:hover {
    opacity: 0.8;
}


    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $translations['edit a supplier']; ?></h1>
        <form id="supplierForm" method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($fournisseur['id']); ?>">
            <label for="nom"><?php echo htmlspecialchars($translations['name']); ?></label>
            <input type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($fournisseur['nom']); ?>" required>
            <label for="prenom"><?php echo htmlspecialchars($translations['first name']); ?></label>
            <input type="text" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars($fournisseur['prenom']); ?>" required>
            <label for="ville"><?php echo htmlspecialchars($translations['city']); ?></label>

            <input type="text" name="ville" placeholder="Ville" value="<?php echo htmlspecialchars($fournisseur['ville']); ?>" required>
            <label for="adresse"><?php echo htmlspecialchars($translations['address']); ?></label>

            <input type="text" name="adresse" placeholder="Adresse" value="<?php echo htmlspecialchars($fournisseur['adresse']); ?>" required>
            <label for="numero_telephone"><?php echo htmlspecialchars($translations['phone_number']); ?></label>

            <input type="tel" name="numero_telephone" placeholder="Numéro de Téléphone" value="<?php echo htmlspecialchars($fournisseur['numero_telephone']); ?>" required>
            <label for="email"><?php echo htmlspecialchars($translations['email']); ?></label>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($fournisseur['email']); ?>" required>
            
            <label for="id_produit"><?php echo htmlspecialchars($translations['product']); ?></label>
            <select name="id_produit" id="id_produit" required>
            <option value="" disabled selected hidden><?php echo htmlspecialchars($translations['product_to_supply']); ?></option>
             <?php while ($produit = $produitsResult->fetch_assoc()): ?>
            <option value="<?php echo $produit['id_produit']; ?>" 
             <?php if ($produit['id_produit'] == $fournisseur['id_produit']) echo 'selected'; ?>>
             <?php echo $produit['Libellé']; ?>
            </option>
            <?php endwhile; ?>
           </select>

            <label for="quantite"><?php echo htmlspecialchars($translations['quantity']); ?></label>

            <input type="number" name="quantite" placeholder="Quantité" value="<?php echo htmlspecialchars($fournisseur['quantite']); ?>" required>
            <label for="prix_unitaire"><?php echo htmlspecialchars($translations['unit_price']); ?></label>
            <input type="number" name="prix_unitaire" placeholder="Prix Unitaire (dh)" step="0.01" value="<?php echo htmlspecialchars($fournisseur['prix_unitaire']); ?>" required>
            <label for="montant_total"><?php echo htmlspecialchars($translations['total_amount']); ?></label>

            <input type="number" name="montant_total" placeholder="Montant Total (dh)" step="0.01" value="<?php echo htmlspecialchars($fournisseur['montant_total']); ?>" required readonly>
            <label for="date_livraison"><?php echo htmlspecialchars($translations['delivery date']); ?></label>
            <input type="date" name="date_livraison" placeholder="Date Livraison" value="<?php echo htmlspecialchars($fournisseur['date_livraison']); ?>" required>
            
            <div class="btn-container">
                <button type="submit" name="update_supplier" class="btn btn-update-supplier"><?php echo $translations['edit']; ?></button>
                <button type="reset" class="btn btn-reset"><?php echo $translations['reset']; ?></button>
                <button type="button" class="btn btn-return" onclick="window.location.href='fournisseur.php';"><?php echo $translations['return']; ?></button>

            </div>
        </form>
    </div>
    <script src="edit_fournisseur.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const quantiteInput = document.querySelector('input[name="quantite"]');
    const prixUnitaireInput = document.querySelector('input[name="prix_unitaire"]');
    const montantTotalInput = document.querySelector('input[name="montant_total"]');

    function calculerMontantTotal() {
        const quantite = parseFloat(quantiteInput.value);
        const prixUnitaire = parseFloat(prixUnitaireInput.value);

        if (!isNaN(quantite) && !isNaN(prixUnitaire)) {
            montantTotalInput.value = (quantite * prixUnitaire).toFixed(2);
        } else {
            montantTotalInput.value = '';
        }
    }

    quantiteInput.addEventListener('input', calculerMontantTotal);
    prixUnitaireInput.addEventListener('input', calculerMontantTotal);
});

    </script>
</body>
</html>
