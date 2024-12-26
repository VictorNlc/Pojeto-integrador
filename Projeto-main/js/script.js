const loginForm = document.getElementById('login__username').parentElement.parentElement; // Seleciona o formulário

loginForm.addEventListener('submit', (event) => {
  event.preventDefault(); // Impede o envio padrão do formulário

  const username = document.getElementById('login_username').value;
  const password = document.getElementById('login_password').value;

  // Validação (substitua por uma validação mais robusta)
  if (username === '' || password === '') {
    alert('Por favor, preencha todos os campos.');
  } else if (!validateEmail(username)) {
    alert('Digite um e-mail válido.');
  } else if (password.length < 6) {
    alert('A senha deve ter no mínimo 6 caracteres.');
  } else {
    // Simulação de envio (substitua por lógica de autenticação real)
    alert('Dados enviados com sucesso! (Simulação)');
  }
});