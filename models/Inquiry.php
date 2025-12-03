<?php
class Inquiry
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function create(?int $userId, string $message): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO inquiries (user_id, message) VALUES (?, ?)');
        return $stmt->execute([$userId, $message]);
    }
}
