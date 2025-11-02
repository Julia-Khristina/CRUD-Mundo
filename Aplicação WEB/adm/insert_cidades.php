<?php
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
        header("Location: cidades.php"); 
        exit();
    } else {
        echo "Erro ao cadastrar cidade: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
