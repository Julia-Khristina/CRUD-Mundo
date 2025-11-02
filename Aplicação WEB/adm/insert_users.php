<?php
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
        header("Location: usuario.php"); 
        exit();
    } else {
        echo "Erro ao cadastrar usuário: " . $conexao->error;
    }

    $conexao->close();
}
?>
