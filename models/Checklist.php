<?php
require_once __DIR__ . '/Case.php';

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
        $stmt = $this->pdo->prepare('
            SELECT c.*, mc.id as case_id, mc.title as case_title, mc.method as case_method, mc.status as case_status 
            FROM checklists c 
            LEFT JOIN migration_cases mc ON c.case_id = mc.id 
            WHERE c.user_id = ? 
            ORDER BY c.created_at DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function saveForUser(int $userId, string $title, string $steps, int $caseId = null): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO checklists (user_id, title, steps, case_id) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $title, $steps, $caseId]);
        return (int)$this->pdo->lastInsertId();
    }
    
    public function getById(int $checklistId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM checklists WHERE id = ?');
        $stmt->execute([$checklistId]);
        return $stmt->fetch() ?: null;
    }
    
    public function updateCaseId(int $checklistId, int $caseId): bool
    {
        $stmt = $this->pdo->prepare('UPDATE checklists SET case_id = ? WHERE id = ?');
        return $stmt->execute([$caseId, $checklistId]);
    }
    
    public function delete(int $checklistId, int $userId): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM checklists WHERE id = ? AND user_id = ?');
        return $stmt->execute([$checklistId, $userId]);
    }
    
    public function getByCaseId(int $caseId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM checklists WHERE case_id = ? ORDER BY created_at DESC');
        $stmt->execute([$caseId]);
        return $stmt->fetchAll();
    }
    
    public function getUserCases(int $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM migration_cases WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getMethodTitle(string $method): string
    {
        return MigrationCase::getMethodTitle($method);
    }
}
