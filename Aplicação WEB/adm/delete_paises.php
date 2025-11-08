<?php
session_start(); 
include '../conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // id do país

    // Verifica se existem cidades associadas a esse país
    $check_sql = "SELECT COUNT(*) AS total FROM Cidades WHERE pais = $id";
    $check_result = $conexao->query($check_sql);
    $row = $check_result->fetch_assoc();

    if ($row['total'] > 0) {
        // Bloqueia a exclusão se houver cidades vinculadas
        $_SESSION['feedback_mensagem'] = "Não é possível excluir o país, pois existem cidades vinculadas.";
        $_SESSION['feedback_tipo'] = "erro";
        header("Location: paises.php");
        exit();
    }

    // Se não tiver cidades, pode excluir
    $sql = "DELETE FROM Paises WHERE id = $id";

    if ($conexao->query($sql) === TRUE) {
        $_SESSION['feedback_mensagem'] = "País excluído com sucesso!";
        $_SESSION['feedback_tipo'] = "sucesso";
    } else {
        $_SESSION['feedback_mensagem'] = "Erro ao excluir: " . $conexao->error;
        $_SESSION['feedback_tipo'] = "erro";
    }

    header("Location: paises.php");
    exit();

    $conexao->close();
}
?>
