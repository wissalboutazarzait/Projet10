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

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

if (!empty($search)) {
    $sql = "SELECT * FROM produit WHERE Libellé LIKE '%$search%' OR fournisseur LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM produit";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
            padding-top: 20px;
            margin-left: 270px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: black;
            margin: 0;
            margin-right: 20px; 
        }

        .add-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #27AE60;
            color: white;
            font-size: 16px;
        }

        .add-btn:hover {
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 18px;
            text-align: left;
        }

        th {
            background-color: #2980B9;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-buttons button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            margin-bottom: 10px;
        }

        .edit-btn {
            background-color: #2980B9;
        }

        .delete-btn {
            background-color: #E74C3C;
        }

        .action-buttons button:hover {
            opacity: 0.9;
        }
        .action-buttons button:last-child {
    margin-right: 0; }
       
        .header {
            display: flex;
            justify-content: space-between; 
            align-items: center;
            margin-bottom: 20px;
        }

        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 16px;
            text-align: center;
        }

        .back-btn {
            background-color: #27AE60;
        }
        .add-btn, .back-btn {
          padding: 10px 20px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          color: white;
          font-size: 16px;
          text-align: center;
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
    <div class="header">
        <h1><?php echo $translations['product list']; ?></h1>
        <button class="add-btn"><?php echo $translations['add_product']; ?></button>
        <form method="GET" action="" class="search-form">
            <input type="text" id="searchProductInput" name="search" placeholder="<?php echo $translations['search_placeholder']; ?>" />
            <button type="submit"><?php echo isset($translations['search']) ? $translations['search'] : 'Search'; ?></button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th><?php echo $translations['label']; ?></th>
                <th><?php echo $translations['price']; ?></th>
                <th><?php echo $translations['stock_quantity']; ?></th>
                <th><?php echo $translations['category']; ?></th>
                <th><?php echo $translations['date']; ?></th>
                <th><?php echo $translations['supplier']; ?></th>
                <th><?php echo $translations['image']; ?></th>
                <th><?php echo $translations['product_status']; ?></th>
                <th><?php echo $translations['sku']; ?></th>
                <th><?php echo isset($translations['actions']) ? $translations['actions'] : 'Actions'; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_produit"] . "</td>";
                    echo "<td>" . $row["Libellé"] . "</td>";
                    echo "<td>" . $row["Prix"] . " dh</td>";
                    echo "<td>" . $row["Quantité_Stock"] . "</td>";
                    echo "<td>" . $row["Catégorie"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                    echo "<td>" . $row["Fournisseur"] . "</td>";
                    echo "<td><img src='" . $row["image"] . "' alt='" . $row["Libellé"] . "' width='100'></td>";
                    echo "<td>" . $row["état"] . "</td>";
                    echo "<td>" . $row["SKU"] . "</td>";
                    echo "<td class='action-buttons'>";
        
                    echo "<button class='edit-btn' onclick=\"window.location.href='edit_product.php?id_produit=" . $row["id_produit"] . "'\">";
                    echo $translations['edit']; 
                    echo "</button>";
                    
                    echo "<button class='delete-btn' onclick=\"if (confirm('{$translations['delete_product']}')) { deleteProduct(" . $row["id_produit"] . "); }\">";
                    echo $translations['delete']; 
                    echo "</button>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>" . $translations['no_product_found'] . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
    <script>
        document.querySelectorAll('.add-btn').forEach(button => {
            button.addEventListener('click', function() {
                window.location.href = "add_product.php";
            });
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.closest('tr').querySelector('td').textContent;
                window.location.href = `edit_product.php?id=${productId}`;
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                    window.location.href = `delete_product.php?id=${productId}`;
                
            });
        });
    </script>
    <script>
      function deleteProduct(productId) {
        window.location.href = "delete_product.php?id=" + productId;
}
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('searchProductInput');
            input.addEventListener('input', function() {
                searchProduct();
            });

            function searchProduct() {
                const query = input.value;
                if (query.length > 0) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'search_produit.php?search=' + encodeURIComponent(query), true);
                    xhr.onload = function() {
                        if (this.status === 200) {
                            document.querySelector('tbody').innerHTML = this.responseText;
                        } else {
                            console.error('Request failed. Status:', this.status);
                        }
                    };
                    xhr.onerror = function() {
                        console.error('Request error');
                    };
                    xhr.send();
                } else {
                    document.querySelector('tbody').innerHTML = '';
                }
            }
        });
    </script>
</body>
</html>
