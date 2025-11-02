<?php
session_start();
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM Usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'Usuário não encontrado!']);
    }
    $stmt->close();
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensagem_para_sessao = '';
    $tipo_mensagem = 'erro'; 

    if (isset($_POST['email'], $_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha']; 

        $checkStmt = $conexao->prepare("SELECT status FROM Usuarios WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->bind_result($status);

        if ($checkStmt->fetch()) {
    
    if ($status === 'Bloqueado') {
        $mensagem_para_sessao = "Usuário bloqueado. Não é possível alterar a senha.";
        $checkStmt->close(); 
    } else {
        $checkStmt->close(); 

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt_update_password = $conexao->prepare("UPDATE Usuarios SET senha=? WHERE email=?");
        $stmt_update_password->bind_param("ss", $senha_hash, $email);

        if ($stmt_update_password->execute()) {
            $mensagem_para_sessao = "Senha alterada com sucesso!";
            $tipo_mensagem = 'sucesso';
        } else {
            $mensagem_para_sessao = "Erro ao atualizar a senha: " . $stmt_update_password->error;
        }
        $stmt_update_password->close();
    }
    } else {
        // Usuário não encontrado
        $mensagem_para_sessao = "Usuário não encontrado!";
        $checkStmt->close(); 
    }

    } else {
       
        $mensagem_para_sessao = "Dados incompletos para a atualização da senha!";
    }

    $conexao->close(); 

    if ($tipo_mensagem === 'sucesso') {
        $_SESSION['mensagem_sucesso'] = $mensagem_para_sessao;
    } else {
        $_SESSION['mensagem_erro'] = $mensagem_para_sessao;
    }
    header("Location: Index.php");
    exit();

}
?>
