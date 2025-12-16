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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            $checklistModel = new Checklist();
            $checklists = $checklistModel->userChecklists(Auth::userId());

            ob_start();
            ?>
            <?php if (!empty($checklists)): ?>
                <ul class="card-list">
                    <?php foreach ($checklists as $c): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($c['title']); ?></strong><br>
                            <?php echo nl2br(htmlspecialchars($c['steps'])); ?><br>
                            <small><?php echo htmlspecialchars($c['created_at']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>У вас ещё нет чек-листов.</p>
            <?php endif; ?>
            <?php
            $html = ob_get_clean();
            header('Content-Type: application/json');
            echo json_encode([
                'success'  => true,
                'targetId' => 'checklists-list',
                'html'     => $html,
            ]);
            exit;
        }

        header('Location: index.php?route=checklists');
        exit;
    }
}
