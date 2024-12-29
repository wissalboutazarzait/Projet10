<?php include('config.php'); ?>
<?php
$mysqli = new mysqli('localhost', 'root', '', 'gestion_produit');

if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$query = "SELECT * FROM fournisseur";
$result = $mysqli->query($query);

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title><?php echo $translations['suppliers_list']; ?></title>
    <style>
body {
    margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
}

.container {
    width: 80%;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow-x: auto;
    padding-top: 20px;
    margin-left: 270px;

}

h1 {
    text-align: center;
    margin: 20px 0;
    font-size: 2.5em;
    color: #333;
}

.table-container {
    margin-top: 20px;
    overflow-x: auto;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th,
table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f2f2f2;
    color: #333;
}

.actions {
    display: flex;
    gap: 10px;
}

.btn-edit {
    background-color: #008CBA;
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 4px;
}

.btn-delete {
    background-color: #f44336;
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 4px;
}

.btn-add {
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 4px;
    display: inline-block;
}
.sidebar {
            width: 250px;
            position: fixed;
            height: 100%;
            background-color: #2C3E50;
            padding-top: 20px;
        }

        .sidebar h2 {
            color: #2980B9;
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;

        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            text-align: left;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }

        .sidebar ul li a:hover {
            background-color: #2980B9;
            border-radius: 4px;
        }
        .main-content {
    margin-left: 250px;
    padding: 20px;
}

header {
    display: flex;
    justify-content: space-between;       
    align-items: center;
    padding: 20px;
    background-color: #2980B9;
    color: white;
    border-radius: 8px;

}

.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.card {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.card h3 {
    margin: 0;
    font-size: 20px;
    color: #2980B9;
}

.card p {
    font-size: 30px;
    margin: 10px 0 0;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #27AE60;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;

}

button:hover {
    background-color: #2ECC71;
    transition: 0.3s;
}
.card {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.sidebar ul li a {
    display: flex;
    align-items: center; 
}
.sidebar ul li a i {
    margin-right: 10px; 
}
.sidebar ul li a {
    border: 2px solid #34495E; 
    border-radius: 5px; 
    padding: 10px; 
    transition: border-color 0.3s, background-color 0.3s; 
  
    
}
      .search-form {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-end;

}

.search-form input[type="text"] {
    padding: 10px;
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-right: 10px;
    font-size: 16px;
}

.search-form button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #2980B9;
    color: white;
    cursor: pointer;
    font-size: 16px;
}

.search-form button:hover {
    background-color: #2ECC71;
}
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Technologica</h2>
        <ul>
    <li><a href="statistiques.php"><i class="fas fa-chart-line"></i> <?php echo $translations['dashboard_statistics']; ?></a></li>
    <li><a href="product_details.php"><i class="fas fa-box"></i> <?php echo $translations['products']; ?></a></li>
    <li><a href="Dashbord.php"><i class="fas fa-tachometer-alt"></i> <?php echo $translations['dashboard']; ?></a></li>
    <li><a href="fournisseur.php"><i class="fas fa-truck"></i> <?php echo $translations['suppliers']; ?></a></li>
    <li><a href="client.php"><i class="fas fa-cogs"></i> <?php echo $translations['customers']; ?></a></li>
    <li><a href="commande.php"><i class="fas fa-cogs"></i> <?php echo $translations['orders']; ?></a></li>
    <li><a href="parametre.php"><i class="fas fa-cogs"></i> <?php echo $translations['settings']; ?></a></li>
</ul>
    </div>
    <div class="container">
    <h1><?php echo $translations['suppliers_list']; ?></h1>
    <a href="add_fournisseur.php" class="btn btn-add"><?php echo $translations['add supplier']; ?></a>
    <div>
        <form method="GET" action="" class="search-form">
            <input type="text" name="search" placeholder="<?php echo $translations['search_supplier']; ?>" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit"><?php echo $translations['search_supplier']; ?></button>
        </form>
    </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                    <th><?php echo $translations['id']; ?></th>
                    <th><?php echo $translations['name']; ?></th>
                    <th><?php echo $translations['first name']; ?></th>
                    <th><?php echo $translations['city']; ?></th>
                    <th><?php echo $translations['address']; ?></th>
                    <th><?php echo $translations['phone_number']; ?></th>
                    <th><?php echo $translations['email']; ?></th>
                    <th><?php echo $translations['product_to_supply']; ?></th>
                    <th><?php echo $translations['quantity']; ?></th>
                    <th><?php echo $translations['unit_price']; ?></th>
                    <th><?php echo $translations['total_amount']; ?></th>
                    <th><?php echo $translations['delivery date']; ?></th>
                    <th><?php echo $translations['actions']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fournisseur = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fournisseur['id']; ?></td>
                            <td><?php echo $fournisseur['nom']; ?></td>
                            <td><?php echo $fournisseur['prenom']; ?></td>
                            <td><?php echo $fournisseur['ville']; ?></td>
                            <td><?php echo $fournisseur['adresse']; ?></td>
                            <td><?php echo $fournisseur['numero_telephone']; ?></td>
                            <td><?php echo $fournisseur['email']; ?></td>
                            <td><?php echo $fournisseur['id_produit']; ?></td>
                            <td><?php echo $fournisseur['quantite']; ?></td>
                            <td><?php echo $fournisseur['prix_unitaire']; ?></td>
                            <td><?php echo $fournisseur['montant_total']; ?></td>
                            <td><?php echo $fournisseur['date_livraison']; ?></td>
                            <td class="actions">
                            <a href="edit_fournisseur.php?id=<?php echo $fournisseur['id']; ?>" class="btn btn-edit"><?php echo $translations['edit']; ?></a>
                            <a href="delete_fournisseur.php?id=<?php echo $fournisseur['id']; ?>" class="btn btn-delete" onclick="return confirm('<?php echo $translations['delete_confirmation']; ?>');"><?php echo $translations['delete']; ?></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>document.querySelector('input[name="search"]').addEventListener('keyup', function() {
    var searchQuery = this.value;

    if (searchQuery.length > 0) {
        fetch('search_fournisseur.php?search=' + searchQuery)
            .then(response => response.text())
            .then(data => {
                document.querySelector('tbody').innerHTML = data;
            });
    }
});
</script>
</body>
</html>
