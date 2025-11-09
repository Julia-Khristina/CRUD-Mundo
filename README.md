<div align="center">
  <h1 style="font-size: 36px; font-weight: bold;">CRUD Mundo - Programação Web</h1>
</div><br>

<img src="https://blog.advise.com.br/wp-content/uploads/2019/09/VUCA.png" alt="Descrição da Imagem"/><br><br>

## Autora: Julia Khristina

## 🌍 Descrição do Projeto

O **CRUD Mundo** é uma aplicação web desenvolvida com foco no gerenciamento de dados geográficos, especialmente países e cidades ao redor do mundo. O sistema foi projetado para permitir ao administrador cadastrar, consultar, editar e excluir países e cidades, mantendo a integridade das informações no banco de dados MySQL.

Para o usuário comum que deseja consultar as informações disponíveis no sistema, basta acessar a página principal. Nela, haverá um campo de busca com preenchimento automático, permitindo localizar rapidamente qualquer país cadastrado. Ao selecionar um país, o usuário será redirecionado para uma página com todos os detalhes. Essas informações são apresentadas a partir da combinação dos dados armazenados no banco de dados e dos dados obtidos por meio das APIs utilizadas. <br>

## Tecnologias Utilizadas:
- HTML
- CSS
- JavaScript
- PHP
- MySQL
- APIs REST Countries e OpenWeatherMap

## 📋 Funcionalidades

### 🌎 **Gerenciamento de Países**
- **Ações**: Cadastro, listagem, edição e exclusão
- Cada país apresenta como atributos: ID, nome, continente, população e idioma.

### 🏙️ **Gerenciamento de Cidades**
- **Ações**: Cadastro, listagem, edição e exclusão
- Cada cidade apresenta como atributos: ID, nome, população, país (ID do país).

### 🖥️ **Dados do usuário administrativo**
- Permite a entrada no sistema que apresenta as ações CRUD.
- Apresenta como atributos: ID, nome, email, senha.

### 💻 **Interface Web (Front End)**
- **HTML** para garantir uma estrutura de página adequada.
- **CSS** para o design, garantindo boa usabilidade.
- **JavaScript** para validação de formulários e confirmação do sistema CRUD.

### 🖥️ **Camada Back End (PHP + MySQL)**
- Scripts PHP responsáveis por realizar a comunicação com o banco de dados.
- Consultas SQL para implementar as operações **CRUD**:
  - **Create**: Inserir dados.
  - **Read**: Listar dados.
  - **Update**: Atualizar dados.
  - **Delete**: Excluir dados.
- Garantir a integridade referencial, com as cidades associadas aos países corretamente. 

### 🖥️ **Banco de Dados MySQL**:
   - Banco de dados com nome `bd_mundo`.
   - Tabelas `Paises`, `Cidades`, `Usuário` conforme descrito acima.

### 🖥️ **Utilização de API´s**:
  - REST Countries para fornecer informações complementares sobre países, como: bandeira, moeda e capital
  - OpenWeatherMap para exibir informações climáticas em tempo real de uma cidade cadastrada. <br><br>


##  📥 Como Baixar e Executar o Projeto

**Siga o passo a passo abaixo para instalar e executar o projeto CRUD Mundo em sua máquina local.**

### 🚀 1. Baixar o Projeto

- Acesse o repositório no GitHub.
- Clique no botão Code.
- Selecione Download ZIP.
- Extraia a pasta do projeto no seu computador. <br>

### 🗄️ 2. Importar o Banco de Dados

- Acesse o phpMyAdmin pelo navegador: **http://localhost/phpmyadmin/**
- Clique em Importar no menu superior.
- Clique em Escolher arquivo.
- Selecione o arquivo: bd_mundo.sql
- Confirme clicando em Importar.
- Isso criará automaticamente o banco bd_mundo e as tabelas: paises, cidades e usuário <br>

### 🔧 3. Configurar a Conexão com o Banco de Dados

- Abra o arquivo: **CRUD-Mundp/Programação WEB/conexao.php**
- E ajuste as credenciais conforme seu ambiente:

  $servername = "localhost"; <br>
  $database = "bd_mundo"; // nome do banco <br>
  $username = "root"; // usuário do MySQL <br>
  $password = ""; // senha do MySQL (geralmente vazia no XAMPP)<br>

### 💻 4. Iniciar o Servidor Local

Usando XAMPP:

- Abra o XAMPP Control Panel.
- Inicie os serviços Apache e MySQL.
- Coloque a pasta do projeto dentro de: **C:/xampp/htdocs/** <br>

### 🌐 5. Acessar o Sistema no Navegador

- Com o servidor rodando, acesse: **http://localhost/crud-mundo/**
- A aplicação será exibida e todos os recursos do CRUD estarão disponíveis.

### 🌐 6. Testar as Funcionalidades

- Criar, listar, editar e excluir países <br>
- Criar, listar, editar e excluir cidades vinculadas a países <br>
- Ver dados adicionais da API REST Countries na página do usuário comum <br>
- Ver dados climáticos em tempo real da OpenWeatherMap <br>
