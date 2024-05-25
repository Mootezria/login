<?php
$servername = "localhost"; // Modifier si nécessaire
$username = "root"; // Modifier si nécessaire
$password = ""; // Modifier si nécessaire
$dbname = "client1"; // Modifier si nécessaire

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $numero = $_POST['telephone'];
    $email = $_POST['email'];
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

    // Préparer la requête SQL avec des paramètres
    $sql = "INSERT INTO client_carr (nom, adresse, numero, email, pass) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Lier les variables PHP aux paramètres de la requête
    $stmt->bind_param("sssss", $nom, $adresse, $numero, $email, $motdepasse);

    // Exécuter la requête
    if ($stmt->execute()) {
        header("Location: index.html");
        exit();
    } else {
        $message = "Erreur: " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="css/sigin.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <img class="wave" src="img/wave.png">
    <div class="container">
        <div class="img">
            <img src="img/bg.svg">
        </div>
        <div class="login-content">
            <form action="signup.php" method="POST">
                <img src="img/avatar.svg">
                <h2 class="title">Bienvenue</h2>
                <?php
                if (!empty($message)) {
                    echo '<p>' . $message . '</p>';
                }
                ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Nom</h5>
                        <input type="text" name="nom" class="input" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="div">
                        <h5>Adresse</h5>
                        <input type="text" name="adresse" class="input" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="email" name="email" class="input" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="div">
                        <h5>Numéro de téléphone</h5>
                        <input type="text" name="telephone" class="input" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Mot de passe</h5>
                        <input type="password" name="motdepasse" class="input" required>
                    </div>
                </div>
                <input type="submit" class="btn" value="S'inscrire">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
