// Poblar el combobox y actualizar los campos al seleccionar usuario
document.addEventListener('DOMContentLoaded', async () => {
  const select = document.getElementById('role');
  if (!select) return;
  try {
    const res = await fetch('../api/get_users.php', { credentials: 'include' });
    if (!res.ok) throw new Error('No se pudo obtener usuarios');
    const data = await res.json();
    if (!data.users) return;
    // Limpiar y poblar el combobox
    select.innerHTML = '';
    data.users.forEach(user => {
      const option = document.createElement('option');
      option.value = user.username;
      option.textContent = user.username;
      select.appendChild(option);
    });
    // Seleccionar el usuario actual por defecto
    const loggedUsername = window.loggedUsername;
    if (loggedUsername) {
      select.value = loggedUsername;
      const user = data.users.find(u => u.username === loggedUsername);
      if (user) fillFields(user);
    } else if (data.users.length > 0) {
      fillFields(data.users[0]);
    }
    // Actualizar campos al cambiar selección
    select.addEventListener('change', () => {
      const selected = select.value;
      const user = data.users.find(u => u.username === selected);
      if (user) fillFields(user);
    });
  } catch (err) {
    console.error('Error al cargar usuarios:', err);
  }
});

function fillFields(user) {
  document.getElementById('username').value = user.username || '';
  document.getElementById('email').value = user.email || '';
  if (document.getElementById('telephone')) {
    document.getElementById('telephone').value = user.telephone || '';
  }
}