<?php
session_start();
include '../conexao.php'; 

$feedback_mensagem = $_SESSION['feedback_mensagem'] ?? null;
$feedback_tipo = $_SESSION['feedback_tipo'] ?? null;

unset($_SESSION['feedback_mensagem']);
unset($_SESSION['feedback_tipo']);

$sql_paises = "SELECT id, nome FROM Paises ORDER BY nome ASC";
$result_paises = $conexao->query($sql_paises);

$sql_cidades = "
    SELECT 
        C.id AS id_cidade, 
        C.nome AS nome_cidade, 
        C.populacao AS populacao_cidade, 
        P.nome AS nome_pais  
    FROM 
        Cidades C
    INNER JOIN 
        Paises P ON C.pais = P.id  
    ORDER BY 
        C.id ASC
";

$result_cidades = $conexao->query($sql_cidades);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--CSS do Select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle" style="display: flex; align-items: center; justify-content: space-between;">

            <i class="bi bi-list" id="header-toggle" style="font-size: 1.5rem; color: #961b80;"></i>
    
            <div style="display: flex; align-items: center; margin-left: 1rem;">
                <p style="margin: 0; font-size: 1.2rem; color: #000000;">Cidades</p>
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
                    <a href="paises.php" class="nav_link">
                        <i class="bi bi-globe2"></i>
                        <span class="nav_name">Países</span>
                    </a>
                    <a href="cidades.php" class="nav_link active">
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
        <h3 style='color:rgb(255, 255, 255);'>Cadastrar cidade</h3> <!-- Cor personalizada aqui -->
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
                    <td class="top center"><strong>Populacao </strong></td>
                    <td class="top center"><strong>País</strong></td>
                    <td class="top center" colspan="2" width="1"><strong>Ações</strong></td>
                </tr>
            </tbody>

            <tbody>

            <?php
                if($result_cidades->num_rows > 0){
                    while($row = $result_cidades->fetch_assoc()){
                        echo "<tr>
                            <td align='center'>" . $row['id_cidade'] . "</td>
                            <td align='center'>" . htmlspecialchars($row['nome_cidade']) . "</td>
                            <td align='center'>" . htmlspecialchars($row['populacao_cidade']) . "</td>
                            <td align='center'><strong>" . htmlspecialchars($row['nome_pais']) . "</strong></td> <!-- <--- AGORA ESTÁ CORRETO! -->
                            <td align='center'>
                                <button class='openModalBtn' data-id='" . $row['id_cidade'] . "' style='background:none; border: none; text-align: center; text-decoration: none; font-size: 12px; border-radius: 5px; cursor: pointer;'>
                                    <i class='bi bi-pencil-fill' style='color: #961b80;'></i>
                                </button>
                            </td>
                            <td align='center'>
                                <a href='delete_cidades.php?id=" . $row['id_cidade'] . "' style='color: #961b80; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 5px; cursor: pointer;'>X</a>
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
                <form method="POST" action="insert_cidades.php">
                    <h2>Cadastre uma nova cidade!</h2>
                    <input type="hidden" name="id" id="pais-id">

                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="cidade-nome" required><br>

                    <label for="populacao">População:</label>
                    <input type="populacao" name="populacao" id="cidade-populacao" required><br>

                    <label for="pais">País:</label><br>
                    <div class="autocomplete-container">
                        <input type="text" id="cidade-pais-input" class="autocomplete-input" placeholder="Digite o nome do País" required>
                        <input type="hidden" name="pais" id="cidade-pais-id">
                        <div id="cidade-pais-list" class="autocomplete-items">
                        </div>
                    </div>
                    <br><br>

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
                <form method="POST" action="update_cidades.php">
                    <h2>Altere os dados necessários!</h2>
                    <input type="hidden" name="id" id="editar-id">

                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="editar-nome" required><br>

                    <label for="populacao">População:</label>
                    <input type="populacao" name="populacao" id="editar-populacao" required><br>

                    <label for="pais">País:</label><br>
                    <div class="autocomplete-container">
                        <input type="text" id="editar-pais-input" class="autocomplete-input" placeholder="Digite o nome do País" required>
                        <input type="hidden" name="pais" id="editar-pais-id">
                        <div id="editar-pais-list" class="autocomplete-items">
                        </div>
                    </div>
                    <br> 
                    <br>

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

            $('#cidade-pais').select2({
                placeholder: "Selecione ou digite o nome do País",
                allowClear: true,
                width: '100%'
            });

            $('#cidade-pais').on('select2:open', function() {
                setTimeout(function() {
                     $('.select2-dropdown').find('.select2-search__field').focus();
                }, 100);
            });

            $('#editar-pais').select2({
                placeholder: "Selecione ou digite o nome do País",
                allowClear: true
            });

            $('.openModalBtn').on('click', function () {
                var cidadeId = $(this).data('id');

            $.ajax({
                    url: 'update_cidades.php',
                    type: 'GET',
                    data: { id: cidadeId },
                    dataType: 'json',
                    success: function (cidade){
                        $('#editar-id').val(cidade.id);
                        $('#editar-nome').val(cidade.nome);
                        $('#editar-populacao').val(cidade.populacao);
                        $('#editar-pais-input').val(cidade.pais_nome); 
                        $('#editar-pais-id').val(cidade.pais_id); 
                        $('#modal-editar').show();
                    },
                    error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:", status, error);
                    alert("Ocorreu um erro ao buscar os dados do país.");
                }
                });
            });

            // Abrir modal de cadastro (sem AJAX)
            $('.openCadastrarBtn').on('click', function () {
                $('#cadastro-id').val('');
                $('#cadastro-nome').val('');
                $('#cadastro-populacao').val('');
                $('#cadastro-pais').val('');
                $('#modal-cadastrar').show();
            });

            // Fechar ambos os modais
            $('.closeModalBtn').on('click', function () {
                $(this).closest('.modal-container').hide();
            });

            // Impede números no campo de nome
            document.querySelectorAll('input[name="nome"], #editar-nome').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
                });
            });

            document.querySelectorAll('input[name="populacao"], #editar-populacao').forEach(input => {
                input.addEventListener('input', function() {
                    // Remove tudo que não for número
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Impede começar com zero se tiver mais de 1 número
                    if (this.value.length > 1 && this.value.startsWith('0')) {
                    this.value = this.value.replace(/^0+/, '');
                    }
                });
            });

            document.querySelectorAll('#editar-pais-input, #cidade-pais-input').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
                });

                input.addEventListener('paste', function(e) {
                    const texto = (e.clipboardData || window.clipboardData).getData('text');
                    if (/[^A-Za-zÀ-ÿ\s]/.test(texto)) {
                    e.preventDefault();
                    }
                });
            });

        });
    </script>

    <script src="dashboard.js"></script>
    <script src="autocomplete-paises.js"></script>
</body>
</html>