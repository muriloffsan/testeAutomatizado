<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - ACME Digital</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/sweetalert2.all.min.js"></script>
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form id="loginForm" action="process_login.php" method="POST">
      <input type="email" name="email" id="email" placeholder="E-mail" required>
      <input type="password" name="senha" id="senha" placeholder="Senha" required>
      <button type="submit" id="btn-login">Entrar</button>
    </form>
    <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
  </div>

  <div id="mensagem"></div>

  <?php if (isset($_SESSION['mensagem'])): ?>
    <script>
      Swal.fire({
        icon: '<?php echo $_SESSION["tipo"]; ?>',
        title: '<?php echo $_SESSION["mensagem"]; ?>',
        confirmButtonColor: "#3085d6",
      });
    </script>
    <?php unset($_SESSION['mensagem'], $_SESSION['tipo']); ?>
  <?php endif; ?>
</body>
</html>
