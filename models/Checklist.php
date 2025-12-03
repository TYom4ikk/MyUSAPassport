<?php
class Checklist
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function userChecklists(int $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM checklists WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function saveForUser(int $userId, string $title, string $steps): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO checklists (user_id, title, steps) VALUES (?, ?, ?)');
        return $stmt->execute([$userId, $title, $steps]);
    }
}
