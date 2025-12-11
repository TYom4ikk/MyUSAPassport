<?php
class PasswordReset
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function create(int $userId, string $token, string $expiresAt): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)');
        return $stmt->execute([$userId, $token, $expiresAt]);
    }

    public function findValid(string $token)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1');
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function deleteById(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE id = ?');
        $stmt->execute([$id]);
    }
}
