<?php

function getDbConnection() {
    $conn = new mysqli("localhost", "root", "", "gestion_produit");
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }
    return $conn;
}

if (isset($_GET['id'])) {
    $id_commande = intval($_GET['id']); 
    $conn = getDbConnection();

    $conn->begin_transaction(); 

    try {
        
        $sql = "DELETE FROM commande WHERE id_commande = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_commande);

        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la suppression de la commande : " . $stmt->error);
        }

        if ($stmt->affected_rows > 0) {
            $conn->query("SET @count = 0;");
            $conn->query("UPDATE commande SET id_commande = @count := @count + 1 ORDER BY id_commande;");
            $conn->query("ALTER TABLE commande AUTO_INCREMENT = 1;");
            
            $conn->commit();

            header("Location: commande.php");
            exit();
        } else {
            throw new Exception("Aucune commande trouvée avec cet ID.");
        }
    } catch (Exception $e) {
        $conn->rollback(); 
        echo $e->getMessage();
    } finally {
        
        $stmt->close();
        $conn->close();
    }
} else {
    echo "ID de commande non spécifié.";
}
?>
