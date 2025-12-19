<?php
require_once __DIR__ . '/../models/Case.php';

class CaseController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        $userId = Auth::userId();
        $cases = MigrationCase::getByUserId($userId);
        
        $pageTitle = 'Мои кейсы';
        $viewFile = __DIR__ . '/../views/cases/index.php';
        $this->view($viewFile, compact('pageTitle', 'cases'));
    }

    public function create()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $method = trim($_POST['method'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            if (empty($title) || empty($method)) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Заполните все обязательные поля']);
                exit;
            }
            
            $caseId = MigrationCase::create(Auth::userId(), $title, $method, $description);
            
            if ($caseId) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Кейс успешно создан',
                    'redirect' => 'index.php?route=case/view&id=' . $caseId
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Ошибка при создании кейса']);
            }
            exit;
        }
        
        $pageTitle = 'Создать новый кейс';
        $viewFile = __DIR__ . '/../views/cases/create.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function viewCase()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        $caseId = (int)($_GET['id'] ?? 0);
        $case = MigrationCase::getById($caseId);
        
        if (!$case || $case['user_id'] !== Auth::userId()) {
            $_SESSION['error'] = 'Кейс не найден';
            header('Location: index.php?route=case');
            exit;
        }
        
        // Загружаем документы для этого кейса
        $docModel = new CaseDocument();
        $documents = $docModel->forCase($caseId);
        
        $pageTitle = $case['title'];
        $viewFile = __DIR__ . '/../views/cases/view.php';
        $this->view($viewFile, compact('pageTitle', 'case', 'documents'));
    }

    public function edit()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        $caseId = (int)($_GET['id'] ?? 0);
        $case = MigrationCase::getById($caseId);
        
        if (!$case || $case['user_id'] !== Auth::userId()) {
            $_SESSION['error'] = 'Кейс не найден';
            header('Location: index.php?route=case');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = trim($_POST['status'] ?? '');
            
            if (empty($title)) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Название не может быть пустым']);
                exit;
            }
            
            $result = MigrationCase::update($caseId, [
                'title' => $title,
                'description' => $description,
                'status' => $status
            ]);
            
            if ($result) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Кейс обновлен'
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Ошибка при обновлении кейса']);
            }
            exit;
        }
        
        $pageTitle = 'Редактировать кейс';
        $viewFile = __DIR__ . '/../views/cases/edit.php';
        $this->view($viewFile, compact('pageTitle', 'case'));
    }

    public function delete()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        $caseId = (int)($_POST['id'] ?? 0);
        $case = MigrationCase::getById($caseId);
        
        if (!$case || $case['user_id'] !== Auth::userId()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Кейс не найден']);
            exit;
        }
        
        if (MigrationCase::delete($caseId)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Кейс удален'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ошибка при удалении кейса']);
        }
        exit;
    }

    public function deleteDocument()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        $documentId = (int)($_POST['document_id'] ?? 0);
        $userId = Auth::userId();
        
        $docModel = new CaseDocument();
        
        // Проверяем, может ли пользователь удалить этот документ
        if (!$docModel->canUserDelete($documentId, $userId)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Нельзя удалить одобренный документ']);
            exit;
        }
        
        if ($docModel->delete($documentId, $userId)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Документ удален'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ошибка при удалении документа']);
        }
        exit;
    }

    // Старые методы для обратной совместимости
    public function upload()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        
        $caseId = (int)($_GET['case_id'] ?? 0);
        $case = MigrationCase::getById($caseId);
        
        if (!$case || $case['user_id'] !== Auth::userId()) {
            $_SESSION['error'] = 'Кейс не найден';
            header('Location: index.php?route=case');
            exit;
        }

        $docModel = new CaseDocument();
        $stage = $_POST['stage'] ?? '';
        $title = $_POST['title'] ?? '';
        $info = '';

        if ($stage && $title && !empty($_FILES['file']['name'])) {
            $uploadDir = __DIR__ . '/../uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $name = basename($_FILES['file']['name']);
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9_\.-]/', '_', $name);
            $targetPath = $uploadDir . '/' . $safeName;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                $relativePath = 'uploads/' . $safeName;
                $docModel->add($caseId, $stage, $title, $relativePath);
                $info = 'Документ загружен.';
            } else {
                $info = 'Ошибка при загрузке файла.';
            }
        } else {
            $info = 'Заполните все поля и выберите файл.';
        }

        $documents = $docModel->forCase($caseId);

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            ob_start();
            ?>
            <?php if (!empty($documents)): ?>
                <ul class="card-list">
                    <?php foreach ($documents as $d): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($d['title']); ?></strong><br>
                            Этап: <?php echo htmlspecialchars($d['stage']); ?><br>
                            <a href="<?php echo htmlspecialchars($d['file_path']); ?>" target="_blank">Открыть файл</a><br>
                            <small>Загружено: <?php echo htmlspecialchars($d['uploaded_at']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Документов пока нет.</p>
            <?php endif; ?>
            <?php
            $html = ob_get_clean();
            header('Content-Type: application/json');
            echo json_encode([
                'success'      => true,
                'targetId'     => 'case-documents-list',
                'html'         => $html,
                'message'      => $info,
                'messageTarget'=> 'case-upload-message',
            ]);
            exit;
        }

        $pageTitle = 'Мой кейс и документы';
        $viewFile = __DIR__ . '/../views/cases/view.php';
        $this->view($viewFile, compact('pageTitle', 'case', 'documents', 'info'));
    }
}
