<?php
session_start(); 
include 'conexao.php';

echo "<!-- Debugging index.php Session Data -->\n";
echo "<!-- \$_SESSION['mensagem_erro'] no index.php: "; var_dump($_SESSION['mensagem_erro']); echo " -->\n";
echo "<!-- \$_SESSION['mensagem_sucesso'] no index.php: "; var_dump($_SESSION['mensagem_sucesso']); echo " -->\n"; 
echo "<!-- End Debugging index.php Session Data -->\n";

$error_message = '';
$email_value = '';

if(isset($_POST['email']) && isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {

        $email = $conexao->real_escape_string($_POST['email']);
        $senha = $conexao->real_escape_string($_POST['senha']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "E-mail inválido!";
        } else {
            $sql_code = "SELECT * FROM Usuarios WHERE email = '$email'";
            $sql_query = $conexao->query($sql_code) or die("Erro SQL: " . $conexao->error);

            if ($sql_query->num_rows == 1) {
                $usuario = $sql_query->fetch_assoc();

                if ($usuario['status'] === 'Bloqueado') {
                    $error_message = "Usuário bloqueado. Contate o suporte.";
                } else {
                    if (password_verify($senha, $usuario['senha'])) {
                        // Resetar tentativas e atualizar quantidade de acessos
                        $conexao->query("UPDATE Usuarios SET tentativas_login = 0 WHERE id = {$usuario['id']}");

                        $_SESSION['id'] = $usuario['id'];
                        $_SESSION['nome'] = $usuario['nome'];
                        $_SESSION['tipo'] = $usuario['tipo']; 

                        if ($usuario['tipo'] === 'Administrador') {
                            $_SESSION['admin'] = array(
                                'id' => $usuario['id'],
                                'nome' => $usuario['nome'],
                                'email' => $usuario['email']
                            );

                            $sql = "UPDATE Usuarios SET quantidade_acesso = quantidade_acesso + 1 WHERE id = {$usuario['id']}";
                            $conexao->query($sql);

                            $sqlQtd = "SELECT quantidade_acesso FROM Usuarios WHERE id = {$usuario['id']}";
                            $resultQtd = $conexao->query($sqlQtd);
                            if ($resultQtd && $rowQtd = $resultQtd->fetch_assoc()) {
                                $_SESSION['quantidade_acesso'] = $rowQtd['quantidade_acesso'];
                            }

                            var_dump($_SESSION['admin']);
                            header("Location: ./adm/dashboard.php"); 
                            exit();
                        } else {
                            $_SESSION['usuario_id'] = $usuario['id'];
                            $_SESSION['usuario_nome'] = $usuario['nome'];

                            $sql = "UPDATE Usuarios SET quantidade_acesso = quantidade_acesso + 1 WHERE id = {$usuario['id']}";
                            $conexao->query($sql);

                            $sqlQtd = "SELECT quantidade_acesso FROM Usuarios WHERE id = {$usuario['id']}";
                            $resultQtd = $conexao->query($sqlQtd);
                            if ($resultQtd && $rowQtd = $resultQtd->fetch_assoc()) {
                                $_SESSION['quantidade_acesso'] = $rowQtd['quantidade_acesso'];
                            }
                            header("Location: Home.php"); 
                            exit();
                        }

                        exit();
                    } else {
                        $nova_tentativa = $usuario['tentativas_login'] + 1;

                        if ($nova_tentativa >= 3) {
                            $conexao->query("UPDATE Usuarios 
                                SET tentativas_login = $nova_tentativa, status = 'Bloqueado' 
                                WHERE id = {$usuario['id']}");
                            $error_message = "Usuário bloqueado após 3 tentativas. Contate o suporte.";
                        } else {
                            $conexao->query("UPDATE Usuarios 
                                SET tentativas_login = $nova_tentativa 
                                WHERE id = {$usuario['id']}");
                            $restam = 3 - $nova_tentativa;
                            $error_message = "Senha incorreta. Você tem mais $restam tentativa(s).";
                        }
                    }
                }
            } else {
                $error_message = "E-mail não encontrado.";
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="img/frontImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Seja bem-vindo(a)!!!</span>
          <span class="text-2">Acesse sua conta e descubra nossos serviços personalizados. </span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="images/backImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
            <form method="POST" action="index.php">
            <div class="input-boxes">

              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Digite o seu email" required>
              </div>

              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="senha" placeholder="Digite a sua senha" required>
              </div>

              <button type="button" id="forgotPasswordBtn" style="color: #7d2ae8; background:none; border: none; text-align: center; text-decoration: none; font-size: 12px; border-radius: 5px; cursor: pointer;">
                  <div class="text sign-up-text">Esqueci minha senha!</div>
              </button>
              
              <div class="button input-box">
                <input type="submit" value="Entrar">
              </div>

              <div class="text sign-up-text">Você ainda não tem conta? <a href="Cadastro.php" style="color: #7d2ae8;">Cadastrar</a>
              </div>

              <?php if ($error_message != ''): ?>
                <div id="toast" data-message="<?= htmlspecialchars($error_message) ?>"></div>
              <?php endif; ?>

            </div>
        </form>

        <?php if (!empty($_SESSION['mensagem_erro'])): ?>
            <div id="toast-error" class="toast error" data-message="<?= htmlspecialchars($_SESSION['mensagem_erro']) ?>"></div>
            <?php unset($_SESSION['mensagem_erro']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
            <div id="toast-success" class="toast success" data-message="<?= htmlspecialchars($_SESSION['mensagem_sucesso']) ?>"></div>
            <?php unset($_SESSION['mensagem_sucesso']); ?>
        <?php endif; ?>

        <!-- Modal -->
        <div class="modal-container" id="modal-container" style="display: none;">
            <div id="modal" class="modal">
                <form method="POST" action="recuperar_senha.php">
                    <div class="modal_title">Altere sua senha!</div>                   
                    <label for="email">Email</label>
                    <input type="email" name="email" id="user-email" required placeholder="Digite seu email"><br>
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="user-senha" required placeholder="Digite sua nova senha"><br>

                    <button type="submit" style="background-color:#7d2ae8; color: white; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">Salvar</button>

                    <button type="button" id="closeModalBtn" style="color: #7d2ae8; background: none; border: none; cursor: pointer;">
                        Voltar
                    </button>
                </form>
            </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>

<script>
    $(document).ready(function() {
        $('#forgotPasswordBtn').on('click', function() {
            $('#modal-container').show();
        });

        $('#closeModalBtn').on('click', function() {
            $('#modal-container').hide();
        });

        const toast = document.getElementById("toast");
        const message = toast?.dataset?.message;

        if (message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 4000);
        }

        const showToastById = (id) => {
        const toast = document.getElementById(id);
        const message = toast?.dataset?.message;

        if (message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 4000);
        }
    };

    showToastById("toast-error");
    showToastById("toast-success");

    });
</script>