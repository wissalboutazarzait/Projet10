<?php
include('config.php');

$conn = new mysqli("localhost", "root", "", "gestion_produit");

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

$searchId = isset($_GET['searchId']) ? $_GET['searchId'] : '';

$sql = "SELECT DISTINCT c.id_commande, cl.id_client, p.id_produit, c.date_commande, c.etat, c.facture, c.mode_paiement, c.date_livraison 
        FROM commande c
        JOIN client cl ON c.id_client = cl.id_client
        JOIN produit p ON c.id_produit = p.id_produit";

if ($searchId) {
    $sql .= " WHERE c.id_commande = ?";
}

$stmt = $conn->prepare($sql);

if ($searchId) {
    $stmt->bind_param("i", $searchId);
}

$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin-left: 10px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Recherche de Commande par ID</h1>

    <form method="GET" action="search_commande.php">
        <input type="text" name="searchId" placeholder="Entrer l'ID de la commande" value="<?php echo htmlspecialchars($searchId); ?>">
        <button type="submit">Rechercher</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>ID Client</th>
                    <th>ID Produit</th>
                    <th>Date Commande</th>
                    <th>État</th>
                    <th>Facture</th>
                    <th>Mode de Paiement</th>
                    <th>Date Livraison</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_client']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_produit']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_commande']); ?></td>
                        <td><?php echo htmlspecialchars($row['etat']); ?></td>
                        <td><?php echo htmlspecialchars($row['facture']); ?></td>
                        <td><?php echo htmlspecialchars($row['mode_paiement']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_livraison']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune commande trouvée pour cet ID.</p>
    <?php endif; ?>
</div>

</body>
</html>
