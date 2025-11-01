<?php
session_start();
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Model/User.php';

function getAllUsernames($conn) {
    $stmt = $conn->prepare("SELECT username FROM user_");
    $stmt->execute();
    $usernames = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usernames[] = $row['username'];
    }
    return $usernames;
}



if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    header('Content-Type: application/json');
    $database = new Database();
    $conn = $database->getConnection();

    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $stmt = $conn->prepare("SELECT username, email, telephone FROM profile_ WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data ?: []);
        exit();
    }

    echo json_encode(getAllUsernames($conn));
    exit();
}



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
        'password' => $newPassword ? password_hash($newPassword, PASSWORD_BCRYPT) : '' 
    ];

    $modified = $userModel->modifyUser($data);

    if ($modified ) {
        // actualizar datos en sesion si es el usuario logueado
        if (!empty($_SESSION['user'])&& $_POST['username'] === ($_SESSION['user']['username'])) {
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['telephone'] = $telephone;
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