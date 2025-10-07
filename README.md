Este projeto implementa telas de login e cadastro com segurança, usabilidade e feedback visual via SweetAlert2. Também inclui testes automatizados com Selenium WebDriver.

📁 Estrutura do Projeto
testeAutomatizado/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── screenshots/
│
├── cadastro.php
├── conexao.php
├── index.php
├── process_login.php
├── process_register.php
├── testeAutomatizado.js
├── relatorio.json
├── README.md
└── acme_digital.sql

🛠 Instalação
1. Clonar o projeto
git clone <url-do-repositorio>

2. Configurar o Banco de Dados

O banco estará na raiz do projeto como acme_digital.sql.

Importar no MySQL:

mysql -u root -p < acme_digital.sql


Ou pelo phpMyAdmin importando acme_digital.sql.

Estrutura do acme_digital.sql
CREATE DATABASE acme_digital CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE acme_digital;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (email, senha) VALUES (
    'admin@teste.com',
    '$2y$10$7xqTj9qGj1qQe9F/r4h/OOZpF2HGBPeZ1sd7KQYfL5lY.9fS6zPq'
);


(senha: 1234)

3. Configurar Conexão

Edite conexao.php se necessário com seu usuário e senha MySQL:

<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=acme_digital;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

4. Instalar Dependências Node.js

Como a pasta node_modules não está inclusa, será necessário instalar as dependências.

Dentro da pasta do projeto:

npm install


Isso criará a pasta node_modules necessária para rodar os testes.

5. Rodar o Projeto

Abra no navegador:

http://localhost/testeAutomatizado/index.php


Você poderá:

Fazer login

Fazer cadastro

Ver mensagens via SweetAlert2

📦 Arquivo package.json

Inclua o arquivo package.json no projeto para facilitar instalação das dependências:

{
  "name": "teste-automatizado-acme",
  "version": "1.0.0",
  "description": "Testes automatizados com Selenium WebDriver",
  "main": "testeAutomatizado.js",
  "scripts": {
    "test": "node testeAutomatizado.js"
  },
  "author": "Seu Nome",
  "license": "MIT",
  "dependencies": {
    "selenium-webdriver": "^4.15.0"
  }
}


Com isso, basta rodar:

npm install
npm run test

🧪 Testes Automatizados com Selenium WebDriver
Instalação
npm install selenium-webdriver

Executando Testes
node testeAutomatizado.js


Após execução:

Prints estarão em assets/screenshots/

Relatório estará em relatorio.json

📜 Exemplo do testeAutomatizado.js

(Código completo já fornecido anteriormente, contendo funções de teste de login e cadastro com screenshots.)

🧰 Selenium IDE — Guia de Uso
Instalação

Baixe no Chrome Web Store
.

Criando um Projeto

Abra o Selenium IDE.

Clique em Create a new project.

Nomeie e clique em criar.

Criando Testes

Login: grave acesso em index.php preenchendo campos e clicando entrar.

Cadastro: grave acesso em cadastro.php, preenchendo campos e cadastrando.

Executando Testes

Clique no teste → Run current test.

Exportando Testes

Em File → Export → selecione Node.js WebDriver.

Execute:

node nomeDoTeste.js

📌 Observações

Certifique-se que o banco de dados foi importado antes de rodar os testes.

Certifique-se que o servidor PHP está ativo.

Certifique-se que o Node.js e npm estão instalados.

Se enviar sem node_modules, é obrigatório executar npm install antes de rodar os testes.
