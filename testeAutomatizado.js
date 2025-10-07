const testes = [
  { email: "admin@teste.com", senha: "1234", descricao: "Login correto" },
  { email: "admin@teste.com", senha: "errada", descricao: "Senha incorreta" },
  { email: "", senha: "1234", descricao: "Campo email vazio" },
  { email: "admin@teste.com", senha: "", descricao: "Campo senha vazio" },
  { email: "<script>", senha: "1234", descricao: "Tentativa de XSS" },
];

