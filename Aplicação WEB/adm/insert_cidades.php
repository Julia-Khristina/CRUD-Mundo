<?php
session_start();
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $populacao = $_POST['populacao'];   
    $pais = $_POST['pais'];

    $sql = "INSERT INTO Cidades (nome, populacao, pais) VALUES (?, ?, ?)";
    
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        echo "Erro na preparação da query: " . $conexao->error;
        exit();
    }

    $stmt->bind_param("sii", $nome, $populacao, $pais);

    if ($stmt->execute()) {
        $_SESSION['feedback_mensagem'] = "Cadastro realizado com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: cidades.php"); 
        exit();
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao cadastrar: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: cidades.php"); 
        exit();
    }

    $stmt->close();
    $conexao->close();
}
?>
