<?php
session_start();
include 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['pwd'];

    if (!isset($_SESSION['tentatives'])) {
        $_SESSION['tentatives'] = 0;
    }

    if ($_SESSION['tentatives'] >= 3) {
        $message = "Compte bloqué. Trop de tentatives.";
    } else {
        $sql = $pdo->prepare("SELECT * FROM Client WHERE email = :email");
        $sql->execute([':email' => $email]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['tentatives'] = 0;
            $_SESSION['user'] = $user;
            header("Location: accueil1.html");
            exit();
        } else {
            $_SESSION['tentatives']++;
            $restantes = 3 - $_SESSION['tentatives'];
            $message = "Identifiants incorrects. Tentatives restantes : $restantes";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="myDIV">
    <form class="card" method="POST">
        <div>
            <h1>Connectez-vous 🔁</h1>
            <p class="con">Connectez-vous à votre compte</p>
            <div class="saisie">
                <label for="name">Login(mettez votre email comme login)</label>
                <input type="email" id="name" name="email"
                    placeholder="kamal45exemple@gmail.com"/>
                <label for="password">Password</label>
                <input type="password" name="pwd" id="password"
                    placeholder="inscrivez le mot de passe"/>
                <div>
                    <button type="button" class="togpwd" onclick="togglePwd()">👁</button>
                </div>
                <div>
                    <p style="color:red;font-size:15px;font-family:'DM Sans',sans-serif" id="msg">
                        <?php echo isset($message) ? $message : ""; ?>
                    </p>
                </div>
            </div>
            <input type="submit" class="btn" value="Se connecter">
            <a class="btn1" href="inscription.php">S'inscrire : Créer votre compte</a>
        </div>
    </form>

    <script>
        function togglePwd() {
            const p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>