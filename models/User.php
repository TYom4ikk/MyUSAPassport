<?php
class User
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(string $name, string $email, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
        return $stmt->execute([$name, $email, $hash]);
    }

    public function delete(int $userId): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$userId]);
    }
    
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }
    
    public function updateProfile($userId, $data) {
        $sql = "UPDATE users SET name = :name, email = :email";
        $params = [
            ':id' => $userId,
            ':name' => $data['name'],
            ':email' => $data['email']
        ];
        if (!empty($data['password'])) {
            $sql .= ", password_hash = :password_hash";
            $params[':password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (!empty($data['avatar'])) {
            $sql .= ", avatar = :avatar";
            $params[':avatar'] = $data['avatar'];
        }
        $sql .= " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    // Add this method to get user by ID with avatar
    public function findByIdWithAvatar($userId) {
        $stmt = $this->pdo->prepare("
            SELECT id, name, email, avatar, role, created_at 
            FROM users 
            WHERE id = :id
        ");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
