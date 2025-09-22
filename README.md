# CRUD Mundo - Programação Web

---

## 🌍 Descrição do Projeto

O **CRUD Mundo** é uma aplicação web completa desenvolvida com foco no gerenciamento de dados geográficos, especialmente países e cidades ao redor do mundo. O sistema foi projetado para permitir aos usuários cadastrar, consultar, editar e excluir países e cidades, mantendo a integridade referencial no banco de dados MySQL.

A aplicação é dividida entre o **Back End**, desenvolvido em **PHP**, e o **Front End**, utilizando **HTML5**, **CSS3** e **JavaScript**. O objetivo é criar uma interface amigável, responsiva e eficiente para gerenciar os dados de países e cidades de maneira simples e intuitiva.

---

## 📋 Funcionalidades

### 🌎 **Gerenciamento de Países**
- **Cadastrar Países**: Adicionar um novo país ao sistema.
- **Listar Países**: Exibir todos os países cadastrados.
- **Editar Países**: Modificar as informações de um país existente.
- **Excluir Países**: Remover um país do sistema.

Cada país deve conter os seguintes dados:
- ID
- Nome oficial
- Continente
- População
- Idioma principal

---

### 🏙️ **Gerenciamento de Cidades**
- **Cadastrar Cidades**: Adicionar uma cidade associada a um país.
- **Listar Cidades**: Exibir todas as cidades cadastradas.
- **Editar Cidades**: Alterar as informações de uma cidade existente.
- **Excluir Cidades**: Remover uma cidade do sistema.

Cada cidade deve conter os seguintes dados:
- ID
- Nome da cidade
- População
- País (referência ao país)

---

### 💻 **Interface Web (Front End)**
- **HTML5** semântico para garantir uma estrutura de página adequada.
- **CSS3** para design responsivo, garantindo boa usabilidade em dispositivos móveis.
- **JavaScript** para interações dinâmicas, como validação de formulários e confirmação de exclusões.

---

### 🖥️ **Camada Back End (PHP + MySQL)**
- Scripts PHP responsáveis por realizar a comunicação com o banco de dados.
- Consultas SQL para implementar as operações **CRUD**:
  - **Create**: Inserir dados.
  - **Read**: Listar dados.
  - **Update**: Atualizar dados.
  - **Delete**: Excluir dados.
- Garantir a integridade referencial, com as cidades associadas aos países corretamente.

## ⚙️ Requisitos Funcionais

1. **Gerenciamento de Países**:
   - Inserir, listar, editar e excluir países.
   - Cada país deve conter ao menos: ID, nome, continente, população e idioma.
   
2. **Gerenciamento de Cidades**:
   - Inserir, listar, editar e excluir cidades associadas a um país existente.
   - Cada cidade deve conter ao menos: ID, nome, população, país (ID do país).

3. **Interface Web (Front End)**:
   - Criação de páginas semânticas com **HTML5**.
   - Uso de **CSS3** para uma interface responsiva.
   - Interações dinâmicas com **JavaScript** (validação de formulários, confirmação de exclusões).

4. **Camada Back End (PHP + MySQL)**:
   - Scripts PHP que realizam a comunicação com o banco de dados.
   - Operações de CRUD implementadas com consultas SQL.

5. **Banco de Dados MySQL**:
   - Banco de dados com nome `bd_mundo`.
   - Tabelas `Paises` e `Cidades` conforme descrito acima.
```bash
git clone https://github.com/seu-usuario/crud-mundo.git
