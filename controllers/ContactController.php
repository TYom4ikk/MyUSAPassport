<?php

class ContactController extends Controller
{
    public function send()
    {
        $message = $_POST['message'] ?? '';
        $rating = $_POST['rating'] ?? null;
        $info = '';

        // Проверяем что это AJAX запрос
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if (!$isAjax) {
            // Если не AJAX, просто показываем страницу без обработки
            $pageTitle = 'Обратная связь';
            $viewFile = __DIR__ . '/../views/home/contact.php';
            $this->view($viewFile, compact('pageTitle', 'info'));
            return;
        }

        if (!Auth::check()) {
            $info = 'Вы не авторизованы, поэтому не можете отправлять обратную связь.';
        } elseif (!$rating) {
            $info = 'Пожалуйста, укажите рейтинг для отправки отзыва.';
        } elseif ($message) {
            $model = new Inquiry();
            $userId = Auth::userId();
            
            // Проверяем на дубликаты только по последнему отзыву этого пользователя
            global $pdo;
            $checkStmt = $pdo->prepare("
                SELECT COUNT(*) as count 
                FROM testimonials t 
                WHERE t.user_id = ? AND t.content = ? AND t.created_at > DATE_SUB(NOW(), INTERVAL 10 SECOND)
            ");
            $checkStmt->execute([$userId, $message]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['count'] > 0) {
                $info = 'Сообщение отправлено (сохранено в БД). Ваш отзыв отправлен на модерацию.';
            } else {
                // Добавляем рейтинг в сообщение для сохранения в inquiries
                $fullMessage = "Рейтинг: {$rating}/5\n\n{$message}";
                
                $inquiryCreated = $model->create($userId, $fullMessage);
                if ($inquiryCreated) {
                    $info = 'Сообщение отправлено (сохранено в БД).';
                    
                    // Создаем отзыв автоматически
                    $testimonialModel = new Testimonial();
                    $userModel = new User();
                    $user = $userModel->findById($userId);
                    
                    // Получаем ID созданного inquiry
                    $stmt = $pdo->prepare("SELECT LAST_INSERT_ID() as id");
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $inquiryId = $result['id'];
                    
                    // Создаем отзыв со статусом pending для модерации
                    $testimonialCreated = $testimonialModel->createFromInquiry($inquiryId, $userId, $user['name'], $rating, $message);
                    
                    if ($testimonialCreated) {
                        $info .= ' Ваш отзыв отправлен на модерацию.';
                        
                        // Создаем уведомление для администратора
                        $this->createAdminNotification('new_testimonial', "Новый отзыв от пользователя {$user['name']} с рейтингом {$rating}/5", $inquiryId);
                    } else {
                        $info .= ' Ошибка при создании отзыва.';
                    }
                } else {
                    $info = 'Ошибка при отправке сообщения.';
                }
            }
        } else {
            $info = 'Введите сообщение.';
        }

        // Отправляем AJAX ответ
        $success = !str_contains($info, 'Ошибка') && !str_contains($info, 'Введите');
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $info,
        ]);
        exit;
    }
    
    private function sendAjaxResponse($message) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $message,
        ]);
        exit;
    }
    
    private function createAdminNotification($type, $message, $referenceId = null) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO admin_notifications (type, message, reference_id) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$type, $message, $referenceId]);
    }
}

