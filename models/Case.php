<?php
class MigrationCase
{
    public static function create(int $userId, string $title, string $method, string $description = ''): int
    {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO migration_cases (user_id, title, method, description) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $title, $method, $description]);
        return (int)$pdo->lastInsertId();
    }

    public static function getByUserId(int $userId): array
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM migration_cases WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $caseId): ?array
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM migration_cases WHERE id = ?');
        $stmt->execute([$caseId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function update(int $caseId, array $data): bool
    {
        global $pdo;
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $caseId;
        
        $stmt = $pdo->prepare('UPDATE migration_cases SET ' . implode(', ', $fields) . ' WHERE id = ?');
        return $stmt->execute($values);
    }

    public static function delete(int $caseId): bool
    {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM migration_cases WHERE id = ?');
        return $stmt->execute([$caseId]);
    }

    public static function updateStatus(int $caseId, string $status): bool
    {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE migration_cases SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $caseId]);
    }

    public static function getMethodTitle(string $method): string
    {
        $methods = [
            'naturalization' => 'Натурализация',
            'greencard' => 'Лотерея Green Card',
            'marriage' => 'Брак с гражданином США',
            'investment' => 'Инвестиции (EB-5)',
            'military' => 'Служба в армии США',
            'employment' => 'Рабочая миграция'
        ];
        
        return $methods[$method] ?? $method;
    }
}
