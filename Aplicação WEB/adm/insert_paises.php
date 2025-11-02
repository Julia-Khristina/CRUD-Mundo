<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $continente = $conexao->real_escape_string($_POST['continente']);
    $populacao = $conexao->real_escape_string($_POST['populacao']);
    $idioma = $conexao->real_escape_string($_POST['idioma']);

    $sql = "INSERT INTO Paises (nome, continente, populacao, idioma) 
            VALUES ('$nome', '$continente', '$populacao', '$idioma')";

    if ($conexao->query($sql) === TRUE) {
        header("Location: paises.php"); 
        exit();
    } else {
        echo "Erro ao cadastrar país: " . $conexao->error;
    }

    $conexao->close();
}
?>
