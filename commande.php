<?php include('config.php'); ?>
<?php
$conn = new mysqli("localhost", "root", "", "gestion_produit");

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT c.id_commande, cl.id_client, p.id_produit, c.date_commande, c.etat, c.facture, c.mode_paiement, c.date_livraison 
        FROM commande c
        JOIN client cl ON c.id_client = cl.id_client
        JOIN produit p ON c.id_produit = p.id_produit";

$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php echo htmlspecialchars($translations['title']); ?></title>
    <style>
        body { 
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2980B9;
            color: white;
        }

        .add-button {
            margin: 20px 0;
        }

        .add-button a {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .actions a {
    margin-right: 10px;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    font-weight: bold;
    color: white;
    border: 2px solid transparent;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-edit {
    background-color: #3498DB; 
    border-color: #2980B9; 
}

.btn-edit:hover {
    background-color: #2980B9; 
    border-color: #3498DB; 
}

.btn-delete {
    background-color: #E74C3C; 
    border-color: #C0392B; 
}

.btn-delete:hover {
    background-color: #C0392B; 
    border-color: #E74C3C; 
}

        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color:  #2980B9;
            position: fixed;
            height: 100%;
            padding-top: 40px;
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

        .search-bar {
            margin-left: auto;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .card {
            flex: 1 1 calc(33.33% - 40px);
            margin: 10px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            max-width: 450px;
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
        }

        button:hover {
            background-color: #2ECC71;
            transition: 0.3s;
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
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Technologica</h2>
        <ul>
            <li><a href="statistiques.php"><i class="fas fa-chart-line"></i> <?php echo htmlspecialchars($translations['dashboard_statistics']); ?></a></li>
            <li><a href="product_details.php"><i class="fas fa-box"></i> <?php echo htmlspecialchars($translations['products']); ?></a></li>
            <li><a href="Dashbord.php"><i class="fas fa-tachometer-alt"></i> <?php echo htmlspecialchars($translations['dashboard']); ?></a></li>
            <li><a href="fournisseur.php"><i class="fas fa-truck"></i> <?php echo htmlspecialchars($translations['suppliers']); ?></a></li>
            <li><a href="client.php"><i class="fas fa-cogs"></i> <?php echo htmlspecialchars($translations['customers']); ?></a></li>
            <li><a href="commande.php"><i class="fas fa-cogs"></i> <?php echo htmlspecialchars($translations['orders']); ?></a></li>
            <li><a href="parametre.php"><i class="fas fa-cogs"></i> <?php echo htmlspecialchars($translations['settings']); ?></a></li>
        </ul>
    </div>

    <div class="content">
        <header>
            <h1><?php echo htmlspecialchars($translations['order list']); ?></h1>
            <div class="search-bar">
            <input type="text" name="searchId" id="searchInput" placeholder="<?php echo htmlspecialchars($translations['search for an order']); ?>" >
            <button type="submit"><?php echo htmlspecialchars($translations['research']); ?></button>
            </div>
        </header>

        <div class="add-button">
            <a href="add_commande.php"><?php echo htmlspecialchars($translations['add an Order']); ?></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th><?php echo htmlspecialchars($translations['id_commande']); ?></th>
                    <th><?php echo htmlspecialchars($translations['customer_id']); ?></th>
                    <th><?php echo htmlspecialchars($translations['id_produit']); ?></th>
                    <th><?php echo htmlspecialchars($translations['date_commande']); ?></th>
                    <th><?php echo htmlspecialchars($translations['etat']); ?></th>
                    <th><?php echo htmlspecialchars($translations['facture']); ?></th>
                    <th><?php echo htmlspecialchars($translations['mode_paiement']); ?></th>
                    <th><?php echo htmlspecialchars($translations['delivery date']); ?></th>
                    <th><?php echo htmlspecialchars($translations['actions']); ?></th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if ($result->num_rows > 0) : ?>
                    <?php while($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_commande']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_client']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_produit']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_commande']); ?></td>
                            <td><?php echo htmlspecialchars($row['etat']); ?></td>
                            <td><?php echo htmlspecialchars($row['facture']); ?></td>
                            <td><?php echo htmlspecialchars($row['mode_paiement']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_livraison']); ?></td>
                            <td class="actions">
                            <a href="edit_commande.php?id=<?php echo htmlspecialchars($row['id_commande']); ?>" class="btn-edit"><?php echo htmlspecialchars($translations['edit']); ?></a>
                            <a href="delete_commande.php?id=<?php echo htmlspecialchars($row['id_commande']); ?>" class="btn-delete"><?php echo htmlspecialchars($translations['delete']); ?></a>
                         </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9"><?php echo htmlspecialchars($translations['no_order_found']); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');
            if (!confirmation) {
                event.preventDefault();
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();
        
        for (let i = 0; i < rows.length; i++) {
            const idCommandeCell = rows[i].getElementsByTagName('td')[0]; // Première colonne (id_commande)
            if (idCommandeCell) {
                const idCommandeText = idCommandeCell.textContent || idCommandeCell.innerText;

                if (idCommandeText.toLowerCase().indexOf(searchTerm) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });
});
</script>
</body>
</html>
