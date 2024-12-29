<?php
session_start();

if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = 'fr';
}

$translations = include('lang/' . $lang . '.php');

$conn = new mysqli("localhost", "root", "", "gestion_produit");
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: Login.php"); 
    exit();
}

if (isset($_POST['update_info'])) {
    $new_email = $_POST['new_email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $user_id = 1;

    $stmt = $conn->prepare("UPDATE user SET email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_email, $new_password, $user_id);
    
    if ($stmt->execute()) {
        $message = "Informations mises à jour avec succès.";
    } else {
        $message = "Erreur lors de la mise à jour des informations.";
    }
    
    $stmt->close();
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: parametre.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Paramètres</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .section-card {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
        }

        .section-card h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #2C3E50;        
        }
        .section-card form {
            display: flex;
            flex-direction: column;
            gap: 15px; 
}

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="email"],
input[type="password"],
select {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

button {
    padding: 10px 20px;
    background-color: #27AE60;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #2ECC71;
    transition: 0.3s;
}


        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
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
            color: black;
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
        .settings-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); 
    gap: 20px; 
}

@media (max-width: 768px) {
    .settings-grid {
        grid-template-columns: 1fr; 
    }
}
.language-selector {
    margin-top: 20px;
}

.language-selector label {
    font-weight: bold;
    margin-right: 10px;
}


.language-selector select {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background-color: white;
    cursor: pointer;
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
        <h1><?php echo $translations['settings_title']; ?></h1>
            <form method="POST">
            <button type="submit" name="logout"><i class="fas fa-sign-out-alt"></i> <?php echo $translations['logout']; ?></button>
            </form>
        </header>

        <div class="container">
        <div class="container">
    <?php if (isset($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="settings-grid">
        <div class="section-card">
        <h2><?php echo $translations['update_info']; ?></h2>

            <form method="POST">
                <label for="new_email"><?php echo $translations['new_email']; ?></label>
            <input type="email" id="new_email" name="new_email" placeholder="<?php echo $translations['new_email']; ?>" required>

            <label for="new_password"><?php echo $translations['new_password']; ?></label>
            <input type="password" id="new_password" name="new_password" placeholder="<?php echo $translations['new_password']; ?>" required>

            <button type="submit" name="update_info"><?php echo $translations['update_button']; ?></button>
       </form>
        </div>

        <div class="section-card">
        <h2><?php echo $translations['language_selection']; ?></h2>
        <form method="GET" class="language-selector">
                <label for="lang">Langue: </label>
                <select id="lang" name="lang" onchange="this.form.submit()">
                    <option value="fr" <?php if ($lang === 'fr') echo 'selected'; ?>>Français</option>
                    <option value="en" <?php if ($lang === 'en') echo 'selected'; ?>>English</option>
                </select>
            </form>
        </div>
    </div>
</div>
</body>
</html>
