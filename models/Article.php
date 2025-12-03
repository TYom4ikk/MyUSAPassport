<?php
class Article
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function latest(int $limit = 10)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM articles ORDER BY created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
