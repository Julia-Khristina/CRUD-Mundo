<?php
session_start();
include '../conexao.php'; 

$feedback_mensagem = $_SESSION['feedback_mensagem'] ?? null;
$feedback_tipo = $_SESSION['feedback_tipo'] ?? null;

unset($_SESSION['feedback_mensagem']);
unset($_SESSION['feedback_tipo']);

$sql = "SELECT id, nome, email, senha, status, tipo, quantidade_acesso, tentativas_login, created_at FROM Usuarios";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aquestre</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle" style="display: flex; align-items: center; justify-content: space-between;">
            <!-- Ícone do menu -->
            <i class="bi bi-list" id="header-toggle" style="font-size: 1.5rem; color: #961b80;"></i>
        
            <!-- Texto "Dashboard Aquestre" -->
            <div style="display: flex; align-items: center; margin-left: 1rem;">
                <p style="margin: 0; font-size: 1.2rem; color: #000000;">Usuários</p>
            </div>
        </div>

    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <!-- Logo e Nome -->
            <div>
                <!-- Lista de Navegação -->
                <div class="nav_list">
                    <a href="dashboard.php" class="nav_link">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="nav_name">Início</span>
                    </a>
                    <a href="usuario.php" class="nav_link active">
                        <i class="bi bi-person-fill"></i>
                        <span class="nav_name">Usuários</span>
                    </a>
                    <a href="paises.php" class="nav_link">
                        <i class="bi bi-globe2"></i>
                        <span class="nav_name">Países</span>
                    </a>
                    <a href="cidades.php" class="nav_link">
                        <i class="bi bi-buildings-fill"></i>
                        <span class="nav_name">Cidades</span>
                    </a>
                   
                </div>
            </div>
            <!-- Logout -->
            <a href="logout.php" class="nav_link">
                <i class="bi bi-box-arrow-left"></i>
                <span class="nav_name">SignOut</span>
            </a>
        </nav>
    </div>

    <br>

    <button class='openCadastrarBtn' style='width: 15%; background:#961b80; border: none; text-align: center; text-decoration: none; font-size: 12px; border-radius: 5px; cursor: pointer;'>
        <h3 style='color:rgb(255, 255, 255);'>Cadastrar usuário</h3> <!-- Cor personalizada aqui -->
    </button>

    <?php if ($feedback_mensagem): ?>
        <div id="toast-feedback" 
            class="toast-base toast-<?= htmlspecialchars($feedback_tipo) ?>" 
            data-message="<?= htmlspecialchars($feedback_mensagem) ?>">
        </div>
    <?php endif; ?>
    
    <div class="style-tabela">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">                      
            <tbody>
                <tr>
                    <td class="top center"><strong>ID</strong></td>
                    <td class="top center"><strong>Nome</strong></td>
                    <td class="top center"><strong>Email</strong></td>
                    <td class="top center"><strong>Senha</strong></td>
                    <td class="top center"><strong>Status</strong></td>
                    <td class="top center"><strong>Tipo</strong></td>
                    <td class="top center"><strong>Quantidade de acessos</strong></td>
                    <td class="top center"><strong>Tentativas de login</strong></td>
                    <td class="top center"><strong>Criado a:</strong></td>
                    <td class="top center" colspan="2" width="1"><strong>Ações</strong></td>
                </tr>
            </tbody>

            <tbody>

            <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td align='center'>" . $row['id'] . "</td>
                            <td align='center'>" . htmlspecialchars($row['nome']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['email']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['senha']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['status']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['tipo']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['quantidade_acesso']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['tentativas_login']) . "</td>

                            <td align='center'>" . htmlspecialchars($row['created_at']) . "</td>
                            <td align='center'>
                                <button class='openModalBtn' data-id='" . $row['id'] . "' style='background:none; border: none; text-align: center; text-decoration: none; font-size: 12px; border-radius: 5px; cursor: pointer;'>
                                    <i class='bi bi-pencil-fill' style='color: #961b80;'></i> <!-- Cor personalizada aqui -->
                                </button>
                            </td>
                            <td align='center'>
                                <a href='delete_users.php?id=" . $row['id'] . "' style='color: #961b80; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 5px; cursor: pointer;'>X</a>
                            </td>
                        </tr>";
                    }
                }
                ?>              
            </tbody>                
        
        </table>
        </div><!--tabela-->

        <!-- MODAL CADASTRAR -->
    <div class="modal-container" id="modal-cadastrar" style="display: none;">
        <div id="modal" class="modal">
            <form method="POST" action="insert_users.php">
                <h2>Cadastre um novo usuário!</h2>
                <input type="hidden" name="id" id="user-id">

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="user-nome" required><br>

                <label for="email">Email</label>
                <input type="email" name="email" id="user-email" required><br>

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="user-senha" required><br>

                <label for="status">Status</label>
                <select name="status" id="user-status" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                    <option value="Bloqueado">Bloqueado</option>
                </select>

                <label for="tipo">Tipo</label>
                <select name="tipo" id="user-tipo" required>
                    <option value="Usuário Comum">Usuário Comum</option>
                    <option value="Administrador">Administrador</option>
                </select>

                <button type="submit" style="background-color: #961b80; color: white; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">Salvar</button>

                <button type="button" class="closeModalBtn" style="color: rgb(57, 57, 226) ;background: none; border: none; cursor: pointer; color: inherit; font: inherit;">
                    Voltar
                </button>
            </form>
        </div>
    </div>

        <!-- MODAL ALTERAR -->
        <!-- Modal -->
    <div class="modal-container" id="modal-editar" style="display: none;">
        <div id="modal" class="modal">
            <form method="POST" action="update_users.php">
                <h2>Altere os dados necessários!</h2>
                <input type="hidden" name="id" id="editar-id">

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="editar-nome" required><br>

                <label for="email">Email</label>
                <input type="email" name="email" id="editar-email" required><br>

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="editar-senha"><br>

                <label for="status">Status</label>
                <select name="status" id="editar-status" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                    <option value="Bloqueado">Bloqueado</option>
                </select>

                <label for="tipo">Tipo</label>
                <select name="tipo" id="editar-tipo" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuário Comum">Usuário Comum</option>
                </select>

                <button type="submit" style="background-color: #961b80; color: white; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">Salvar</button>

                <button type="button" class="closeModalBtn" style="color: rgb(57, 57, 226) ;background: none; border: none; cursor: pointer; color: inherit; font: inherit;">
                    Voltar
                </button>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        const toastElement = $('#toast-feedback');
    
        if (toastElement.length) {
            const mensagem = toastElement.data('message');               
            toastElement.text(mensagem);                
            toastElement.addClass('show');
            
        setTimeout(function() {
                toastElement.removeClass('show');                    
                setTimeout(function() {
                    toastElement.remove();
                }, 500);                    
            }, 5000); 
        }
        // Abrir o modal de edição
        $('.openModalBtn').on('click', function () {
            var userId = $(this).data('id');

            $.ajax({
                url: 'update_users.php',
                type: 'GET',
                data: { id: userId },
                success: function (response) {
                    var user = JSON.parse(response);
                    $('#editar-id').val(user.id);
                    $('#editar-nome').val(user.nome);
                    $('#editar-email').val(user.email);
                    $('#editar-senha').val(user.senha);
                    $('#editar-status').val(user.status);
                    $('#editar-tipo').val(user.tipo);
                    $('#modal-editar').show();
                }
            });
        });

        // Abrir modal de cadastro (sem AJAX)
        $('.openCadastrarBtn').on('click', function () {
            $('#cadastro-id').val('');
            $('#cadastro-nome').val('');
            $('#cadastro-email').val('');
            $('#cadastro-senha').val('');
            $('#cadastro-status').val('Ativo');
            $('#cadastro-tipo').val('Usuário Comum');
            $('#modal-cadastrar').show();
        });

        // Fechar ambos os modais
        $('.closeModalBtn').on('click', function () {
            $(this).closest('.modal-container').hide();
        });

    });
</script>

    

    <script src="dashboard.js"></script>
</body>
</html>