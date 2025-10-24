document.getElementById('login').addEventListener('click', login);
document.getElementById('signup').addEventListener('click', signup);

async function login(event) {
  event.preventDefault();

  const formData = new FormData();
  formData.append('accion', 'login');
  formData.append('email', document.getElementById('email').value);
  formData.append('password', document.getElementById('password').value);

  try {
    const res = await fetch('../api/auth.php', {
      method: 'POST',
      body: formData,
      credentials: 'include'
    });

    const data = await res.json();
    console.log(data); // para depuración

    if (data.success) {
      window.location.href = 'menu.php'; // ruta relativa desde login.php
    } else {
      alert(data.message);
    }
  } catch (err) {
    console.error(err);
    alert('Error de conexión con el servidor.');
  }
}

async function signup(event) {
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