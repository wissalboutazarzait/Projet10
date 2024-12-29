<?php
include('config.php'); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_produit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

$lang = isset($_GET['lang']) && $_GET['lang'] === 'en' ? 'en' : 'fr'; 

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

if (!empty($search)) {
    $sql = "SELECT * FROM produit WHERE Libellé LIKE '%$search%' OR fournisseur LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM produit";
}

$result = $conn->query($sql);

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
    echo "<tr><td colspan='11'>{$translations['no_product_found']}</td></tr>";
}

$conn->close();
?>
