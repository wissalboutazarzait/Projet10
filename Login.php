<?php
session_start(); 

$email = "";
$errEmail = "";
$password = "";
$errPassword = "";

if (isset($_POST["unique_email"])) {
    $email = trim($_POST["unique_email"]); 
    $password = $_POST["unique_password"];

    if (empty($email)) {
        $errEmail = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errEmail = "L'email n'est pas valide";
    }

    if (empty($errEmail)) {
        $host = 'localhost';
        $dbname = 'gestion_produit';
        $dbUsername = 'root'; 
        $dbPassword = ''; 

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_email'] = $email;

                header("Location: statistiques.php");
                exit(); 
            } else {
                $errPassword = "Email ou mot de passe incorrect";
            }

        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style> 
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to bottom, #00008B 0%, #87CEEB 100%);
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        display: flex;
        align-items: stretch; 
        justify-content: center;
        width: 90%; 
        max-width: 1300px;
        height: 65vh; 
        background-color: white;
        box-shadow: 0 0 20px rgba(0, 0, 255, 0.5); 
        border-radius: 8px;
    }

    .image-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%; 
        margin-right: 0; 
    }

    img.form-image {
        width: 100%;
        height: 100%; 
        object-fit: cover; 
        border-radius: 8px 0 0 8px; 
    }

    .form-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%; 
        padding: 20px;
        box-sizing: border-box;
    }

    .form-container h2 {
        font-size: 45px; 
        color: #333; 
        font-weight: bold; 
        margin-bottom: 20px;
        text-align: center; 
        margin-top: -20px; 
    }

    .form-container input {
        width: 100%;
        padding: 15px;
        margin-bottom: 20px;
        border: 2px solid #007bff; 
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }

    .form-container button {
        width: 100%;
        padding: 15px;
        background-color: #007bff;
        color: white;
        border: 2px solid #0056b3;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-container button:hover {
        background-color: #0056b3;
    }

    .form-container p {
        color: red;
        font-size: 14px;
        margin: -15px 0 15px 0;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="image/informatique.jpeg" alt="Image de Connexion" class="form-image">
        </div>

        <div class="form-container">
            <h2>Bienvenue</h2>
            <form id="loginForm" method="post" action="#">
                <input type="text" name="unique_email" placeholder="Email" autocomplete="new-email" required />
                <p><?= htmlspecialchars($errEmail) ?></p>
                <input type="password" name="unique_password" placeholder="Mot de passe" autocomplete="new-password" required />
                <p><?= htmlspecialchars($errPassword) ?></p>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
