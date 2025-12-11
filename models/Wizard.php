<?php
class Wizard
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function saveResult(?int $userId, array $data, string $result): bool
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $stmt = $this->pdo->prepare('INSERT INTO wizard_responses (user_id, data_json, result) VALUES (?, ?, ?)');
        return $stmt->execute([$userId, $json, $result]);
    }
}
