<?php
class AdminController extends Controller
{
    private function truncateText($text, $length = 30)
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
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

    public function documents()
    {
        $this->checkAdmin();
        
        $docModel = new CaseDocument();
        $pendingDocuments = $docModel->getAllPending();
        
        $pageTitle = 'Модерация документов';
        $viewFile = __DIR__ . '/../views/admin/documents.php';
        $this->view($viewFile, compact('pageTitle', 'pendingDocuments'));
    }
    
    public function updateDocumentStatus()
    {
        $this->checkAdmin();
        
        $documentId = (int)($_POST['document_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $adminComment = trim($_POST['admin_comment'] ?? '');
        
        if (!in_array($status, ['approved', 'rejected'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Неверный статус']);
            exit;
        }
        
        $docModel = new CaseDocument();
        if ($docModel->updateStatus($documentId, $status, $adminComment)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Статус документа обновлен'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ошибка при обновлении статуса']);
        }
        exit;
    }

    public function users()
    {
        $this->checkAdmin();
        
        $userModel = new User();
        $users = $userModel->all();
        
        $pageTitle = 'Управление пользователями';
        $viewFile = __DIR__ . '/../views/admin/users.php';
        $this->view($viewFile, compact('pageTitle', 'users'));
    }
    
    public function deleteUser()
    {
        $this->checkAdmin();
        
        $userId = (int)($_POST['user_id'] ?? 0);
        
        if ($userId === Auth::userId()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Нельзя удалить самого себя']);
            exit;
        }
        
        $userModel = new User();
        if ($userModel->delete($userId)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Пользователь удален'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ошибка при удалении пользователя']);
        }
        exit;
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

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function createArticle()
    {
        $this->checkAdmin();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $imagePath = null;

        if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $safeName = 'article_' . time() . '_' . mt_rand(1000, 9999) . ($ext ? ('.' . strtolower($ext)) : '');
            $uploadDir = __DIR__ . '/../uploads/articles/';
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }
            $target = $uploadDir . $safeName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = 'uploads/articles/' . $safeName;
            }
        }

        if ($title && $content) {
            global $pdo;
            $baseSlug = substr(preg_replace('~[^a-z0-9]+~i', '-', strtolower($title)), 0, 120);
            $slug = $baseSlug . '-' . time() . '-' . mt_rand(1000, 9999);
            $stmt = $pdo->prepare('INSERT INTO articles (title, slug, content, image_url) VALUES (?, ?, ?, ?)');
            $stmt->execute([$title, $slug, $content, $imagePath]);

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

            if ($isAjax) {
                // вернуть обновлённый список статей
                $articles = $pdo->query('SELECT id, title, created_at FROM articles ORDER BY created_at DESC')->fetchAll();
                ob_start();
                ?>
                <ul>
                    <?php foreach ($articles as $a): ?>
                        <li>
                            <?php echo htmlspecialchars($this->truncateText($a['title'], 30)); ?>
                            <small>(<?php echo htmlspecialchars($a['created_at']); ?>)</small>
                            <form method="post" action="index.php?route=admin/article/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($a['id']); ?>">
                                <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                $html = ob_get_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'success'  => true,
                    'targetId' => 'admin-articles-list',
                    'html'     => $html,
                ]);
                exit;
            }
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function createNews()
    {
        $this->checkAdmin();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $imagePath = null;

        if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $safeName = 'news_' . time() . '_' . mt_rand(1000, 9999) . ($ext ? ('.' . strtolower($ext)) : '');
            $uploadDir = __DIR__ . '/../uploads/news/';
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }
            $target = $uploadDir . $safeName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = 'uploads/news/' . $safeName;
            }
        }

        if ($title && $content) {
            global $pdo;
            $baseSlug = substr(preg_replace('~[^a-z0-9]+~i', '-', strtolower($title)), 0, 120);
            $slug = $baseSlug . '-' . time() . '-' . mt_rand(1000, 9999);
            $stmt = $pdo->prepare('INSERT INTO news (title, slug, content, image_url) VALUES (?, ?, ?, ?)');
            $stmt->execute([$title, $slug, $content, $imagePath]);

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

            if ($isAjax) {
                $news = $pdo->query('SELECT id, title, created_at FROM news ORDER BY created_at DESC')->fetchAll();
                ob_start();
                ?>
                <ul>
                    <?php foreach ($news as $n): ?>
                        <li>
                            <?php echo htmlspecialchars($this->truncateText($n['title'], 30)); ?>
                            <small>(<?php echo htmlspecialchars($n['created_at']); ?>)</small>
                            <form method="post" action="index.php?route=admin/news/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($n['id']); ?>">
                                <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                $html = ob_get_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'success'  => true,
                    'targetId' => 'admin-news-list',
                    'html'     => $html,
                ]);
                exit;
            }
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

            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

            if ($isAjax) {
                $faq = $pdo->query('SELECT id, question FROM faq ORDER BY id DESC')->fetchAll();
                ob_start();
                ?>
                <ul>
                    <?php foreach ($faq as $f): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($this->truncateText($f['question'], 30)); ?></strong>
                            <form method="post" action="index.php?route=admin/faq/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($f['id']); ?>">
                                <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                $html = ob_get_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'success'  => true,
                    'targetId' => 'admin-faq-list',
                    'html'     => $html,
                ]);
                exit;
            }
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function deleteArticle()
    {
        $this->checkAdmin();

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($id > 0) {
            global $pdo;
            $stmt = $pdo->prepare('DELETE FROM articles WHERE id = ?');
            $stmt->execute([$id]);
        }

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            global $pdo;
            $articles = $pdo->query('SELECT id, title, created_at FROM articles ORDER BY created_at DESC')->fetchAll();
            ob_start();
            ?>
            <ul>
                <?php foreach ($articles as $a): ?>
                    <li>
                        <?php echo htmlspecialchars($this->truncateText($a['title'], 30)); ?>
                        <small>(<?php echo htmlspecialchars($a['created_at']); ?>)</small>
                        <form method="post" action="index.php?route=admin/article/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($a['id']); ?>">
                            <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            $html = ob_get_clean();
            header('Content-Type: application/json');
            echo json_encode([
                'success'  => true,
                'targetId' => 'admin-articles-list',
                'html'     => $html,
            ]);
            exit;
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function deleteNews()
    {
        $this->checkAdmin();

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($id > 0) {
            global $pdo;
            $stmt = $pdo->prepare('DELETE FROM news WHERE id = ?');
            $stmt->execute([$id]);
        }

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            global $pdo;
            $news = $pdo->query('SELECT id, title, created_at FROM news ORDER BY created_at DESC')->fetchAll();
            ob_start();
            ?>
            <ul>
                <?php foreach ($news as $n): ?>
                    <li>
                        <?php echo htmlspecialchars($this->truncateText($n['title'], 30)); ?>
                        <small>(<?php echo htmlspecialchars($n['created_at']); ?>)</small>
                        <form method="post" action="index.php?route=admin/news/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($n['id']); ?>">
                            <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            $html = ob_get_clean();
            header('Content-Type: application/json');
            echo json_encode([
                'success'  => true,
                'targetId' => 'admin-news-list',
                'html'     => $html,
            ]);
            exit;
        }

        header('Location: index.php?route=admin');
        exit;
    }

    public function deleteFaq()
    {
        $this->checkAdmin();

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($id > 0) {
            global $pdo;
            $stmt = $pdo->prepare('DELETE FROM faq WHERE id = ?');
            $stmt->execute([$id]);
        }

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            global $pdo;
            $faq = $pdo->query('SELECT id, question FROM faq ORDER BY id DESC')->fetchAll();
            ob_start();
            ?>
            <ul>
                <?php foreach ($faq as $f): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($this->truncateText($f['question'], 30)); ?></strong>
                        <form method="post" action="index.php?route=admin/faq/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($f['id']); ?>">
                            <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            $html = ob_get_clean();
            header('Content-Type: application/json');
            echo json_encode([
                'success'  => true,
                'targetId' => 'admin-faq-list',
                'html'     => $html,
            ]);
            exit;
        }

        header('Location: index.php?route=admin');
        exit;
    }
}
