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
    
    public function updateStatus(int $documentId, string $status, string $adminComment = null): bool
    {
        $stmt = $this->pdo->prepare('UPDATE case_documents SET status = ?, admin_comment = ? WHERE id = ?');
        return $stmt->execute([$status, $adminComment, $documentId]);
    }
    
    public function getAllPending()
    {
        $stmt = $this->pdo->prepare('
            SELECT cd.*, c.user_id, u.name as user_name, u.email 
            FROM case_documents cd 
            JOIN cases c ON cd.case_id = c.id 
            JOIN users u ON c.user_id = u.id 
            WHERE cd.status = "pending" 
            ORDER BY cd.uploaded_at ASC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
