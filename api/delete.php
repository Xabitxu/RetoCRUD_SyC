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
    if ($action === 'delete') {    

        $email = $_POST['email']['EMAIL'] ?? null;
        $username = $_SESSION['user']['USERNAME'] ?? null; 

        

        $data = [
            'email' => $email,
            'username' => $username,
        ];

        $deleted = $userModel->deleteUser($data);

            if ($deleted) {
                $_SESSION['flash'] = 'Usuario eliminado correctamente.';
            
            redirect('../View/menu.php');
            } else {
                $_SESSION['flash'] = 'No se pudo eliminar el usuario.';
                redirect('../View/delete.php');
            }
    } else {
        redirect('../View/menu.php');
    }
} catch (Exception $e) {
    $_SESSION['flash'] = 'Error: ' . $e->getMessage();
    redirect('../View/menu.php');
}

?>