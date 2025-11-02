<?php
include '../conexao.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM Paises WHERE id=$id";

    if ($conexao -> query($sql) === TRUE){
        echo "Registro excluído com sucesso!";
    } else{
        echo "Erro ao excluir registro: " . $conexao->error;
    }

    $conexao ->close();
    header("Location: paises.php");
}
?>