<?php
 

$host = 'localhost';          
$port = '5432';               
$dbname = 'gestionemploye'; 
$user = 'postgres';    
$password = 'ciara222';  

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
