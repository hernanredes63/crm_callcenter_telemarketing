<?php
require_once '../app/core/Database.php';

class User {
    
    // Buscar usuario por email (Para el Login)
    public function findByEmail($email) {
        $pdo = Database::pdo();
        
        $sql = "SELECT 
                    u.id, 
                    u.email, 
                    u.password_hash, 
                    p.nombre, 
                    ur.role AS rol 
                FROM users u
                LEFT JOIN profiles p ON u.id = p.user_id
                LEFT JOIN user_roles ur ON u.id = ur.user_id
                WHERE u.email = :email 
                LIMIT 1";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        return $stmt->fetch();
    }

    // Obtener todos los usuarios con su rol y perfil
    public function getAllUsers() {
        $pdo = Database::pdo();
        
        $sql = "SELECT 
                    u.id, 
                    u.email, 
                    p.nombre, 
                    ur.role,
                    u.created_at 
                FROM users u
                LEFT JOIN profiles p ON u.id = p.user_id
                LEFT JOIN user_roles ur ON u.id = ur.user_id
                ORDER BY u.id DESC";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Registrar un nuevo usuario
    public function createUser($data) {
        $pdo = Database::pdo();
        
        try {
            $pdo->beginTransaction();

            // 1. Insertar credenciales en la tabla users
            $stmtUsers = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :password_hash)");
            $stmtUsers->execute([
                ':email' => $data['email'],
                ':password_hash' => $data['password_hash']
            ]);
            
            $userId = $pdo->lastInsertId();

            // 2. Insertar información personal en profiles
            $stmtProfiles = $pdo->prepare("INSERT INTO profiles (user_id, nombre) VALUES (:user_id, :nombre)");
            $stmtProfiles->execute([
                ':user_id' => $userId,
                ':nombre' => $data['nombre']
            ]);

            // 3. Asignar rol en user_roles
            $stmtRoles = $pdo->prepare("INSERT INTO user_roles (user_id, role) VALUES (:user_id, :role)");
            $stmtRoles->execute([
                ':user_id' => $userId,
                ':role' => $data['role']
            ]);

            $pdo->commit();
            return true;

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }


    // Obtener un usuario específico por ID
    public function getUserById($id) {
        $pdo = Database::pdo();
        $sql = "SELECT u.id, u.email, p.nombre, ur.role 
                FROM users u
                LEFT JOIN profiles p ON u.id = p.user_id
                LEFT JOIN user_roles ur ON u.id = ur.user_id
                WHERE u.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Actualizar datos del usuario
    public function updateUser($id, $data) {
        $pdo = Database::pdo();
        try {
            $pdo->beginTransaction();

            // 1. Actualizar email (y contraseña solo si se escribió una nueva)
            if (!empty($data['password_hash'])) {
                $stmt = $pdo->prepare("UPDATE users SET email = :email, password_hash = :password_hash WHERE id = :id");
                $stmt->execute([':email' => $data['email'], ':password_hash' => $data['password_hash'], ':id' => $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
                $stmt->execute([':email' => $data['email'], ':id' => $id]);
            }

            // 2. Actualizar perfil y rol
            $stmt = $pdo->prepare("UPDATE profiles SET nombre = :nombre WHERE user_id = :id");
            $stmt->execute([':nombre' => $data['nombre'], ':id' => $id]);

            $stmt = $pdo->prepare("UPDATE user_roles SET role = :role WHERE user_id = :id");
            $stmt->execute([':role' => $data['role'], ':id' => $id]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    // Eliminar usuario
    public function deleteUser($id) {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}