<?php
session_start(); 
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $continente = $_POST['continente'];
    $populacao = $_POST['populacao'];
    $idioma = $_POST['idioma'];

    $sql = "INSERT INTO Paises (nome, continente, populacao, idioma) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        $_SESSION['feedback_mensagem'] = "Erro na preparação da query: " . $conexao->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: paises.php"); 
        exit();
    }

    $stmt->bind_param("ssss", $nome, $continente, $populacao, $idioma);

    if ($stmt->execute()) {
        $_SESSION['feedback_mensagem'] = "País cadastrado com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: paises.php"); 
        exit();
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao cadastrar: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: paises.php"); 
        exit();
    }

    $stmt->close();
    $conexao->close();
}
?>