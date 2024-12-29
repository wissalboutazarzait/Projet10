<?php include('config.php'); ?>
<?php

$pdo = new PDO('mysql:host=localhost;dbname=gestion_produit', 'root', "");


$sqlFournisseurs = 'SELECT id, nom FROM fournisseur';
$stmtFournisseurs = $pdo->query($sqlFournisseurs);
$fournisseurs = $stmtFournisseurs->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $libelle = $_POST['libelle'];
    $prix = $_POST['prix'];
    $quantite_stock = $_POST['quantite_stock'];
    $categorie = $_POST['categorie'];
    $fournisseur = $_POST['fournisseur'];
    $etat = $_POST['etat'];
    $sku = $_POST['sku'];

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = 'uploads/' . $imageName;

        move_uploaded_file($imageTmpName, $imagePath);
    } else {
        $imagePath = null; 
    }

    $date = date('Y-m-d H:i:s');

    
    $sql = 'INSERT INTO produit (Libellé, Prix, Quantité_Stock, Catégorie, date , Fournisseur, image, état, SKU) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$libelle, $prix, $quantite_stock, $categorie, $date, $fournisseur, $imagePath, $etat, $sku]);

    header('Location:Dashbord.php ');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['add a Product']; ?></title>
    <link rel="stylesheet" href="styles.css">
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
    width: 50%; 
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    position: relative; 
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.back-btn {
    position: absolute;
    top: 60px;
    right: 20px;
    padding: 8px 16px;
    background-color: #3498DB;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 20px; 
}

.back-btn:hover {
    background-color: #2980B9;
}


form {
    display: grid;
    grid-template-columns: 1fr; 
    grid-gap: 15px;
}

label {
    margin-bottom: 5px;
    font-size: 16px;
    color: #333;
}

input[type="text"],
input[type="number"],
input[type="file"],
select {
    width: 100%; 
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

.submit-btn {
    width: auto;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 10px;
}

.submit-btn:hover {
    background-color: #45a049;
}

@media (max-width: 768px) {
    .container {
        width: 90%;
    }
}
.image-frame {
    width: 100%; 
    padding: 20px; 
    border: 2px dashed #ccc; 
    border-radius: 8px; 
    text-align: center;
    box-sizing: border-box;
    background-color: #f9f9f9; 
}

.image-frame input[type="file"] {
    width: 100%; 
    padding: 10px;
    border: none;
    font-size: 16px;
    cursor: pointer;
}
.custom-file-label {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498DB;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.custom-file-label:hover {
    background-color: #2980B9;
}


    </style>
</head>
<body>
<div class="container">
    <h1><?php echo $translations['add a Product']; ?></h1>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="libelle"><?php echo $translations['label']; ?></label>
        <input type="text" id="libelle" name="libelle" required>

        <label for="prix"><?php echo $translations['price']; ?></label>
        <input type="number" id="prix" name="prix" step="0.01" required>

        <label for="quantite_stock"><?php echo $translations['quantity in Stock']; ?></label>
        <input type="number" id="quantite_stock" name="quantite_stock" required>

        <label for="categorie"><?php echo $translations['category']; ?></label>
         <select id="categorie" name="categorie" required>
          <option value="" disabled selected><?php echo $translations['select_category']; ?></option>
          <option value="Électronique"><?php echo $translations['electronics']; ?></option>
          <option value="Informatique"><?php echo $translations['computing']; ?></option>
         </select>

        <label for="fournisseur"><?php echo $translations['supplier']; ?></label>
          <select id="fournisseur" name="fournisseur" >
            <option value="" disabled selected><?php echo $translations['select_supplier']; ?></option>
          <?php foreach ($fournisseurs as $fournisseur): ?>
            <option value="<?php echo $fournisseur['id']; ?>"><?php echo $fournisseur['nom']; ?></option>
          <?php endforeach; ?>
          </select>

          <label for="image"><?php echo $translations['image']; ?></label>
           <div class="image-frame">
            <label for="customFileInput" class="custom-file-label">
             <span id="file-name"><?php echo $translations['choose a file']; ?></span>
            </label>
           <input type="file" id="customFileInput" name="image" style="display:none;" required>
           </div>

       <label for="etat"><?php echo $translations['state']; ?></label>
        <select id="etat" name="etat" required>
            <option value="Disponible"><?php echo $translations['available']; ?></option>
            <option value="Indisponible"><?php echo $translations['navailable']; ?></option>
        </select>

        <label for="sku"><?php echo $translations['sku']; ?></label>
        <input type="text" id="sku" name="sku" required>

        <button type="submit" class="submit-btn"><?php echo $translations['add']; ?></button>
    </form>
    <button class="back-btn" onclick="window.location.href='Dashbord.php'"><?php echo $translations['return']; ?></button>
</div>

    <script>
        document.getElementById('dashboard-btn').addEventListener('click', function() {
    window.location.href = "Dashbord.php"; 
});

    </script>
        <script>

    document.getElementById('customFileInput').addEventListener('change', function() {
    var fileName = this.files.length ? this.files[0].name : '<?php echo $translations['no_file_selected']; ?>'; 
    document.getElementById('file-name').textContent = fileName;
});
</script>

</body>
</html>


