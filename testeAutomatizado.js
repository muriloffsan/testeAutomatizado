const { Builder, By, until } = require("selenium-webdriver");
const fs = require("fs");
const path = require("path");

let relatorio = [];
const TARGET_URL = "http://localhost/testeAutomatizado/index.php"; // Caminho corrigido
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

		await driver.sleep(2000); // Espera SweetAlert abrir

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

		await driver.sleep(2000); // Espera SweetAlert abrir

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
	if (!Array.isArray(testesLogin) || testesLogin.length === 0) {
		console.log("Nenhum teste de login configurado.");
		return;
	}

	for (let t of testesLogin) {
		await testarLogin(t.email, t.senha, t.descricao);
	}

	if (!Array.isArray(testesCadastro) || testesCadastro.length === 0) {
		console.log("Nenhum teste de cadastro configurado.");
		return;
	}

	for (let t of testesCadastro) {
		await testarCadastro(t.email, t.senha, t.descricao);
	}

	fs.writeFileSync("relatorio.json", JSON.stringify(relatorio, null, 2));
	console.log("\nRelatório final salvo em relatorio.json");
})();
