<?php
$servername = "localhost";
$database = "mundo"; 
$username = "root";    
$password = "";        

// Criar a conexão
$conexao = mysqli_connect($servername, $username, $password, $database);

// Verificação da conexão
if (!$conexao) {
    die("Falha na Conexão: " . mysqli_connect_error());
}

?>
