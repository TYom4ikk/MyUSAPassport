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
        $pageTitle = 'Мой кейс и документы';
        $viewFile = __DIR__ . '/../views/case/index.php';
        $this->view($viewFile, compact('pageTitle', 'case', 'documents', 'info'));
    }
}
