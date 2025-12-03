<?php
class ChecklistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }

        $checklistModel = new Checklist();
        $checklists = $checklistModel->userChecklists(Auth::userId());
        $pageTitle = 'Мои чек-листы';
        $viewFile = __DIR__ . '/../views/checklists/index.php';
        $this->view($viewFile, compact('pageTitle', 'checklists'));
    }

    public function save()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        $title = $_POST['title'] ?? '';
        $steps = $_POST['steps'] ?? '';

        if ($title && $steps) {
            $model = new Checklist();
            $model->saveForUser(Auth::userId(), $title, $steps);
        }

        header('Location: index.php?route=checklists');
        exit;
    }
}
