<?php
include '../conexao.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conexao->prepare("SELECT id, nome, populacao, pais FROM Cidades WHERE id = ?");
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
        header("Location: cidades.php"); 
        exit();
    } else {
        echo "Erro na execução da query: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
