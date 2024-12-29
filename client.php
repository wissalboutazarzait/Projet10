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


$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : ''; // Assurez-vous d'échapper les entrées pour éviter les injections SQL
$sql = "
    SELECT 
        c.nom_client, c.prenom, c.email, c.ville, c.adresse, c.numero_telephone,
        IFNULL(SUM(cmd.facture), 0) AS montant_total
    FROM 
        client c
    LEFT JOIN 
        commande cmd ON c.id_client = cmd.id_client
    WHERE
        c.nom_client LIKE '%$search%' OR
        c.prenom LIKE '%$search%'
    GROUP BY 
        c.nom_client, c.prenom, c.email, c.ville, c.adresse, c.numero_telephone
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php echo $translations['title']; ?></title>
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

table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 1.2em;
    min-width: 400px;
    border-radius: 5px 5px 0 0;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

table thead tr {
    background-color: #4CAF50;
    color: black;
    text-align: left;
    font-weight: bold;
}

table th {
    padding: 12px 15px;

    background-color: #f2f2f2;
    color: #333;
}
table td{
    padding: 12px 15px;
    background-color: white;


}

table tbody tr {
    border-bottom: 1px solid #dddddd;
}

table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}

button {
    background-color: #009879;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #007961;
}

@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    table thead tr {
        display: none;
    }

    table tbody tr {
        margin-bottom: 15px;
    }

    table tbody tr td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    table tbody tr td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
    }
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
    margin-right: 20px;
}

button {
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: #27AE60;
  
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #007961;
}

.edit-btn {
    background-color: #1e90ff;
}

.edit-btn:hover {
    background-color: #1c86ee;
}

.delete-btn {
    background-color: #dc143c;
}

.delete-btn:hover {
    background-color: #c71585;
}

#addClientForm {
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    max-width: 400px;
    margin: 20px auto;
    
}

#addClientForm h2 {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

#addClientForm input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #cccccc;
    border-radius: 5px;
}

#addClientForm button[type="submit"] {
    width: 100%;
    background-color: #009879;
    color: white;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    
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
    <h1><?php echo $translations['customers list']; ?></h1>
    <a href="add_client.php">
    <button id="addClientBtn" onclick="showAddClientForm()"><?php echo $translations['add_customer']; ?></button>
    </a>
    <form method="GET" action="" class="search-form">
        <input type="text" name="search" placeholder="<?php echo $translations['search_customer']; ?>" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit"><?php echo $translations['search_customer']; ?></button>
    </form>     
    <table>
        <thead>
            <tr>
            <th><?php echo $translations['name']; ?></th>
                <th><?php echo $translations['first name']; ?></th>
                <th><?php echo $translations['email']; ?></th>
                <th><?php echo $translations['city']; ?></th>
                <th><?php echo $translations['address']; ?></th>
                <th><?php echo $translations['phone_number']; ?></th>
                <th><?php echo $translations['total_amount']; ?></th>
                <th><?php echo $translations['actions']; ?></th>
        </thead>
        <tbody>
            <?php
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nom_client']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ville']) . "</td>";
            echo "<td>" . htmlspecialchars($row['adresse']) . "</td>";
            echo "<td>" . htmlspecialchars($row['numero_telephone']) . "</td>";
            echo "<td>" . number_format($row['montant_total'], 2) . " dh</td>";
            echo "<td>";
            echo "<a href='edit_client.php?nom_client=" . urlencode($row['nom_client']) . "'>";
    echo "<button class='edit-btn'>" . htmlspecialchars($translations['edit']) . "</button>";
    echo "</a>";
    echo "<button class='delete-btn' onclick='return deleteClient(\"" . htmlspecialchars($row['nom_client']) . "\", \"" . htmlspecialchars($row['prenom']) . "\", \"" . $translations['confirm_delete'] . "\")'>" . htmlspecialchars($translations['delete']) . "</button>";
    echo "</td>";
    echo "</tr>";
        }
        
        ?>
        </tbody>
    </table>
</div>

    <script>
function searchClient() {
    const input = document.querySelector('input[name="search"]');
    const filter = input.value.toUpperCase();
    const table = document.querySelector('table');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const tdName = tr[i].getElementsByTagName('td')[0];
        const tdPrenom = tr[i].getElementsByTagName('td')[1];

        if (tdName && tdPrenom) {
            const txtValueName = tdName.textContent || tdName.innerText;
            const txtValuePrenom = tdPrenom.textContent || tdPrenom.innerText;

            if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValuePrenom.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

</script>
<script>
function showAddClientForm() {
    document.getElementById('addClientForm').style.display = 'block';
}

function hideAddClientForm() {
    document.getElementById('addClientForm').style.display = 'none';
}

function editClient(nom_client) {
    window.location.href = "edit_client.php?nom_client=" + encodeURIComponent(nom_client);
}
function deleteClient(nom, prenom, confirmMessage) {
    if (confirm(confirmMessage)) {
        const xhr = new XMLHttpRequest();
        const url = "delete_client.php?nom=" + encodeURIComponent(nom) + "&prenom=" + encodeURIComponent(prenom);
        
        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log(response);  
                        if (response.success) {
                            alert(response.message);
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    } catch (e) {
                        console.error("Erreur lors du parsing de la réponse JSON:", e);
                        alert("Erreur lors du traitement de la réponse du serveur.");
                    }
                } else {
                    alert("Erreur HTTP: " + xhr.status);
                }
            }
        };
        xhr.send();
    }
}

   
</script>
</body>
</html>

