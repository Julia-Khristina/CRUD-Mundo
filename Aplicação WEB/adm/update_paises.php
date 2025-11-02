<?php

session_start(); 
include '../conexao.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conexao->prepare("SELECT id, nome, continente, populacao, idioma FROM Paises WHERE id = ?");
    $stmt->bind_param("i", $id); // parâmetro número inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pais = $result->fetch_assoc();
        
        header('Content-Type: application/json');
        
        echo json_encode($pais);
    } else {
        header('Content-Type: application/json');
        http_response_code(404 ); 
        echo json_encode(['erro' => 'País não encontrado']);
    }

    $stmt->close();
    exit(); 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); 
    $nome = $_POST['nome'];
    $continente = $_POST['continente'];
    $populacao = $_POST['populacao'];
    $idioma = $_POST['idioma'];

    $sql = "UPDATE Paises SET nome = ?, continente = ?, populacao = ?, idioma = ? WHERE id = ?";
    
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        echo "Erro na preparação da query: " . $conexao->error;
        exit();
    }

    $stmt->bind_param("ssssi", $nome, $continente, $populacao, $idioma, $id);

    if ($stmt->execute()) {
        $_SESSION['feedback_mensagem'] = "País atualizado com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: paises.php"); 
        exit();
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao atualizar: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: paises.php"); 
        exit();
    }

    $stmt->close();
    $conexao->close();
}
?>
