<?php
// Отладка таблицы testimonials
try {
    $pdo = new PDO('mysql:host=localhost;dbname=usacitizenguide', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Все записи в таблице testimonials:</h2>";
    $stmt = $pdo->query("SELECT * FROM testimonials ORDER BY created_at DESC");
    $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($testimonials)) {
        echo "<p>Нет записей в таблице testimonials</p>";
    } else {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Inquiry ID</th><th>User ID</th><th>User Name</th><th>Rating</th><th>Content</th><th>Status</th><th>Featured</th><th>Created</th></tr>";
        foreach ($testimonials as $testimonial) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($testimonial['id']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['inquiry_id']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['user_id']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['user_name']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['rating']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($testimonial['content'], 0, 50)) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['status'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['is_featured']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h2>Тест метода getAllWithUserInfo:</h2>";
    
    // Подключаем модель
    require_once 'models/Testimonial.php';
    $testimonialModel = new Testimonial();
    $allTestimonials = $testimonialModel->getAllWithUserInfo();
    
    if (empty($allTestimonials)) {
        echo "<p>Метод getAllWithUserInfo вернул пустой массив</p>";
    } else {
        echo "<p>Метод getAllWithUserInfo вернул " . count($allTestimonials) . " записей</p>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>User Name</th><th>Email</th><th>Rating</th><th>Content</th><th>Status</th><th>Created</th></tr>";
        foreach ($allTestimonials as $testimonial) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($testimonial['id']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['user_name']) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['email'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['rating']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($testimonial['content'], 0, 50)) . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['status'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($testimonial['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (PDOException $e) {
    echo "<h2>Ошибка:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
