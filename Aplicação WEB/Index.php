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
      <img src="mundo.png" alt="">
    </div>
  </div>

  <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Encontre maiores informações sobre o país desejado</div>        
          <form method="GET" action="detalhes_pais.php">
            <div class="input-boxes">
              <div class="autocomplete-container">
                <div class="input-box">
                  <i class="fas fa-search"></i>
                  <input type="text" id="main-search-input" placeholder="Digite o nome do país..." required autocomplete="off">
                </div>
                <!-- armazena o ID do país selecionado -->
                <input type="hidden" name="id" id="main-search-id">
                
                <!-- lista de sugestões visível -->
                <div id="main-search-list" class="autocomplete-items"></div>
              </div>
              <div class="button input-box">
                  <input type="submit" value="Buscar País">
              </div>
            </div>
          </form>
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
