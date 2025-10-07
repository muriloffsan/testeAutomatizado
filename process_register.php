<?php
session_start();
include "conexao.php";

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($email) || empty($senha)) {
    $_SESSION['mensagem'] = 'Preencha todos os campos!';
    $_SESSION['tipo'] = 'warning';
    header('Location: cadastro.php');
    exit;
}

if (preg_match('/<[^>]*script|onerror|onload|javascript:/i', $email) || preg_match('/<[^>]*script|onerror|onload|javascript:/i', $senha)) {
    $_SESSION['mensagem'] = 'Input inválido detectado.';
    $_SESSION['tipo'] = 'error';
    header('Location: cadastro.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    $_SESSION['mensagem'] = 'E-mail já cadastrado!';
    $_SESSION['tipo'] = 'warning';
} else {
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $insert = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $insert->execute([$email, $hash]);
    $_SESSION['mensagem'] = 'Cadastro realizado com sucesso!';
    $_SESSION['tipo'] = 'success';
}
header('Location: cadastro.php');
exit;
