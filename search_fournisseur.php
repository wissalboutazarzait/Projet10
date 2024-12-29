<?php include('config.php'); ?>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'gestion_produit');

if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$search = $mysqli->real_escape_string($_GET['search']);
$query = "SELECT * FROM fournisseur WHERE nom LIKE '$search%'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($fournisseur = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$fournisseur['id']}</td>
                <td>{$fournisseur['nom']}</td>
                <td>{$fournisseur['prenom']}</td>
                <td>{$fournisseur['ville']}</td>
                <td>{$fournisseur['adresse']}</td>
                <td>{$fournisseur['numero_telephone']}</td>
                <td>{$fournisseur['email']}</td>
                <td>{$fournisseur['id_produit']}</td>
                <td>{$fournisseur['quantite']}</td>
                <td>{$fournisseur['prix_unitaire']}</td>
                <td>{$fournisseur['montant_total']}</td>
                <td>{$fournisseur['date_livraison']}</td>";
        ?>
        <td class='actions'>
            <a href='edit_fournisseur.php?id=<?php echo $fournisseur['id']; ?>' class='btn btn-edit'>
                <?php echo $translations['edit']; ?>
            </a>
            <a href='delete_fournisseur.php?id=<?php echo $fournisseur['id']; ?>' class='btn btn-delete' 
               onclick="return confirm('<?php echo $translations['delete_confirmation']; ?>');">
               <?php echo $translations['delete']; ?>
            </a>
        </td>
        <?php
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>Aucun fournisseur trouvé</td></tr>";
}

$mysqli->close();
?>
