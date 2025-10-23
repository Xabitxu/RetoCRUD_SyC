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
    if ($action === 'login') {
        $identifier = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $row = $userModel->getByIdentifier($identifier);
        if ($row && $row['PASSWORD_'] === $password) {
            $_SESSION['user'] = [
                'username' => $row['USERNAME'],
                'email' => $row['EMAIL'] ?? $row['USERNAME'] ?? $identifier,
                'role' => $row['role'] ?? 'user'
            ];
            redirect('../View/menu.php');
        } else {
            $_SESSION['flash'] = 'Credenciales inválidas';
            redirect('../View/login.php');
        }
    } elseif ($action === 'signup') {
        $email = $_POST['email'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_pass'] ?? '';
        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $card = $_POST['card'] ?? '';
        $gender = $_POST['gender'] ?? '';

        if ($password !== $confirm) {
            $_SESSION['flash'] = 'Las contraseñas no coinciden';
            redirect('../View/signUp.php');
        }

        if ($userModel->existsUsernameOrEmail($username, $email)) {
            $_SESSION['flash'] = 'Usuario o email ya existe';
            redirect('../View/signUp.php');
        }

        if (!preg_match('/^[0-9]{9}$/', $telephone)) {
            $_SESSION['flash'] = 'Teléfono inválido. Debe tener 9 dígitos.';
            redirect('../View/signUp.php');
        }
        if (!empty($card) && !preg_match('/^[A-Z]{2}[0-9]{22}$/', $card)) {
            $_SESSION['flash'] = 'Número de tarjeta inválido. Formato esperado: 2 letras mayúsculas seguido de 22 dígitos.';
            redirect('../View/signUp.php');
        }
        $allowedGenders = ['female','male','other'];
        if (!in_array($gender, $allowedGenders)) {
            $_SESSION['flash'] = 'Género inválido.';
            redirect('../View/signUp.php');
        }

        $data = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'telephone' => $telephone,
            'gender' => $gender,
            'card' => $card,
        ];
        try {
            $created = $userModel->createUser($data);
            if ($created) {
                // Log the user in automatically using the same method as login
                $row = $userModel->getByIdentifier($username ?? $email);
                if ($row) {
                    $_SESSION['user'] = [
                        'username' => $row['USERNAME'],
                        'email' => $row['EMAIL'] ?? $row['USERNAME'] ?? ($email ?? $username),
                        'role' => $row['role'] ?? 'user'
                    ];
                    redirect('../View/menu.php');
                } else {
                    $_SESSION['flash'] = 'Registro completo. Puedes iniciar sesión.';
                    redirect('../View/login.php');
                }
            } else {
                $_SESSION['flash'] = 'No se pudo crear el usuario.';
                redirect('../View/signUp.php');
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = 'Error al crear usuario: ' . $e->getMessage();
            redirect('../View/signUp.php');
        }
    } else {
        redirect('../View/login.php');
    }
} catch (Exception $e) {
    $_SESSION['flash'] = 'Error: ' . $e->getMessage();
    redirect('../View/login.php');
}

?>
