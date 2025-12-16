<?php
class Testimonial {
    private PDO $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    // Создать отзыв из inquiry
    public function createFromInquiry($inquiryId, $userId, $userName, $rating, $content) {
        $stmt = $this->pdo->prepare("
            INSERT INTO testimonials (inquiry_id, user_id, user_name, rating, content) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$inquiryId, $userId, $userName, $rating, $content]);
    }
    
    // Получить одобренные отзывы для главной страницы
    public function getApprovedForHomepage($limit = 6) {
        $stmt = $this->pdo->prepare("
            SELECT t.*, u.avatar, u.email
            FROM testimonials t
            LEFT JOIN users u ON t.user_id = u.id
            WHERE t.status = 'approved' AND t.rating >= 4
            ORDER BY t.created_at DESC
            LIMIT " . (int)$limit
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Получить все отзывы с информацией о пользователях (новые сверху)
    public function getAllWithUserInfo() {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT t.*, u.name, u.email, u.avatar, i.message as original_message, i.status as inquiry_status
            FROM testimonials t
            LEFT JOIN users u ON t.user_id = u.id
            LEFT JOIN inquiries i ON t.inquiry_id = i.id
            ORDER BY t.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Обновить статус отзыва
    public function updateStatus($testimonialId, $status) {
        $stmt = $this->pdo->prepare("
            UPDATE testimonials 
            SET status = ?, is_featured = CASE WHEN ? = 'featured' THEN 1 ELSE 0 END
            WHERE id = ?
        ");
        return $stmt->execute([$status, $status, $testimonialId]);
    }
    
    // Удалить отзыв
    public function delete($testimonialId) {
        $stmt = $this->pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        return $stmt->execute([$testimonialId]);
    }
    
    // Получить статистику отзывов
    public function getStats() {
        $stmt = $this->pdo->query("
            SELECT 
                COUNT(*) as total,
                COUNT(CASE WHEN rating >= 4 THEN 1 END) as positive,
                AVG(rating) as avg_rating,
                COUNT(CASE WHEN is_featured = 1 THEN 1 END) as featured
            FROM testimonials
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
