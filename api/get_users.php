<?php
session_start();

require_once '../Config/Database.php';
require_once '../Model/User.php';

header('Content-Type: application/json');

try {
    $db = new Database();
    $conn = $db->getConnection();
    $users = [];
    // Obtener todos los usernames de admin_
    $adminUsernames = [];
    $adminStmt = $conn->prepare('SELECT username FROM admin_');
    $adminStmt->execute();
    while ($adminRow = $adminStmt->fetch(PDO::FETCH_ASSOC)) {
        $adminUsernames[] = $adminRow['username'];
    }

    // Obtener todos los usuarios de profile_ que no estén en admin_
    $stmt = $conn->prepare('SELECT username, email, telephone FROM profile_');
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // si no es admin o es el usuar logueado
        if (!in_array($row['username'], $adminUsernames) || $row['username'] === $_SESSION['user']['username']) {
            $users[] = $row;
        }
    }
    echo json_encode(['users' => $users]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
