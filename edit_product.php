<?php include('config.php'); ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
$fournisseurs = [];
$sql = "SELECT id, nom FROM fournisseur";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fournisseurs[] = $row;
    }
} else {
    echo "Aucun fournisseur trouvé.";
}

$product = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM produit WHERE id_produit = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Aucun produit trouvé.";
        exit();
    }
    $stmt->close();
} else {
    echo "ID de produit non spécifié.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_produit'];
    $libelle = $_POST['libelle'];
    $prix = $_POST['prix'];
    $quantite_stock = $_POST['quantite_stock'];
    $categorie = $_POST['categorie'];
    $fournisseur = $_POST['fournisseur'];
    $etat = $_POST['etat'];
    $sku = $_POST['sku'];
    $image = $product['image']; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image = $targetFile; 
            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        } else {
            echo "Le fichier téléchargé n'est pas une image.";
        }
    }

    $stmt = $conn->prepare("UPDATE produit SET Libellé = ?, Prix = ?, Quantité_Stock = ?, Catégorie = ?, Fournisseur = ?, image = ?, état = ?, SKU = ? WHERE id_produit = ?");
    $stmt->bind_param("sdssssssi", $libelle, $prix, $quantite_stock, $categorie, $fournisseur, $image, $etat, $sku, $id);
    
    if ($stmt->execute()) {
        header("Location: Dashbord.php");
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['edit the Product']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            position: relative; 
        }

        .btn-back {
            position: absolute;
            top: 50px;
            right: 15px;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="file"] {
            display: block;
            margin-bottom: 8px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 8px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        input::placeholder,
        textarea::placeholder {
            color: #888;
        }

        .error {
            color: red;
            margin-bottom: 8px;
            display: none;
        }

        select {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .label-frame {
            display: inline-block;
            padding: 4px 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            background-color: #e7f3ff;
            font-weight: bold;
            margin-bottom: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $translations['edit the Product']; ?></h1>
        <form method="POST" enctype="multipart/form-data">
            <a href="Dashbord.php" class="btn-back"><?php echo $translations['return']; ?></a>

            <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($product['id_produit']); ?>">
          
            <label for="libelle"><?php echo $translations['label']; ?></label>
            <input type="text" name="libelle" placeholder="Libellé" value="<?php echo htmlspecialchars($product['Libellé'] ?? ''); ?>" required>
            
            <label for="prix"><?php echo $translations['price']; ?></label>
            <input type="number" step="0.01" name="prix" placeholder="Prix" value="<?php echo htmlspecialchars($product['Prix'] ?? ''); ?>" required>
            
            <label for="quantite_stock"><?php echo $translations['quantity in Stock']; ?></label>
            <input type="number" name="quantite_stock" placeholder="Quantité en Stock" value="<?php echo htmlspecialchars($product['Quantité_Stock'] ?? ''); ?>" required>
            
            <label for="categorie"><?php echo $translations['category']; ?></label>
            <select id="categorie" name="categorie" required>
              <option value="" disabled selected><?php echo $translations['select_category']; ?></option>
              <option value="Électronique" <?php echo (isset($product['Catégorie']) && $product['Catégorie'] == 'Électronique') ? 'selected' : ''; ?>><?php echo $translations['electronics']; ?></option>
              <option value="Informatique" <?php echo (isset($product['Catégorie']) && $product['Catégorie'] == 'Informatique') ? 'selected' : ''; ?>><?php echo $translations['computing']; ?></option>
             </select>

           <label for="fournisseur"><?php echo $translations['supplier']; ?></label>
            <select id="fournisseur" name="fournisseur" required>
              <option value="" disabled><?php echo $translations['select_supplier']; ?></option>
            <?php foreach ($fournisseurs as $fournisseur): ?>
            <option value="<?php echo $fournisseur['id']; ?>" 
            <?php echo (isset($product['Fournisseur']) && $product['Fournisseur'] == $fournisseur['id']) ? 'selected' : ''; ?>>
            <?php echo $fournisseur['nom']; ?>
            </option>
            <?php endforeach; ?>
          </select>

            <input type="file" id="image" name="image" style="display:none;">
            <label for="image" id="fileLabel" class="label-frame"><?php echo $translations['image']; ?></label>            
            <img src="<?php echo htmlspecialchars($product['image'] ?? ''); ?>" alt="Image du produit" style="width: 80px; height: auto; display: block; margin-bottom: 10px;">
           
            <label for="etat"><?php echo $translations['state']; ?></label>
            <select name="etat" id="etat" required>
                <option value="Disponible" <?php echo (isset($product['état']) && $product['état'] === 'Disponible') ? 'selected' : ''; ?>><?php echo $translations['available']; ?></option>
                <option value="Indisponible" <?php echo (isset($product['état']) && $product['état'] === 'Indisponible') ? 'selected' : ''; ?>><?php echo $translations['navailable']; ?></option>
            </select>
           
            <label for="sku"><?php echo $translations['sku']; ?></label>
            <input type="text" name="sku" placeholder="SKU" value="<?php echo htmlspecialchars($product['SKU'] ?? ''); ?>" required>
            
            <button type="submit"><?php echo $translations['edit']; ?></button>
        </form>
    </div>
</body>
</html>
