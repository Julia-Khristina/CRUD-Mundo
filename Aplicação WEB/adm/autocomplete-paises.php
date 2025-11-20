<?php
header('Content-Type: application/json');

include '../conexao.php'; 

$conn = $conexao; 

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Falha na conexão com o banco de dados: " . $conn->connect_error]);
    exit();
}

$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

if (empty($searchTerm)) {
    echo json_encode([]);
    exit();
}

$sql = "SELECT id, nome FROM Paises WHERE nome LIKE ? ORDER BY nome ASC LIMIT 10";

$stmt = $conn->prepare($sql);

$param = $searchTerm . "%";
$stmt->bind_param("s", $param); 
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $suggestions[] = [
            'id' => $row['id'],
            'nome' => $row['nome']
        ];
    }
}

echo json_encode($suggestions);

$stmt->close();
$conn->close();
?>
