<?php
$host = 'db';
$dbname = 'db_AssetLogic';
$username = 'root';
$password = 'assets'; 

try {
    // Criação da ligação com PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro real da BD: " . $e->getMessage());
}
?>