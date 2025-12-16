<?php
class CaseController extends Controller
{
    private function requireAuth()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function index()
    {
        $this->requireAuth();
        $userId = Auth::userId();

        $caseModel = new CaseModel();
        $docModel = new CaseDocument();

        $case = $caseModel->findOrCreateForUser($userId);
        $documents = $docModel->forCase((int)$case['id']);

        $pageTitle = 'Мой кейс и документы';
        $viewFile = __DIR__ . '/../views/case/index.php';
        $this->view($viewFile, compact('pageTitle', 'case', 'documents'));
    }

    public function upload()
    {
        $this->requireAuth();
        $userId = Auth::userId();

        $caseModel = new CaseModel();
        $docModel = new CaseDocument();
        $case = $caseModel->findOrCreateForUser($userId);

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
                $docModel->add((int)$case['id'], $stage, $title, $relativePath);
                $info = 'Документ загружен.';
            } else {
                $info = 'Ошибка при загрузке файла.';
            }
        } else {
            $info = 'Заполните все поля и выберите файл.';
        }

        $documents = $docModel->forCase((int)$case['id']);

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
        $viewFile = __DIR__ . '/../views/case/index.php';
        $this->view($viewFile, compact('pageTitle', 'case', 'documents', 'info'));
    }
}
