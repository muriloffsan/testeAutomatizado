<?php
session_start();
include "conexao.php";

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

function possuiXSS($str) {
    return preg_match('/<[^>]*script|onerror|onload|javascript:/i', $str);
}

if (empty($email) || empty($senha)) {
    $_SESSION['mensagem'] = 'Preencha todos os campos!';
    $_SESSION['tipo'] = 'warning';
    header('Location: index.php');
    exit;
}

if (possuiXSS($email) || possuiXSS($senha)) {
    $_SESSION['mensagem'] = 'Input inválido detectado.';
    $_SESSION['tipo'] = 'error';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['mensagem'] = 'Login realizado com sucesso!';
    $_SESSION['tipo'] = 'success';
    header('Location: dashboard.php');
} else {
    $_SESSION['mensagem'] = 'Credenciais inválidas.';
    $_SESSION['tipo'] = 'error';
    header('Location: index.php');
}
exit;
