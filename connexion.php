<?php
$host = "localhost";
$bdd  = "Vente";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$bdd;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}
?>