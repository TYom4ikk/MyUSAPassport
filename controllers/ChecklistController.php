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
            http_response_code(401);
            exit;
        }
        
        $title = trim($_POST['title'] ?? '');
        $steps = trim($_POST['steps'] ?? '');
        $caseId = (int)($_POST['case_id'] ?? 0);
        
        if (empty($title) || empty($steps) || empty($caseId)) {
            http_response_code(400);
            echo json_encode(['error' => 'Заполните все поля и выберите кейс']);
            exit;
        }
        
        $model = new Checklist();
        $checklistId = $model->saveForUser(Auth::userId(), $title, $steps, $caseId);
        
        if ($checklistId) {
            // Возвращаем HTML для нового чек-листа
            $checklist = $model->getById($checklistId);
            ob_start();
            ?>
            <div class="card" style="margin-bottom: 10px; padding: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="flex: 1;">
                        <h5><?php echo htmlspecialchars($checklist['title']); ?></h5>
                        <div class="checklist-steps">
                            <?php 
                            $stepLines = explode("\n", trim($checklist['steps']));
                            foreach ($stepLines as $index => $step): 
                                if (!empty(trim($step))):
                            ?>
                                <div class="checklist-step">
                                    <input type="checkbox" id="step_<?php echo $checklist['id'] . '_' . $index; ?>" 
                                           data-checklist-id="<?php echo $checklist['id']; ?>" 
                                           data-step-index="<?php echo $index; ?>">
                                    <label for="step_<?php echo $checklist['id'] . '_' . $index; ?>">
                                        <?php echo htmlspecialchars(trim($step)); ?>
                                    </label>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    <form method="post" action="index.php?route=checklists/delete" style="margin-left: 10px;">
                        <input type="hidden" name="checklist_id" value="<?php echo $checklist['id']; ?>">
                        <input type="hidden" name="case_id" value="<?php echo $caseId; ?>">
                        <button type="submit" class="btn btn-small" style="background: #dc3545; color: white;" onclick="return confirm('Удалить чек-лист?')">Удалить</button>
                    </form>
                </div>
            </div>
            <?php
            $html = ob_get_clean();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'targetId' => 'checklists-list',
                'html' => $html,
                'message' => 'Чек-лист создан'
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Ошибка при создании чек-листа']);
        }
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
    
    public function delete()
    {
        if (!Auth::check()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Требуется авторизация']);
            exit;
        }
        
        $checklistId = (int)($_POST['checklist_id'] ?? 0);
        $userId = Auth::userId();
        
        $checklistModel = new Checklist();
        
        if ($checklistModel->delete($checklistId, $userId)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Чек-лист удален'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ошибка при удалении чек-листа']);
        }
        exit;
    }
}
