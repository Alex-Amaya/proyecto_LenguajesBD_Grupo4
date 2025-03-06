<?php

$host = 'localhost'; 
$port = '1521'; 
$service_name = 'orcl'; 
$user = 'JuanP'; 
$password = 'Fide123';

try {

    $pdo = new PDO("oci:dbname=//$host:$port/$service_name", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

