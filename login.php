<?php

session_start();

// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "client1";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$message = ""; // Initialisation du message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour vérifier les informations de connexion
    $sql = "SELECT id, pass FROM client_carr WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Les informations de connexion sont correctes
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $message = "Bienvenue, " . htmlspecialchars($username) . "!";
        } else {
            // Le mot de passe est incorrect
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        // L'utilisateur n'existe pas
        $message = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Animated Login Form</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
            <form action="login.php" method="POST">
                <img src="img/avatar.svg">
                <h2 class="title">Welcome</h2>
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
                        <h5>Username</h5>
                        <input type="text" class="input" name="username" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password" required>
                   </div>
                </div>
                <a href="#">Forgot Password?</a>
                <input type="submit" class="btn" value="Login">
                <input type="button" class="btn" value="Sign Up" id="signUpButton">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
    <script>
        document.getElementById('signUpButton').addEventListener('click', function() {
            window.location.href = 'signup.php'; // Redirige vers la page d'inscription
        });
    </script>
</body>
</html>
