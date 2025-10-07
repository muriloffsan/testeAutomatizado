<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - ACME Digital</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/sweetalert2.all.min.js"></script>
</head>
<body>
  <div class="container">
    <h2>Criar Conta</h2>
    <form action="process_register.php" method="POST">
      <input type="email" name="email" id="email" placeholder="E-mail" required>
      <input type="password" name="senha" id="senha" placeholder="Senha" required>
      <button type="submit" id="btn-cadastro">Cadastrar</button>
    </form>
    <p>Já possui conta? <a href="index.php">Entrar</a></p>
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
