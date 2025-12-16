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
        $stmt = $this->pdo->prepare('
            SELECT c.*, ca.id as case_id, ca.status as case_status 
            FROM checklists c 
            LEFT JOIN cases ca ON c.case_id = ca.id 
            WHERE c.user_id = ? 
            ORDER BY c.created_at DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function saveForUser(int $userId, string $title, string $steps, int $caseId = null): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO checklists (user_id, title, steps, case_id) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$userId, $title, $steps, $caseId]);
    }
    
    public function updateCaseId(int $checklistId, int $caseId): bool
    {
        $stmt = $this->pdo->prepare('UPDATE checklists SET case_id = ? WHERE id = ?');
        return $stmt->execute([$caseId, $checklistId]);
    }
    
    public function getUserCases(int $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM cases WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
