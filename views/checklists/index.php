<h1>Мои чек-листы</h1>
<p>Создавайте чек-листы для конкретных кейсов. Каждый чек-лист должен быть привязан к кейсу.</p>

<form method="post" action="index.php?route=checklists/save" class="js-ajax" data-target="checklists-list">
    <label>Название чек-листа:<br>
        <input type="text" name="title" required>
    </label><br><br>
    
    <label>Способ получения гражданства (кейс):<br>
        <select name="case_id" required>
            <option value="">-- Выберите кейс --</option>
            <?php if (!empty($cases)): ?>
                <?php foreach ($cases as $case): ?>
                    <option value="<?php echo $case['id']; ?>">
                        <?php echo htmlspecialchars($case['title']); ?> 
                        (<?php 
                        echo match($case['status']) {
                            'active' => 'Активен',
                            'completed' => 'Завершен',
                            'paused' => 'Приостановлен',
                            'cancelled' => 'Отменен',
                            default => $case['status']
                        }; 
                        ?>)
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </label><br><br>
    
    <label>Шаги (каждый с новой строки):<br>
        <textarea name="steps" rows="6" cols="50" required placeholder="Шаг 1: Подать заявление N-400&#10;Шаг 2: Собрать документы&#10;Шаг 3: Пройти биометрию"></textarea>
    </label><br><br>
    
    <button type="submit">Сохранить</button>
</form>

<hr>
<div id="checklists-list">
    <?php if (!empty($checklists)): ?>
        <div class="checklists-container">
            <?php foreach ($checklists as $c): ?>
                <div class="checklist-card" data-checklist-id="<?php echo $c['id']; ?>">
                    <div class="checklist-header">
                        <h3><?php echo htmlspecialchars($c['title']); ?></h3>
                        <?php if ($c['case_id']): ?>
                            <span class="case-badge" style="background: #e3f2fd; color: #1565c0; padding: 2px 6px; border-radius: 3px; font-size: 11px;">
                                <?php echo htmlspecialchars($c['case_title']); ?>
                                (<?php 
                                echo match($c['case_status']) {
                                    'active' => 'Активен',
                                    'completed' => 'Завершен',
                                    'paused' => 'Приостановлен',
                                    'cancelled' => 'Отменен',
                                    default => $c['case_status']
                                }; 
                                ?>)
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
                        <form method="post" action="index.php?route=checklists/delete" class="js-ajax-admin" style="display: inline; margin-left: 10px;">
                            <input type="hidden" name="checklist_id" value="<?php echo $c['id']; ?>">
                            <button type="submit" class="btn btn-small" style="background: #dc3545; color: white;" onclick="return confirm('Удалить чек-лист?')">Удалить</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>У вас ещё нет чек-листов.</p>
    <?php endif; ?>
</div>

<style>
.checklists-container {
    display: grid;
    gap: 20px;
}

.checklist-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.checklist-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.checklist-header h3 {
    margin: 0;
    color: #333;
}

.case-badge {
    background: #007bff;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.checklist-steps {
    margin-bottom: 15px;
}

.checklist-step {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
    gap: 10px;
}

.checklist-step input[type="checkbox"] {
    margin-top: 2px;
    transform: scale(1.2);
}

.checklist-step label {
    flex: 1;
    cursor: pointer;
    line-height: 1.4;
}

.checklist-step input[type="checkbox"]:checked + label {
    text-decoration: line-through;
    color: #666;
}

.checklist-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

.btn-small {
    padding: 4px 8px;
    font-size: 12px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-small:hover {
    background: #218838;
}
</style>

<script>
function updateStepStatus(checklistId, stepIndex, completed) {
    // Сохраняем статус шага в localStorage или отправляем на сервер
    console.log('Step updated:', checklistId, stepIndex, completed);
    
    // Здесь можно добавить AJAX запрос для сохранения в базу
    fetch('index.php?route=checklists/updateStep', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            checklist_id: checklistId,
            step_index: stepIndex,
            completed: completed
        })
    });
}

function assignToCase(checklistId) {
    // Здесь можно добавить модальное окно для выбора кейса
    const cases = <?php echo json_encode($cases ?? []); ?>;
    
    if (cases.length === 0) {
        alert('У вас нет созданных кейсов. Сначала создайте кейс.');
        return;
    }
    
    let caseOptions = cases.map(c => `Кейс #${c.id} - ${c.status}`).join('\n');
    let selectedCase = prompt(`Выберите кейс (введите номер):\n${caseOptions}`);
    
    if (selectedCase) {
        const caseId = parseInt(selectedCase);
        const caseExists = cases.some(c => c.id === caseId);
        
        if (caseExists) {
            fetch('index.php?route=checklists/assignCase', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    checklist_id: checklistId,
                    case_id: caseId
                })
            }).then(() => {
                location.reload();
            });
        } else {
            alert('Неверный номер кейса');
        }
    }
}
</script>
