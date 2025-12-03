<?php
class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        $userModel = new User();
        $user = $userModel->findById(Auth::userId());
        if (!$user || $user['role'] !== 'admin') {
            echo 'Доступ запрещён';
            exit;
        }
        return $user;
    }

    public function index()
    {
        $admin = $this->checkAdmin();
        $pageTitle = 'Админ-панель';
        $viewFile = __DIR__ . '/../views/admin/index.php';
        $this->view($viewFile, compact('pageTitle', 'admin'));
    }
}
