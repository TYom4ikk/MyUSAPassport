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
        $cases = $checklistModel->getUserCases(Auth::userId());
        $pageTitle = 'Мои чек-листы';
        $viewFile = __DIR__ . '/../views/checklists/index.php';
        $this->view($viewFile, compact('pageTitle', 'checklists', 'cases'));
    }

    public function save()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }
        $title = $_POST['title'] ?? '';
        $steps = $_POST['steps'] ?? '';
        $caseId = !empty($_POST['case_id']) ? (int)$_POST['case_id'] : null;

        if ($title && $steps) {
            $model = new Checklist();
            $model->saveForUser(Auth::userId(), $title, $steps, $caseId);
        }
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            $checklistModel = new Checklist();
            $checklists = $checklistModel->userChecklists(Auth::userId());
            $cases = $checklistModel->getUserCases(Auth::userId());

            ob_start();
            ?>
            <?php if (!empty($checklists)): ?>
                <div class="checklists-container">
                    <?php foreach ($checklists as $c): ?>
                        <div class="checklist-card" data-checklist-id="<?php echo $c['id']; ?>">
                            <div class="checklist-header">
                                <h3><?php echo htmlspecialchars($c['title']); ?></h3>
                                <?php if ($c['case_id']): ?>
                                    <span class="case-badge">
                                        Кейс #<?php echo $c['case_id']; ?> 
                                        (<?php echo htmlspecialchars($c['case_status']); ?>)
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="checklist-steps">
                                <?php 
                                $steps = explode("\n", trim($c['steps']));
                                foreach ($steps as $index => $step): 
                                    if (!empty(trim($step))):
                                ?>
                                    <div class="checklist-step">
                                        <input type="checkbox" 
                                               id="step_<?php echo $c['id']; ?>_<?php echo $index; ?>" 
                                               name="step_<?php echo $c['id']; ?>_<?php echo $index; ?>"
                                               onchange="updateStepStatus(<?php echo $c['id']; ?>, <?php echo $index; ?>, this.checked)">
                                        <label for="step_<?php echo $c['id']; ?>_<?php echo $index; ?>">
                                            <?php echo htmlspecialchars(trim($step)); ?>
                                        </label>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                            
                            <div class="checklist-footer">
                                <small>Создан: <?php echo htmlspecialchars($c['created_at']); ?></small>
                                <?php if (!$c['case_id']): ?>
                                    <button onclick="assignToCase(<?php echo $c['id']; ?>)" class="btn-small">Привязать к кейсу</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
    
    public function updateStep()
    {
        if (!Auth::check()) {
            http_response_code(401);
            exit;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $checklistId = $data['checklist_id'] ?? null;
        $stepIndex = $data['step_index'] ?? null;
        $completed = $data['completed'] ?? false;
        
        // Здесь можно добавить сохранение в базу данных
        // Пока просто логируем для демонстрации
        error_log("Step updated: checklist {$checklistId}, step {$stepIndex}, completed: " . ($completed ? 'yes' : 'no'));
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
    
    public function assignCase()
    {
        if (!Auth::check()) {
            http_response_code(401);
            exit;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $checklistId = $data['checklist_id'] ?? null;
        $caseId = $data['case_id'] ?? null;
        
        if ($checklistId && $caseId) {
            $model = new Checklist();
            $model->updateCaseId($checklistId, $caseId);
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}
