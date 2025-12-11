<?php
class Notification
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function add(int $userId, string $message): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)');
        return $stmt->execute([$userId, $message]);
    }

    public function latestForUser(int $userId, int $limit = 5)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ?');
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
