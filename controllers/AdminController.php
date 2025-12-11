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
            $pageTitle = 'Доступ запрещён';
            $viewFile = __DIR__ . '/../views/errors/denied.php';
            $this->view($viewFile, compact('pageTitle'));
            exit;
        }
        return $user;
    }

    public function index()
    {
        $admin = $this->checkAdmin();

        // кейсы с пользователями
        global $pdo;
        $stmt = $pdo->query('SELECT c.*, u.name AS user_name, u.email AS user_email FROM cases c JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC');
        $cases = $stmt->fetchAll();

        // пользователи
        $usersStmt = $pdo->query('SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC');
        $users = $usersStmt->fetchAll();

        // статьи, новости, FAQ (для простого списка)
        $articles = $pdo->query('SELECT id, title, created_at FROM articles ORDER BY created_at DESC')->fetchAll();
        $news = $pdo->query('SELECT id, title, created_at FROM news ORDER BY created_at DESC')->fetchAll();
        $faq = $pdo->query('SELECT id, question FROM faq ORDER BY id DESC')->fetchAll();

        $pageTitle = 'Админ-панель';
        $viewFile = __DIR__ . '/../views/admin/index.php';
        $this->view($viewFile, compact('pageTitle', 'admin', 'cases', 'users', 'articles', 'news', 'faq'));
    }

    public function updateCaseStatus()
    {
        $this->checkAdmin();

        $caseId = isset($_POST['case_id']) ? (int)$_POST['case_id'] : 0;
        $status = $_POST['status'] ?? '';

        if ($caseId > 0 && $status !== '') {
            $caseModel = new CaseModel();
            $caseModel->updateStatus($caseId, $status);

            // уведомление пользователю
            global $pdo;
            $stmt = $pdo->prepare('SELECT user_id FROM cases WHERE id = ?');
            $stmt->execute([$caseId]);
            $case = $stmt->fetch();
            if ($case) {
                $notification = new Notification();
                $msg = 'Статус вашего кейса изменён администратором на: ' . $status;
                $notification->add((int)$case['user_id'], $msg);
            }
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function updateUserRole()
    {
        $this->checkAdmin();

        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        $role = $_POST['role'] ?? '';

        if ($userId > 0 && in_array($role, ['user', 'admin'], true)) {
            global $pdo;
            $stmt = $pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
            $stmt->execute([$role, $userId]);
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function createArticle()
    {
        $this->checkAdmin();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if ($title && $content) {
            global $pdo;
            $slug = substr(preg_replace('~[^a-z0-9]+~i', '-', strtolower($title)), 0, 150);
            $stmt = $pdo->prepare('INSERT INTO articles (title, slug, content) VALUES (?, ?, ?)');
            $stmt->execute([$title, $slug, $content]);
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function createNews()
    {
        $this->checkAdmin();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if ($title && $content) {
            global $pdo;
            $slug = substr(preg_replace('~[^a-z0-9]+~i', '-', strtolower($title)), 0, 150);
            $stmt = $pdo->prepare('INSERT INTO news (title, slug, content) VALUES (?, ?, ?)');
            $stmt->execute([$title, $slug, $content]);
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function createFaq()
    {
        $this->checkAdmin();

        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';

        if ($question && $answer) {
            global $pdo;
            $stmt = $pdo->prepare('INSERT INTO faq (question, answer) VALUES (?, ?)');
            $stmt->execute([$question, $answer]);
        }

        header('Location: index.php?route=admin');
        exit;
    }
}
