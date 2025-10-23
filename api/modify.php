<?php
session_start();
require_once __DIR__ . '/../Model/User.php';

$action = $_POST['accion'] ?? null;
$userModel = new User();

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

try {
    if ($action === 'modify') {    

        $email = $_POST['email'] ?? '';
        $username = $_SESSION['user']['USERNAME'] ?? null; // El usuario logueado
        $telephone = $_POST['telephone'] ?? '';
        $newPassword = $_POST['password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';


        if ($newPassword !== $confirmPass) {
            $_SESSION['flash'] = 'Las contraseñas no son iguales';
            redirect('../View/modify.php');
        }

        if (!preg_match('/^[0-9]{9}$/', $telephone)) {
            $_SESSION['flash'] = 'Teléfono inválido. Debe tener 9 dígitos.';
            redirect('../View/modify.php');
        }

        $data = [
            'email' => $email,
            'username' => $username,
            'telephone' => $telephone,
            'password' => $newPassword
        ];

        $modified = $userModel->modifyUser($data);

            if ($modified) {
                $_SESSION['flash'] = 'Usuario modificado correctamente.';
            // Actualiza la sesión
            $_SESSION['user']['EMAIL'] = $email;
            $_SESSION['user']['TELEPHONE'] = $telephone;
            redirect('../View/menu.php');
            } else {
                $_SESSION['flash'] = 'No se pudo modificar el usuario.';
                redirect('../View/modify.php');
            }
    } else {
        redirect('../View/menu.php');
    }
} catch (Exception $e) {
    $_SESSION['flash'] = 'Error: ' . $e->getMessage();
    redirect('../View/menu.php');
}

?>