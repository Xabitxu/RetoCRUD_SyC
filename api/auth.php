<?php
session_start();
require_once __DIR__ . '/../Model/User.php';

header('Content-Type: application/json');

$action = $_POST['accion'] ?? null;
$userModel = new User();

try {
    if ($action === 'login') {
        $identifier = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $row = $userModel->getByIdentifier($identifier);

        if ($row && $row['PASSWORD_'] === $password) {
            $_SESSION['user'] = [
                'username' => $row['USERNAME'],
                'email' => $row['EMAIL'] ?? $identifier,
                'name_' => $row['NAME'] ?? '',
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
        exit;
    }

    elseif ($action === 'signup') {
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

        $allowedGenders = ['female','male','other'];
        if (!in_array($gender, $allowedGenders)) {
            echo json_encode(['success' => false, 'message' => 'Género inválido.']);
            exit;
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

        $created = $userModel->createUser($data);

        if ($created) {
            $row = $userModel->getByIdentifier($username ?? $email);
            if ($row) {
                $_SESSION['user'] = [
                    'username' => $row['USERNAME'],
                    'email' => $row['EMAIL'] ?? $email ?? $username,
                    'role' => $row['role'] ?? 'user'
                ];
                echo json_encode([
                    'success' => true,
                    'message' => 'Usuario creado y sesión iniciada correctamente.',
                    'user' => $_SESSION['user']
                ]);
            } else {
                echo json_encode(['success' => true, 'message' => 'Registro completo. Puedes iniciar sesión.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo crear el usuario.']);
        }
        exit;
    }

    elseif ($action === 'logout') {
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Sesión cerrada.']);
        exit;
    }

    else {
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
?>
