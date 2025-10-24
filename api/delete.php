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

    // Comprobar usuario logueado
    if (empty($_SESSION['user'])) {
        echo json_encode([
            'success' => false,
            'message' => 'No has iniciado sesión.'
        ]);
        exit;
    }

    $email = $_POST['email'] ?? null;
    $username = $_SESSION['user']['username'] ?? null; 

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
        // Opcional: cerrar sesión si eliminaste al usuario actual
        if ($username === $_SESSION['user']['username']) {
            session_destroy();
        }

        echo json_encode([
            'success' => true,
            'message' => 'Usuario eliminado correctamente.'
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