<?php
session_start();
require_once __DIR__ . '/../Model/User.php';

header('Content-Type: application/json');

$action = $_POST['accion'] ?? null;





function logIn()
{
    $userModel = new User();
    $identifier = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Buscar usuario por username o email
    $row = $userModel->getByIdentifier($identifier);

    if ($row && password_verify($password, $row['PASSWORD_'])) {
        $_SESSION['user'] = [
            'username' => $row['USERNAME'],
            'email' => $row['EMAIL'] ?? $identifier,
            'name' => $row['NAME_'] ?? '',
            'surname' => $row['SURNAME'] ?? '',
            'telephone' => $row['TELEPHONE'] ?? '',
            'role' => $row['role'] ?? 'user'
        ];
        echo json_encode([
            'success' => true,
            'message' => 'Login correcto',
            'user' => $_SESSION['user']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Credenciales inválidas'
        ]);
    }
}

try {
    if ($action === 'login') {

        logIn();
        exit;
    } elseif ($action === 'signup') {
        $userModel = new User();

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
            echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
            exit;
        }

        if ($userModel->existsUsernameOrEmail($username, $email)) {
            echo json_encode(['success' => false, 'message' => 'Usuario o email ya existe']);
            exit;
        }

        if (!preg_match('/^[0-9]{9}$/', $telephone)) {
            echo json_encode(['success' => false, 'message' => 'Teléfono inválido. Debe tener 9 dígitos.']);
            exit;
        }

        if (!empty($card) && !preg_match('/^[A-Z]{2}[0-9]{22}$/', $card)) {
            echo json_encode(['success' => false, 'message' => 'Número de tarjeta inválido. Formato esperado: 2 letras mayúsculas seguido de 22 dígitos.']);
            exit;
        }

        $allowedGenders = ['female', 'male', 'other'];
        if (!in_array($gender, $allowedGenders)) {
            echo json_encode(['success' => false, 'message' => 'Género inválido.']);
            exit;
        }

        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'telephone' => $telephone,
            'gender' => $gender,
            'card' => $card,
        ];

        $created = $userModel->createUser($data);

        if ($created) {
            $row = $userModel->getByIdentifier($username ?? $email);
            logIn();
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo crear el usuario.']);
        }
        exit;
    } elseif ($action === 'logout') {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../View/login.php');
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Acción no reconocida.']);
        exit;
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
    exit;
}
