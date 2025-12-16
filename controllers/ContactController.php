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
        } elseif ($message) {
            $model = new Inquiry();
            $userId = Auth::userId();
            
            // Добавляем рейтинг в сообщение для сохранения в inquiries
            $fullMessage = $message;
            if ($rating) {
                $fullMessage = "Рейтинг: {$rating}/5\n\n{$message}";
            }
            
            if ($model->create($userId, $fullMessage)) {
                $info = 'Сообщение отправлено (сохранено в БД).';
                
                // Если есть рейтинг, создаем отзыв автоматически
                if ($rating) {
                    $testimonialModel = new Testimonial();
                    $userModel = new User();
                    $user = $userModel->findById($userId);
                    
                    // Получаем ID созданного inquiry
                    global $pdo;
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
                }
            } else {
                $info = 'Ошибка при отправке сообщения.';
            }
        } else {
            $info = 'Введите сообщение.';
        }

        // Отправляем только AJAX ответ
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => $info,
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

