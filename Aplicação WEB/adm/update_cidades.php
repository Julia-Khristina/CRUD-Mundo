<?php
session_start(); 
include '../conexao.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "
        SELECT 
            C.id, 
            C.nome, 
            C.populacao, 
            C.pais AS pais_id,      
            P.nome AS pais_nome    
        FROM 
            Cidades C
        INNER JOIN 
            Paises P ON C.pais = P.id
        WHERE 
            C.id = ?
    ";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id); 
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
    $populacao = $_POST['populacao'];
    $pais = $_POST['pais'];

    $sql = "UPDATE Cidades SET nome = ?, populacao = ?, pais = ? WHERE id = ?";
    
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        echo "Erro na preparação da query: " . $conexao->error;
        exit();
    }

    $stmt->bind_param("sssi", $nome, $populacao, $pais, $id);

    if ($stmt->execute()) {
        $_SESSION['feedback_mensagem'] = "Cidade atualizada com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: cidades.php"); 
        exit();
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao atualizar: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: cidades.php"); 
        exit();
    }

    $stmt->close();
    $conexao->close();
}
?>
