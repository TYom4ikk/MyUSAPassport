<?php

class AdminTestimonialController extends Controller
{
    public function __construct() {
        if (!Auth::check()) {
            header('Location: /index.php?route=login');
            exit;
        }
        
        // Проверяем роль пользователя
        $userModel = new User();
        $currentUser = $userModel->findById(Auth::userId());
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            header('Location: /index.php?route=profile');
            exit;
        }
    }
    
    public function index() {
        $testimonialModel = new Testimonial();
        $testimonials = $testimonialModel->getAllWithUserInfo();
        $stats = $testimonialModel->getStats();
        
        $pageTitle = 'Модерация отзывов';
        $viewFile = __DIR__ . '/../views/admin/testimonials.php';
        $this->view($viewFile, compact('pageTitle', 'testimonials', 'stats'));
    }
    
    public function approve() {
        $testimonialId = $_POST['testimonial_id'] ?? null;
        
        if (!$testimonialId) {
            $this->jsonResponse(['success' => false, 'message' => 'ID отзыва не указан']);
            return;
        }
        
        $testimonialModel = new Testimonial();
        if ($testimonialModel->updateStatus($testimonialId, 'approved')) {
            $this->jsonResponse(['success' => true, 'message' => 'Отзыв одобрен']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Ошибка при одобрении отзыва']);
        }
    }
    
    public function reject() {
        $testimonialId = $_POST['testimonial_id'] ?? null;
        
        if (!$testimonialId) {
            $this->jsonResponse(['success' => false, 'message' => 'ID отзыва не указан']);
            return;
        }
        
        $testimonialModel = new Testimonial();
        if ($testimonialModel->delete($testimonialId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Отзыв удален']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Ошибка при удалении отзыва']);
        }
    }
    
    protected function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
