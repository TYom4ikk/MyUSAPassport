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
        $stmt = $this->pdo->prepare('INSERT INTO case_documents (case_id, stage, title, file_path) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$caseId, $stage, $title, $filePath]);
    }
}
