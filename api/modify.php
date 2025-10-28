<?php
session_start();
require_once __DIR__ . '/../Model/User.php';

header('Content-Type: application/json');

$action = $_POST['accion'] ?? null;
$userModel = new User();

try {
    if ($action !== 'modify') {
        echo json_encode(['success' => false, 'message' => 'Acción no reconocida.']);
        exit;
    }

    // Recogemos campos
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? ($_SESSION['user']['username'] ?? null);
    $telephone = $_POST['telephone'] ?? '';
    $newPassword = $_POST['password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';

    // Validaciones
    if ($newPassword !== '' && $newPassword !== $confirmPass) {
        echo json_encode(['success' => false, 'message' => 'Las contraseñas no son iguales']);
        exit;
    }

    if (!preg_match('/^[0-9]{9}$/', $telephone)) {
        echo json_encode(['success' => false, 'message' => 'Teléfono inválido. Debe tener 9 dígitos.']);
        exit;
    }

    // Preparar datos para el modelo
    $data = [
        'email' => $email,
        'username' => $username,
        'telephone' => $telephone,
        'password' => $newPassword // modifyUser entiende password vacío como "no cambiado"
    ];

    $modified = $userModel->modifyUser($data);

    if ($modified) {
        // actualizar sesión para que la vista disponga de datos nuevos
        if (!empty($_SESSION['user'])) {
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['telephone'] = $telephone;
            // username normalmente no cambia; si cambias username, actualiza aquí también.
        }

        echo json_encode([
            'success' => true,
            'message' => 'Usuario modificado correctamente.',
            'user' => $_SESSION['user'] ?? null
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo modificar el usuario.']);
    }
    exit;
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    exit;
}
?>