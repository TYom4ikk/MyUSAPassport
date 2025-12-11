<?php
class CaseModel
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function findOrCreateForUser(int $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM cases WHERE user_id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $case = $stmt->fetch();
        if ($case) {
            return $case;
        }
        $stmt = $this->pdo->prepare('INSERT INTO cases (user_id) VALUES (?)');
        $stmt->execute([$userId]);
        $id = (int)$this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare('SELECT * FROM cases WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateStatus(int $caseId, string $status): bool
    {
        $stmt = $this->pdo->prepare('UPDATE cases SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $caseId]);
    }
}
