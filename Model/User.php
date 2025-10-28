<?php
require_once __DIR__ . '/../Config/Database.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Busca al usuario en USER_, ADMIN_ y PROFILE_ (por username o email)
    public function getByIdentifier($id) {
        // Primero buscar en PROFILE_ (contiene los datos comunes y PASSWORD_)
        $stmt = $this->conn->prepare("SELECT * FROM PROFILE_ WHERE USERNAME = :id OR EMAIL = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$profile) {
            return false;
        }

        $username = $profile['USERNAME'];

        // Buscar datos específicos de USER_
        $stmt = $this->conn->prepare("SELECT * FROM USER_ WHERE USERNAME = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            // Combinar perfil con datos de user
            $merged = array_merge($profile, $user);
            $merged['role'] = 'user';
            return $merged;
        }

        // Buscar datos específicos de ADMIN_
        $stmt = $this->conn->prepare("SELECT * FROM ADMIN_ WHERE USERNAME = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin) {
            $merged = array_merge($profile, $admin);
            $merged['role'] = 'admin';
            return $merged;
        }

        // Solo perfil
        $profile['role'] = 'profile';
        return $profile;
    }

    public function modifyUser($data) {
        try {
            $pdo = $this->conn;

            // Si la contraseña está vacía, no la cambiamos
            if (empty($data['password'])) {
                $sql = "UPDATE PROFILE_ 
                        SET EMAIL = :email, TELEPHONE = :telephone 
                        WHERE USERNAME = :username";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':telephone', $data['telephone']);
                $stmt->bindParam(':username', $data['username']);
            } else {
                $sql = "UPDATE PROFILE_ 
                        SET EMAIL = :email, TELEPHONE = :telephone, PASSWORD_ = :password 
                        WHERE USERNAME = :username";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':telephone', $data['telephone']);
                $stmt->bindParam(':password', $data['password']);
                $stmt->bindParam(':username', $data['username']);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al modificar el usuario: " . $e->getMessage());
        }
    }

    public function deleteUser($data) {
        try {
            $pdo = $this->conn;
            $username = $data['username'] ?? null;
            $email = $data['email'] ?? null;

            if (!$username && !$email) {
                throw new Exception("Falta username o email para eliminar el usuario.");
            }

            $pdo->beginTransaction();

            if ($username) {
                $stmtUser = $pdo->prepare("DELETE FROM USER_ WHERE USERNAME = :username");
                $stmtUser->execute([':username' => $username]);
                $deletedUser = $stmtUser->rowCount();
            } else {
                $deletedUser = 0;
            }

            $stmtProfile = $pdo->prepare("DELETE FROM PROFILE_ WHERE (USERNAME = :username) OR (EMAIL = :email)");
            $stmtProfile->execute([':username' => $username, ':email' => $email]);
            $deletedProfile = $stmtProfile->rowCount();

            $pdo->commit();

            // Devuelve true si se borró al menos una fila
            return ($deletedUser > 0 || $deletedProfile > 0);
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new Exception("Error al eliminar el usuario: " . $e->getMessage());
        } catch (Exception $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public function existsUsernameOrEmail($username, $email) {
        $sql = "SELECT 1 FROM PROFILE_ WHERE USERNAME = :u OR EMAIL = :e LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':u' => $username, ':e' => $email]);
        return $stmt->fetchColumn() !== false;
    }

    public function createUser(array $data) {
        // data: username, password (already hashed), email, name, surname, telephone, gender, card
        try {
            $this->conn->beginTransaction();

            // Insertar solo en PROFILE_ (USER_CODE es AUTO_INCREMENT ahora)
            $sql = "INSERT INTO PROFILE_ (USERNAME, PASSWORD_, EMAIL, NAME_, TELEPHONE, SURNAME)
                    VALUES (:username, :password, :email, :name, :telephone, :surname)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':username' => $data['username'],
                ':password' => $data['password'],
                ':email' => $data['email'],
                ':name' => $data['name'],
                ':telephone' => $data['telephone'],
                ':surname' => $data['surname']
            ]);

            // Obtener el user_code generado por AUTO_INCREMENT (si lo requiere)
            $user_code = $this->conn->lastInsertId();

            // Insertar solo campos específicos en USER_
            $sql2 = "INSERT INTO USER_ (USERNAME, GENDER, CARD_NUMBER)
                     VALUES (:username, :gender, :card)";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([
                ':username' => $data['username'],
                ':gender' => $data['gender'] ?? null,
                ':card' => $data['card'] ?? null,
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function updatePassword($username, $newHashed) {
        // Con el nuevo esquema la contraseña se guarda en PROFILE_
        $stmt = $this->conn->prepare("UPDATE PROFILE_ SET PASSWORD_ = :p WHERE USERNAME = :u");
        $stmt->execute([':p' => $newHashed, ':u' => $username]);
        return true;
    }
}

?>
