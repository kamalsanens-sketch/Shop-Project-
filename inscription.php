<?php
session_start();
include 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom      = $_POST['name'];
    $adress   = $_POST['adress'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $ville    = $_POST['city'];

    try {
        $sql = $pdo->prepare("INSERT INTO Client (nom, adress, email, password, city) 
                              VALUES (:nom, :adress, :email, :password, :city)");
        $sql->execute([
            ':nom'      => $nom,
            ':adress'   => $adress,
            ':email'    => $email,
            ':password' => $password,
            ':city'     => $ville
        ]);
        header("Location: accueil1.html");
        exit();
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="myDIV">
    <form action="" method="POST" class="card">
        <h1>Inscrivez-vous 🌍</h1>
        <p class="con">Créer votre compte</p>
        <div class="saisie">
            <label for="name">Login</label>
            <input type="text" id="name" name="name"
                placeholder="exemple:Kamal"/>
            <label for="password">Password</label>
            <input type="password" name="pwd" id="password"
                placeholder="inscrivez le mot de passe"/>
            <label for="ville">CITY</label>
            <input type="text" name="city" id="ville"
                placeholder="Inscrivez votre ville"/>
            <label for="adress">Adress</label>
            <input type="text" name="adress" id="adress"
                placeholder="inscrivez votre adresse"/>
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                placeholder="vous76exemple@gmail.com"/>
            <div>
                <button type="button" class="togpwd" onclick="togglePwd()">👁</button>
            </div>
            <div>
                <p style="color:red;font-size:15px;font-family:'DM Sans',sans-serif" id="msg">
                    <?php echo isset($message) ? $message : ""; ?>
                </p>
            </div>
        </div>
        <input type="submit" class="btn" value="Valider inscription">
    </form>

    <script>
        function togglePwd() {
            const p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>