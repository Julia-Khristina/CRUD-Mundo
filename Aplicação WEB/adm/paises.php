<?php
session_start();
include '../conexao.php'; 

$feedback_mensagem = $_SESSION['feedback_mensagem'] ?? null;
$feedback_tipo = $_SESSION['feedback_tipo'] ?? null;

unset($_SESSION['feedback_mensagem']);
unset($_SESSION['feedback_tipo']);

$sql = "SELECT id, nome, continente, populacao, idioma FROM Paises";
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
 
            <i class="bi bi-list" id="header-toggle" style="font-size: 1.5rem; color: #961b80;"></i>
        
            <div style="display: flex; align-items: center; margin-left: 1rem;">
                <p style="margin: 0; font-size: 1.2rem; color: #000000;">Países</p>
            </div>
        </div>

    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list">
                    <a href="dashboard.php" class="nav_link">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="nav_name">Início</span>
                    </a>
                    <a href="paises.php" class="nav_link active">
                        <i class="bi bi-globe2"></i>
                        <span class="nav_name">Países</span>
                    </a>
                    <a href="cidades.php" class="nav_link">
                        <i class="bi bi-buildings-fill"></i>
                        <span class="nav_name">Cidades</span>
                    </a>
                   
                </div>
            </div>
            <a href="logout.php" class="nav_link">
                <i class="bi bi-box-arrow-left"></i>
                <span class="nav_name">SignOut</span>
            </a>
        </nav>
    </div>

    <br>

    <button class='openCadastrarBtn' style='width: 15%; background:#961b80; border: none; text-align: center; text-decoration: none; font-size: 12px; border-radius: 5px; cursor: pointer;'>
        <h3 style='color:rgb(255, 255, 255);'>Cadastrar País</h3> <!-- Cor personalizada aqui -->
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
                    <td class="top center"><strong>Continente </strong></td>
                    <td class="top center"><strong>Populacao </strong></td>
                    <td class="top center"><strong>Idioma </strong></td>
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
                            <td align='center'>" . htmlspecialchars($row['continente']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['populacao']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['idioma']) . "</td>
                            <td align='center'>
                                <button class='openModalBtn' data-id='" . $row['id'] . "' style='background:none; border: none; text-align: center; text-decoration: none; font-size: 12px; border-radius: 5px; cursor: pointer;'>
                                    <i class='bi bi-pencil-fill' style='color: #961b80;'></i> 
                                </button>
                            </td>
                            <td align='center'>
                                <a href='delete_paises.php?id=" . $row['id'] . "' style='color: #961b80; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 5px; cursor: pointer;'>X</a>
                            </td>
                        </tr>";
                    }
                }
                ?>              
            </tbody>                
        
        </table>
        </div>

        <!-- MODAL CADASTRAR -->
    <div class="modal-container" id="modal-cadastrar" style="display: none;">
        <div id="modal" class="modal">
            <form method="POST" action="insert_paises.php">
                <h2>Cadastre um novo país!</h2>
                <input type="hidden" name="id" id="pais-id">

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="pais-nome" required><br>

                <label for="continente">Continente</label>
                <input type="continente" name="continente" id="pais-continente" required><br>

                <label for="populacao">Populacao</label>
                <input type="populacao" name="populacao" id="pais-populacao" required><br>

                <label for="idioma">Idioma</label>
                <input type="idioma" name="idioma" id="pais-idioma" required><br>

                <button type="submit" style="background-color: #961b80; color: white; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">Salvar</button>

                <button type="button" class="closeModalBtn" style="color: rgb(57, 57, 226) ;background: none; border: none; cursor: pointer; color: inherit; font: inherit;">
                    Voltar
                </button>
            </form>
        </div>
    </div>

        <!-- MODAL ALTERAR -->
    <div class="modal-container" id="modal-editar" style="display: none;">
        <div id="modal" class="modal">
            <form method="POST" action="update_paises.php">
                <h2>Altere os dados necessários!</h2>
                <input type="hidden" name="id" id="editar-id">

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="editar-nome" required><br>

                <label for="continente">Continente</label>
                <input type="continente" name="continente" id="editar-continente" required><br>

                <label for="populacao">Populacao</label>
                <input type="populacao" name="populacao" id="editar-populacao" required><br>

                <label for="idioma">Idioma</label>
                <input type="idioma" name="idioma" id="editar-idioma" required><br>

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
                var paisId = $(this).data('id');

                $.ajax({
                    url: 'update_paises.php',
                    type: 'GET',
                    data: { id: paisId },
                    dataType: 'json',
                    success: function (pais){
                        $('#editar-id').val(pais.id);
                        $('#editar-nome').val(pais.nome);
                        $('#editar-continente').val(pais.continente);
                        $('#editar-populacao').val(pais.populacao);
                        $('#editar-idioma').val(pais.idioma);
                        $('#modal-editar').show();
                    },
                    error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:", status, error);
                    alert("Ocorreu um erro ao buscar os dados do país.");
                }
                });
            });

            // Abrir modal de cadastro 
            $('.openCadastrarBtn').on('click', function () {
                $('#cadastro-id').val('');
                $('#cadastro-nome').val('');
                $('#cadastro-continente').val('');
                $('#cadastro-populacao').val('');
                $('#cadastro-idioma').val('');
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