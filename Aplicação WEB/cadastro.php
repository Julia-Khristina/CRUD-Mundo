<?php
include('conexao.php');

$error_message = '';
$success_message = '';
$email_value = '';

if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['nome'])) {

  $nome = $conexao->real_escape_string($_POST['nome']);
  $email = $conexao->real_escape_string($_POST['email']);
  $tipo = isset($_POST['tipo']) ? $conexao->real_escape_string($_POST['tipo']) : null;
  $senha_original = $_POST['senha'];
  $senha_hash = password_hash($senha_original, PASSWORD_DEFAULT);
  $senha = $conexao->real_escape_string($senha_hash);

  $primeiro_acesso_flag = '1';

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message = "E-mail inválido!";
  } else {
    // Verifica se o e-mail já existe
    $sql_check = "SELECT * FROM Usuarios WHERE email = '$email'";
    $result = $conexao->query($sql_check);

    if ($result->num_rows > 0) {
      $error_message = "Este e-mail já está cadastrado!";
    } else {
      // Insere novo usuário
      $sql_insert = "INSERT INTO Usuarios (nome, email, senha, tipo, primeiro_acesso) VALUES ('$nome', '$email', '$senha', '$tipo', '$primeiro_acesso_flag')";
      $insert = $conexao->query($sql_insert);

      if ($insert) {
        $success_message = "Cadastro realizado com sucesso!";
        header("Location: Index.php");
        exit;
      } else {
        $error_message = "Erro ao cadastrar: " . $conexao->error;
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <script>
    window.onload = function () {
      const toast = document.getElementById("toast");
      const message = toast?.dataset?.message;

      if (message) {
        toast.textContent = message;
        toast.classList.add("show");

        // Esconde o toast após 4 segundos
        setTimeout(() => {
          toast.classList.remove("show");
        }, 4000);
      }
    };
    function validateForm(event) {

      var nome = document.getElementsByName("nome")[0].value;
      var email = document.getElementsByName("email")[0].value;
      var senha = document.getElementsByName("senha")[0].value;

      if (nome.trim() === "" || email.trim() === "" || senha.trim() === "") {
        event.preventDefault();  // Impede o envio do formulário
        alert("Todos os campos devem ser preenchidos!");
        return false;
      }

      // Verificar se o e-mail é válido
      var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailPattern.test(email)) {
        event.preventDefault();
        alert("Por favor, insira um e-mail válido.");
        return false;
      }

      return true;  // Formulário pode ser enviado
    }
  </script>
</head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="img/frontImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Seja bem-vindo(a)!!!</span>
          <span class="text-2">Cadastre-se e descubra tudo sobre países e o clima ao redor do planeta.</span>
        </div>
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Cadastro</div>
          <form method="POST" action="cadastro.php" onsubmit="return validateForm(event)">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="nome" placeholder="Digite o seu nome" required>
              </div>

              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Digite o seu email" required>
              </div>

              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="senha" placeholder="Digite a sua senha" required>
              </div>

              <div class="radio-group">
                <label class="form-check">
                  <input class="form-check-input" type="radio" name="tipo" value="Administrador" id="flexRadioDefault1">
                  Administrador
                </label>

                <label class="form-check">
                  <input class="form-check-input" type="radio" name="tipo" value="Usuário Comum" id="flexRadioDefault2" checked>
                  Usuário Comum
                </label>
              </div>

              <?php if ($error_message != ''): ?>
                <div id="toast" data-message="<?= htmlspecialchars($error_message) ?>"></div>
              <?php endif; ?>

              <div class="button input-box">
                <input type="submit" value="Cadastrar">
              </div>

              <div class="text sign-up-text">Eu já tenho conta? <a href="Index.php" style="color: #7d2ae8;">Entrar</a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
