<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ACME Digital</title>
  <link rel="stylesheet" href="assets/css/style.css">
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

  <!-- SweetAlert2 via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      <?php if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo'])): ?>
        Swal.fire({
          title: "<?php echo addslashes($_SESSION['mensagem']); ?>",
          icon: "<?php echo $_SESSION['tipo']; ?>",
          confirmButtonColor: "#00bf63",
          timer: 3000,
          timerProgressBar: true
        });
        <?php unset($_SESSION['mensagem'], $_SESSION['tipo']); ?>
      <?php endif; ?>
    });
  </script>
</body>
</html>
