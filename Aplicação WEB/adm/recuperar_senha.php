<?php
session_start();
include '../conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    echo json_encode(
        $result->num_rows > 0
            ? $result->fetch_assoc()
            : ['error' => 'Usuário não encontrado!']
    );

    $stmt->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['email']) || !isset($_POST['senha'])) {
        $_SESSION['mensagem_erro'] = "Dados incompletos!";
        header("Location: adm.php");
        exit();
    }

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se existe usuário com o e-mail informado
    $checkStmt = $conexao->prepare("SELECT id FROM usuario WHERE email=?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $checkStmt->close();

    if ($result->num_rows == 0) {
        $_SESSION['mensagem_erro'] = "Usuário não encontrado!";
        header("Location: adm.php");
        exit();
    }

    // Atualiza senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $update = $conexao->prepare("UPDATE usuario SET senha=? WHERE email=?");
    $update->bind_param("ss", $senha_hash, $email);

    if ($update->execute()) {
        $_SESSION['mensagem_sucesso'] = "Senha alterada com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao atualizar: " . $update->error;
    }

    $update->close();
    $conexao->close();

    header("Location: adm.php");
    exit();
}
?>
