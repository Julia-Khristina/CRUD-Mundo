<?php
session_start(); 
include '../conexao.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM Usuarios WHERE id=$id";

    if ($conexao -> query($sql) === TRUE){
        $_SESSION['feedback_mensagem'] = "Usuário excluído com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
        header("Location: usuario.php"); 
        exit();
    } else{
        $_SESSION['feedback_mensagem'] = "Erro ao excluir: " . $stmt->error;
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: usuario.php"); 
        exit();
    }

    $conexao ->close();
}
?>