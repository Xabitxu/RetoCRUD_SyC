<?php
session_start();
require_once __DIR__ . '/../Model/User.php';

header('Content-Type: application/json');

$userModel = new User();

try {
    // Comprobar acción
    $action = $_POST['accion'] ?? null;

    if ($action !== 'delete') {
        echo json_encode([
            'success' => false,
            'message' => 'Acción no válida.'
        ]);
        exit;
    }

    $email = $_POST['email'] ?? null;
    $username = $_POST['username'] ?? null;

    if (!$email) {
        echo json_encode([
            'success' => false,
            'message' => 'Email del usuario no proporcionado.'
        ]);
        exit;
    }

    $data = [
        'email' => $email,
        'username' => $username
    ];

    $deleted = $userModel->deleteUser($data);

    if ($deleted) {
        // cierra sesión si eliminas al usuario actual
        $currentUsername = $_SESSION['user']['username'] ?? null;
        $currentEmail = $_SESSION['user']['email'] ?? null;
        $isCurrentUser = (($username && $username === $currentUsername) || ($email && $email === $currentEmail));
        if ($isCurrentUser) {
            session_unset();
            session_destroy();
        }
        echo json_encode([
            'success' => true,
            'message' => 'Usuario eliminado correctamente.',
            'isCurrentUser' => $isCurrentUser
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo eliminar el usuario.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>