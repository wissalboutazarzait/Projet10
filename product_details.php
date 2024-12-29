<?php include('config.php'); ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

$sql = "SELECT * FROM produit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* styles.css */
body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
}

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
    margin-left: 250px;
    width: calc(100% - 250px);
}

.product-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px;
    width: 300px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.product-image {
    width: 100%;
    height: auto;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.product-info {
    padding: 15px;
}

.product-id {
    color: #2980B9;
    font-size: 18px;
    margin: 0;
}

.product-title {
    color: #333;
    font-size: 22px;
    margin: 10px 0;
}

.product-description {
    color: #666;
    font-size: 16px;
    margin: 0 0 20px;
}

.view-details-btn {
    background-color: #27AE60;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    padding: 10px 20px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.view-details-btn:hover {
    background-color: #2ECC71;
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
.modal {
    display: none; 
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 60px;
    border: 1px solid #888;
    width: 50%; 
    max-width: 800px; 
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
textarea {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    font-size: 16px;
    resize: vertical; 
}
button {
    background-color: #27AE60;
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    padding: 10px 20px;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
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
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<img src="' . $row["image"] . '" alt="' . $row["Libellé"] . '" class="product-image">';
                echo '<div class="product-info">';
                echo '<a href="Dashbord.php?id=' . $row["id_produit"] . '" class="product-id">ID: ' . $row["id_produit"] . '</a>';
                echo '<h3 class="product-title">' . $row["Libellé"] . '</h3>';
                echo '<button class="view-details-btn" onclick="viewDetails(' . $row["id_produit"] . ')">' . $translations['view_details'] . '</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>' . $translations['no_product_found'] . '</p>';
        }
        ?>
    </div>
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2><?php echo  $translations['description']; ?></h2>
        <form id="descriptionForm">
            <textarea id="modalProductDescription" rows="10" style="width: 100%; border-radius: 4px; border: 1px solid #ccc;"></textarea>
            <br>
            <button type="button" id="saveButton" style="margin-top: 10px; padding: 10px 20px; border: none; border-radius: 4px; background-color: #27AE60; color: white; cursor: pointer;"><?php echo  $translations['save']; ?></button>
            <button type="button" id="deleteButton" style="margin-top: 10px; padding: 10px 20px; border: none; border-radius: 4px; background-color: #27AE60; color: white; cursor: pointer;"><?php echo  $translations['delete']; ?></button>
        </form>
    </div>
</div>
<script>
var modal = document.getElementById("productModal");
var modalDescription = document.getElementById("modalProductDescription");
var saveButton = document.getElementById("saveButton");
var deleteButton = document.getElementById("deleteButton"); 

var span = document.getElementsByClassName("close")[0];

var currentProductId;

function viewDetails(id) {
    currentProductId = id; 
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_product_details.php?id=" + id, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var product = JSON.parse(xhr.responseText);
            modalDescription.value = product.Description; 

            modal.style.display = "block";
        }
    };
    xhr.send();
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

saveButton.onclick = function() {
    var updatedDescription = modalDescription.value;
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_product_description.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("<?php echo $translations['description updated']; ?>");
            modal.style.display = "none";  
        }
    };
    xhr.send("id=" + currentProductId + "&description=" + encodeURIComponent(updatedDescription));
}

deleteButton.onclick = function() {
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_product_description.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("<?php echo $translations['description deleted']; ?>");
            modalDescription.value = ""; 
            modal.style.display = "none";  
        }
    };
    xhr.send("id=" + currentProductId);
}

</script>
   </body>
</html>
