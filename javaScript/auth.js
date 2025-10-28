const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');

if (loginBtn) loginBtn.addEventListener('click', login);
if (signupBtn) signupBtn.addEventListener('click', signup);

// LOGIN
async function login(event) {
  event.preventDefault();

  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  const formData = new FormData();
  formData.append('accion', 'login');
  formData.append('email', email);
  formData.append('password', password);

  try {
    const res = await fetch('../api/auth.php', {
      method: 'POST',
      body: formData,
      credentials: 'include'
    });

    const data = await res.json();
    console.log(data);

    if (data.success) {
      window.location.href = 'menu.php';
    } else {
      alert(data.message);
    }
  } catch (err) {
    console.error(err);
    alert('Error de conexión con el servidor.');
  }
}

// SIGNUP
async function signup(event) {
  // Si no hay campos de signup (estamos en login.php), no impedimos la navegación
  if (!document.getElementById('username')) {
    return;
  }

  event.preventDefault();

  const formData = new FormData();
  formData.append('accion', 'signup');
  formData.append('username', document.getElementById('username').value);
  formData.append('email', document.getElementById('email').value);
  formData.append('password', document.getElementById('password').value);
  formData.append('confirm_pass', document.getElementById('confirm_pass').value);
  formData.append('name', document.getElementById('name').value);
  formData.append('surname', document.getElementById('surname').value);
  formData.append('telephone', document.getElementById('telephone').value);
  formData.append('card', document.getElementById('card').value);
  formData.append('gender', document.getElementById('gender').value);

  try {
    const res = await fetch('../api/auth.php', {
      method: 'POST',
      body: formData,
      credentials: 'include'
    });

    const data = await res.json();
    console.log(data);

    if (data.success) {
      window.location.href = 'menu.php';
    } else {
      alert(data.message);
    }
  } catch (err) {
    console.error(err);
    alert('Error de conexión con el servidor.');
  }
}