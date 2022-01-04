<?php

$host   = "localhost";
$user   = "root";
$pass   = 'root';
$dbname = "tcc_bov";
$port = 3306;

 try { 
    $conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);
    //echo "Conexão com o banco de dados realizado com sucesso!";
 } catch(PDOException $e) {
    echo "Erro: Falha na conexão com o banco: " . $e->getMessage();
 }