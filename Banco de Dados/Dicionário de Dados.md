# 🌎 Dicionário de Dados — Banco de Dados `crud_mundo`

O banco de dados **`crud_mundo`** gerencia informações geográficas, abrangendo **países** e **cidades**, além de dados sobre o **usuário** do sistema. 

---

## 🧭 Visão Geral da Estrutura

O banco é composto por três tabelas principais:

| Tabela | Descrição | Relação |
| :--- | :--- | :--- |
| **`Paises`** | Informações gerais sobre os países. | 1:N com `Cidades` |
| **`Cidades`** | Dados das cidades vinculadas aos países. | N:1 com `Paises` |
| **`Usuario`** | Registro de usuários do sistema. | Independente |

---

## 🌍 Tabela: `Paises`

| Campo | Tipo de Dado | Chave | Descrição |
| :--- | :--- | :--- | :--- |
| **`id`** | `INT` | **PK, AI** | Identificador único do país. |
| **`nome`** | `VARCHAR(100)` | | Nome oficial do país. |
| **`continente`** | `ENUM` | | Continente. Valores: "América", "Europa", "África", "Ásia", "Oceania". |
| **`populacao`** | `INT` | | Quantidade total de habitantes. |
| **`idioma`** | `VARCHAR(50)` | | Idioma principal do país. |

---

## 🏙️ Tabela: `Cidades`

| Campo | Tipo de Dado | Chave | Descrição |
| :--- | :--- | :--- | :--- |
| **`id`** | `INT` | **PK, AI** | Identificador único da cidade. |
| **`nome`** | `VARCHAR(100)` | | Nome da cidade. |
| **`populacao`** | `INT` | | Quantidade de habitantes da cidade. |
| **`pais`** | `INT` | **FK** | Chave estrangeira para `Paises(id)`. |

---

## 👤 Tabela: `Usuario`

| Campo | Tipo de Dado | Chave | Descrição |
| :--- | :--- | :--- | :--- |
| **`id`** | `INT` | **PK, AI** | Identificador único do usuário. |
| **`nome`** | `VARCHAR(100)` | | Nome completo do usuário. |
| **`email`** | `VARCHAR(100)` | | E-mail utilizado para login. |
| **`senha`** | `VARCHAR(255)` | | Senha criptografada do usuário. |

---

## 🔗 Detalhes dos Relacionamentos

A relação principal é **1:N** entre `Paises` e `Cidades`.

| Tabela Principal | Campo FK | Tabela Relacionada | Tipo de Relação |
| :--- | :--- | :--- | :--- |
| `Paises` | `Cidades.pais` | `Cidades` | 1:N |
| `Usuario` | N/A | N/A | Independente |

