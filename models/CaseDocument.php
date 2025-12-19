<?php
class CaseDocument
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function forCase(int $caseId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM case_documents WHERE case_id = ? ORDER BY uploaded_at DESC');
        $stmt->execute([$caseId]);
        return $stmt->fetchAll();
    }

    public function add(int $caseId, string $stage, string $title, string $filePath): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO case_documents (case_id, stage, title, file_path, status) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([$caseId, $stage, $title, $filePath, 'pending']);
    }
    
    public function delete(int $documentId, int $userId): bool
    {
        $stmt = $this->pdo->prepare('
            DELETE cd FROM case_documents cd 
            JOIN migration_cases mc ON cd.case_id = mc.id 
            WHERE cd.id = ? AND mc.user_id = ?
        ');
        return $stmt->execute([$documentId, $userId]);
    }
    
    public function getById(int $documentId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM case_documents WHERE id = ?');
        $stmt->execute([$documentId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    
    public function canUserDelete(int $documentId, int $userId): bool
    {
        $stmt = $this->pdo->prepare('
            SELECT COUNT(*) as count 
            FROM case_documents cd 
            JOIN migration_cases mc ON cd.case_id = mc.id 
            WHERE cd.id = ? AND mc.user_id = ? AND cd.status IN ("pending", "rejected")
        ');
        $stmt->execute([$documentId, $userId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    public function updateStatus(int $documentId, string $status, string $adminComment = null): bool
    {
        $stmt = $this->pdo->prepare('UPDATE case_documents SET status = ?, admin_comment = ? WHERE id = ?');
        return $stmt->execute([$status, $adminComment, $documentId]);
    }
    
    public function getAllPending()
    {
        $stmt = $this->pdo->prepare('
            SELECT cd.*, mc.user_id, u.name as user_name, u.email 
            FROM case_documents cd 
            JOIN migration_cases mc ON cd.case_id = mc.id 
            JOIN users u ON mc.user_id = u.id 
            WHERE cd.status = "pending" 
            ORDER BY cd.uploaded_at ASC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getStatusTitle(string $status): string
    {
        $statuses = [
            'pending' => 'На проверке',
            'under_review' => 'На проверке',
            'approved' => 'Одобрено',
            'rejected' => 'Отклонено'
        ];
        
        return $statuses[$status] ?? $status;
    }
}
