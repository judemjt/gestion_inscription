<?php
$host = 'mysql-judemavioga.alwaysdata.net';
$dbname = 'judemavioga_gestion_inscription';
$username = '381459_root';
$password = 'mjt_root';

// Connexion avec MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

echo "Connexion réussie !";
?>


