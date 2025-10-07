README.md — Projeto Login & Cadastro ACME Digital

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

  Instalação

Clone o projeto

git clone <url-do-repositorio>


Configurar o Banco de Dados

O banco estará na raiz do projeto, nomeie o arquivo como banco.sql.

Importe no MySQL:

mysql -u root -p < banco.sql


Ou pelo phpMyAdmin importando banco.sql.

Conteúdo do banco.sql
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

Configurar conexão

Edite conexao.php se necessário com seu usuário e senha MySQL.

<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=acme_digital;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

  Executando o Projeto

Abra no navegador:

http://localhost/testeAutomatizado/index.php


Você poderá:

Fazer login

Fazer cadastro

Ver mensagens via SweetAlert2

  Testes Automatizados com Selenium WebDriver
Instalação
npm install selenium-webdriver

Executando Testes
node testeAutomatizado.js


Após execução:

Prints estarão em assets/screenshots/

Relatório estará em relatorio.json

Exemplo do testeAutomatizado.js
const { Builder, By, until } = require("selenium-webdriver");
const fs = require("fs");
const path = require("path");

let relatorio = [];
const TARGET_URL = "http://localhost/testeAutomatizado/index.php";
const SCREENSHOT_DIR = path.join(__dirname, "assets", "screenshots");
const TIMEOUT_MS = 5000;

fs.mkdirSync(SCREENSHOT_DIR, { recursive: true });

function salvarScreenshot(base64, nomeArquivo) {
	const filePath = path.join(SCREENSHOT_DIR, nomeArquivo);
	fs.writeFileSync(filePath, base64, "base64");
	return filePath;
}

async function testarLogin(email, senha, descricao) {
	let driver = await new Builder().forBrowser("chrome").build();
	let status = "pass";
	try {
		console.log(`\nTestando: ${descricao}`);
		await driver.get(TARGET_URL);

		await driver.wait(until.elementLocated(By.id("email")), TIMEOUT_MS);
		await driver.findElement(By.id("email")).clear();
		await driver.findElement(By.id("email")).sendKeys(email);

		await driver.wait(until.elementLocated(By.id("senha")), TIMEOUT_MS);
		await driver.findElement(By.id("senha")).clear();
		await driver.findElement(By.id("senha")).sendKeys(senha);

		await driver.wait(until.elementLocated(By.id("btn-login")), TIMEOUT_MS);
		await driver.findElement(By.id("btn-login")).click();

		await driver.sleep(2000);

		const base64 = await driver.takeScreenshot();
		const safeName = descricao.replace(/\s+/g, "_").replace(/[^a-zA-Z0-9_\-]/g, "");
		const screenshotName = `screenshot_${safeName}.png`;
		const savedPath = salvarScreenshot(base64, screenshotName);

		console.log(`Screenshot salva em: ${savedPath}`);
		relatorio.push({ teste: descricao, status, screenshot: savedPath });
	} catch (err) {
		status = "fail";
		console.error(`Erro no teste '${descricao}':`, err.message);

		try {
			const safeName = descricao.replace(/\s+/g, "_").replace(/[^a-zA-Z0-9_\-]/g, "");
			const screenshotName = `screenshot_erro_${safeName}.png`;
			const base64 = await driver.takeScreenshot();
			const savedPath = salvarScreenshot(base64, screenshotName);
			relatorio.push({ teste: descricao, status, screenshot: savedPath });
		} catch (e) {
			relatorio.push({ teste: descricao, status, screenshot: null });
		}
	} finally {
		await driver.quit();
	}
}

async function testarCadastro(email, senha, descricao) {
	let driver = await new Builder().forBrowser("chrome").build();
	let status = "pass";
	try {
		console.log(`\nTestando: ${descricao}`);
		await driver.get(TARGET_URL.replace("index.php", "cadastro.php"));

		await driver.wait(until.elementLocated(By.id("email")), TIMEOUT_MS);
		await driver.findElement(By.id("email")).clear();
		await driver.findElement(By.id("email")).sendKeys(email);

		await driver.wait(until.elementLocated(By.id("senha")), TIMEOUT_MS);
		await driver.findElement(By.id("senha")).clear();
		await driver.findElement(By.id("senha")).sendKeys(senha);

		await driver.wait(until.elementLocated(By.id("btn-cadastro")), TIMEOUT_MS);
		await driver.findElement(By.id("btn-cadastro")).click();

		await driver.sleep(2000);

		const base64 = await driver.takeScreenshot();
		const safeName = descricao.replace(/\s+/g, "_").replace(/[^a-zA-Z0-9_\-]/g, "");
		const screenshotName = `screenshot_${safeName}.png`;
		const savedPath = salvarScreenshot(base64, screenshotName);

		console.log(`Screenshot salva em: ${savedPath}`);
		relatorio.push({ teste: descricao, status, screenshot: savedPath });
	} catch (err) {
		status = "fail";
		console.error(`Erro no teste '${descricao}':`, err.message);

		try {
			const safeName = descricao.replace(/\s+/g, "_").replace(/[^a-zA-Z0-9_\-]/g, "");
			const screenshotName = `screenshot_erro_${safeName}.png`;
			const base64 = await driver.takeScreenshot();
			const savedPath = salvarScreenshot(base64, screenshotName);
			relatorio.push({ teste: descricao, status, screenshot: savedPath });
		} catch (e) {
			relatorio.push({ teste: descricao, status, screenshot: null });
		}
	} finally {
		await driver.quit();
	}
}

const testesLogin = [
	{ email: "admin@teste.com", senha: "1234", descricao: "Login correto" },
	{ email: "admin@teste.com", senha: "errada", descricao: "Senha incorreta" },
	{ email: "", senha: "1234", descricao: "Campo email vazio" },
	{ email: "admin@teste.com", senha: "", descricao: "Campo senha vazio" },
	{ email: "<script>", senha: "1234", descricao: "Tentativa de XSS" }
];

const testesCadastro = [
	{ email: "novo@teste.com", senha: "1234", descricao: "Cadastro novo usuário" },
	{ email: "admin@teste.com", senha: "1234", descricao: "Cadastro já existente" }
];

(async () => {
	for (let t of testesLogin) {
		await testarLogin(t.email, t.senha, t.descricao);
	}
	for (let t of testesCadastro) {
		await testarCadastro(t.email, t.senha, t.descricao);
	}
	fs.writeFileSync("relatorio.json", JSON.stringify(relatorio, null, 2));
	console.log("\nRelatório final salvo em relatorio.json");
})();

  Usando Selenium IDE
Instalação

Baixe no Chrome Web Store
.

Criando um Projeto

Abra Selenium IDE.

Crie novo projeto (Create a new project).

Nomeie e clique em criar.

Criando Testes

Login: gravar acesso em index.php preenchendo campos e clicando entrar.

Cadastro: gravar acesso em cadastro.php, preencher campos e cadastrar.

Executando Testes

Clique no teste → Run current test.

Exportando Testes

Em File → Export → selecione Node.js WebDriver.

Execute:

node nomeDoTeste.js