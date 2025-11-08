<?php 
session_start(); 
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Busca de Países</title>
  <link rel="stylesheet" href="./adm/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="./adm/img/frontImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Seja bem-vindo(a)!!!</span>
          <span class="text-2">Acesse sua conta para gerenciar os países e cidades cadastrados no sistema.</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Encontre maiores informações sobre o país desejado</div>
            
            <!-- O formulário agora aponta para a nova página de detalhes -->
            <form method="GET" action="detalhes_pais.php">
              <div class="input-boxes">
                  

                <!-- Container para o autocomplete -->
                <div class="autocomplete-container">
                  <div class="input-box">
                    <i class="fas fa-search"></i>
                    <!-- Input de texto visível para o usuário -->
                    <input type="text" id="main-search-input" placeholder="Digite o nome do país..." required autocomplete="off">
                  </div>
                  <!-- Input escondido para armazenar o ID do país selecionado -->
                  <input type="hidden" name="id" id="main-search-id">
                  
                  <!-- Container onde a lista de sugestões aparecerá -->
                  <div id="main-search-list" class="autocomplete-items"></div>
                </div>
                  

                <div class="button input-box">
                    <!-- O botão agora é do tipo submit para enviar o formulário -->
                    <input type="submit" value="Buscar País">
                </div>
              </div>
            </form>

          </div>
        </div>
    </div>
  </div>

  <script src="adm/autocomplete-paises.js"></script>
  <script>
    // Inicializa o autocomplete 
    document.addEventListener('DOMContentLoaded', (event) => {
        setupAutocomplete(
            "main-search-input", // ID do input de texto
            "main-search-list", // ID do container da lista
            "main-search-id",  // ID do input hidden para o ID do País
            "adm/autocomplete-paises.php" // Endpoint PHP que buscará os dados
        );
    });
  </script>
</body>
</html>
