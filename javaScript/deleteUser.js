const deleteForm = document.getElementById('deleteForm');
if (deleteForm) deleteForm.addEventListener('submit', deleteUser);

async function deleteUser(event) {
  event.preventDefault();

  const form = document.getElementById('deleteForm');
  const formData = new FormData(form);
  formData.set('accion', 'delete');

  try {
    const res = await fetch('../api/delete.php', {
      method: 'POST',
      body: formData,
      credentials: 'include'
    });

    const data = await res.json();
    console.log(data); // para depuración

    if (data.success) {
      alert(data.message || 'Usuario eliminado correctamente.');
      // Si borras el usuario, vuelve al login
      window.location.href = 'login.php';
    } else {
      alert(data.message || 'No se pudo eliminar el usuario.');
    }
  } catch (err) {
    console.error(err);
    alert('Error de conexión con el servidor.');
  }
}