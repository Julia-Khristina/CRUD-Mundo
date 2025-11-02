<?php
session_start(); 
include '../conexao.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt_select = $conexao->prepare("SELECT id, nome, email, status, tipo FROM Usuarios WHERE id = ?");
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user['senha'] = ''; 
        echo json_encode($user); 
    } else {
        echo json_encode(['error' => 'Usuário não encontrado!']);
    }
    $stmt_select->close();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); 
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 
    $status = $_POST['status'];
    $tipo = $_POST['tipo'];

    $sql_parts = []; 
    $bind_types = ''; 
    $bind_params = []; 

    $sql_parts[] = "nome = ?";
    $bind_types .= "s";
    $bind_params[] = &$nome; 

    $sql_parts[] = "email = ?";
    $bind_types .= "s";
    $bind_params[] = &$email;

    $sql_parts[] = "status = ?";
    $bind_types .= "s";
    $bind_params[] = &$status;

    $sql_parts[] = "tipo = ?";
    $bind_types .= "s";
    $bind_params[] = &$tipo;

    if (!empty($senha)) { 
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Gera o hash da nova senha
        $sql_parts[] = "senha = ?"; // Adiciona a parte da senha à query
        $bind_types .= "s"; // Adiciona o tipo para a senha
        $bind_params[] = &$senha_hash; // Adiciona a senha hasheada aos parâmetros
    }

    $sql = "UPDATE Usuarios SET " . implode(", ", $sql_parts) . " WHERE id = ?";
    $bind_types .= "i"; 
    $bind_params[] = &$id; 

    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        echo "Erro na preparação da query: " . $conexao->error;
        exit();
    }

    call_user_func_array([$stmt, 'bind_param'], array_merge([$bind_types], $bind_params));

    if ($stmt->execute()) {
        $_SESSION['feedback_mensagem'] = "Usuário atualizado com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: usuario.php"); 
        exit();
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao atualizar: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: usuario.php"); 
        exit();
    }

    $stmt->close();
    $conexao->close();
}
?>
