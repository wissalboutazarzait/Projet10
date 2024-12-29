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

$nbProduits = 0;
$nbFournisseurs = 0;
$nbClients = 0;
$nbCommandes = 0;

$sql = "SELECT COUNT(*) AS count FROM produit";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nbProduits = $row['count'];
}

$sql = "SELECT COUNT(*) AS count FROM fournisseur";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nbFournisseurs = $row['count'];
}

$sql = "SELECT COUNT(*) AS count FROM client";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nbClients = $row['count'];
}

$sql = "SELECT COUNT(*) AS count FROM commande";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nbCommandes = $row['count'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistiques</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color:  #2980B9;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
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
            font-size: 18px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #2980B9;
            transition: 0.3s;
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
            color: black;
            border-radius: 8px;
        }

        .cards {
    display: flex;
    justify-content: space-between; 
    flex-wrap: nowrap; 
}

.card {
    flex: 1 1 22%; 
    margin: 10px; 
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    max-width: 22%; 
    position: relative; 
    overflow: hidden; 
}

.card:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 2px;
    height: 100%;
    background-color: #BDC3C7; 
    z-index: 1;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
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

.sidebar ul li a {
    display: flex;
    align-items: center; 
}
.sidebar ul li a i {
    margin-right: 10px; 
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
    <div class="main-content">
        <header>
        <h1><?php echo  $translations['statistics']; ?></h1>
        </header>
        <div class="cards">
            <div class="card">
            <h3><?php echo  $translations['products']; ?></h3>
            <p><?php echo $nbProduits; ?></p>
            </div>
            <div class="card">
            <h3><?php echo  $translations['suppliers']; ?></h3>
            <p><?php echo $nbFournisseurs; ?></p>
            </div>
            <div class="card">
            <h3><?php echo  $translations['customers']; ?></h3>
            <p><?php echo $nbClients; ?></p>
            </div>
            <div class="card">
            <h3><?php echo  $translations['orders']; ?></h3>
            <p><?php echo $nbCommandes; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
