<?php

class Faq
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT * FROM faq ORDER BY id DESC');
        return $stmt->fetchAll();
    }
}

