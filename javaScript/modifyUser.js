const modifyForm = document.getElementById('modifyForm');
if (modifyForm) modifyForm.addEventListener('submit', modifyUser);

async function modifyUser(event) {
  event.preventDefault();

  const form = document.getElementById('modifyForm');
  const formData = new FormData(form);
  formData.set('accion', 'modify');

  try {
    const apiUrl = new URL('../api/modify.php', location.href).href;
    console.log('Enviar petición a:', apiUrl);

    const res = await fetch(apiUrl, {
      method: 'POST',
      body: formData,
      credentials: 'include'
    });

    if (!res.ok) {
      console.error('Respuesta HTTP no OK', res.status, res.statusText);
      alert('Error al conectar con la API: ' + res.status);
      return;
    }

    const data = await res.json();
    console.log(data); // para depuración

    if (data.success) {
      window.location.href = 'menu.php';
    } else {
      alert(data.message || 'No se pudo modificar el usuario.');
    }
  } catch (err) {
    console.error(err);
    alert('Error de conexión con el servidor.');
  }
}