<?php
session_start();
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $email = $conexao->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];
    $status = $conexao->real_escape_string($_POST['status']);
    $tipo = $conexao->real_escape_string($_POST['tipo']);
    $primeiro_acesso_flag = '1';

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (nome, email, senha, status, tipo, primeiro_acesso) 
            VALUES ('$nome', '$email', '$senha_hash', '$status', '$tipo', '$primeiro_acesso_flag')";

    if ($conexao->query($sql) === TRUE) {
        $_SESSION['feedback_mensagem'] = "Cadastro realizado com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: usuario.php"); 
        exit();
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao cadastrar: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: usuario.php"); 
        exit();
    }

    $conexao->close();
}
?>
