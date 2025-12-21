<?php
require_once __DIR__ . '/../../models/Case.php';
?>

<h1><?php echo htmlspecialchars($case['title']); ?></h1>

<div class="card">
    <h2>Информация о кейсе</h2>
    
    <p><strong>Способ:</strong> <?php echo MigrationCase::getMethodTitle($case['method']); ?></p>
    
    <p><strong>Статус:</strong> 
        <span style="padding: 2px 8px; border-radius: 3px; font-size: 12px; background: <?php 
            echo match($case['status']) {
                'active' => '#d4edda',
                'completed' => '#d1ecf1',
                'paused' => '#fff3cd',
                'cancelled' => '#f8d7da',
                default => '#e2e3e5'
            }; 
        ?>; color: <?php 
            echo match($case['status']) {
                'active' => '#155724',
                'completed' => '#0c5460',
                'paused' => '#856404',
                'cancelled' => '#721c24',
                default => '#383d41'
            }; 
        ?>;">
            <?php 
            echo match($case['status']) {
                'active' => 'Активен',
                'completed' => 'Завершен',
                'paused' => 'Приостановлен',
                'cancelled' => 'Отменен',
                default => $case['status']
            }; 
            ?>
        </span>
    </p>
    
    <?php if (!empty($case['description'])): ?>
        <p><strong>Описание:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($case['description'])); ?></p>
    <?php endif; ?>
    
    <p style="font-size: 12px; color: #6c757d;">
        Создан: <?php echo date('d.m.Y H:i', strtotime($case['created_at'])); ?>
        <?php if ($case['updated_at'] !== $case['created_at']): ?>
            | Обновлен: <?php echo date('d.m.Y H:i', strtotime($case['updated_at'])); ?>
        <?php endif; ?>
    </p>
</div>

<div class="card">
    <h2>Действия</h2>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="index.php?route=case/edit&id=<?php echo $case['id']; ?>" class="btn btn-secondary">Редактировать кейс</a>
        <a href="index.php?route=checklists&case_id=<?php echo $case['id']; ?>" class="btn btn-primary">Чек-листы</a>
        <a href="index.php?route=methods/<?php echo $case['method']; ?>" class="btn btn-secondary">Информация о способе</a>
    </div>
</div>

<div class="card">
    <h2>Чек-листы</h2>
    <p>Создавайте и управляйте чек-листами для этого кейса:</p>
    
    <form method="post" action="index.php?route=checklists/save" class="js-ajax" data-target="case-checklists-list">
        <input type="hidden" name="case_id" value="<?php echo $case['id']; ?>">
        <label>Название чек-листа:<br>
            <input type="text" name="title" required style="width: 100%; max-width: 300px;">
        </label><br><br>
        
        <label>Шаги (каждый с новой строки):<br>
            <textarea name="steps" rows="4" cols="50" required placeholder="Шаг 1: Подать заявление&#10;Шаг 2: Собрать документы" style="width: 100%; max-width: 400px;"></textarea>
        </label><br><br>
        
        <button type="submit" class="btn btn-primary">Создать чек-лист</button>
    </form>
    
    <div id="case-checklists-list">
        <?php
        // Загружаем чек-листы для этого кейса
        $checklistModel = new Checklist();
        $caseChecklists = $checklistModel->getByCaseId($case['id']);
        
        if (!empty($caseChecklists)): ?>
            <div style="margin-top: 20px;">
                <h4>Чек-листы этого кейса:</h4>
                <?php foreach ($caseChecklists as $cl): ?>
                    <div class="card" style="margin-bottom: 10px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div style="flex: 1;">
                                <h5><?php echo htmlspecialchars($cl['title']); ?></h5>
                                <div class="checklist-steps">
                                    <?php 
                                    $steps = explode("\n", trim($cl['steps']));
                                    foreach ($steps as $index => $step): 
                                        if (!empty(trim($step))):
                                    ?>
                                        <div class="checklist-step">
                                            <input type="checkbox" id="step_<?php echo $cl['id'] . '_' . $index; ?>" 
                                                   data-checklist-id="<?php echo $cl['id']; ?>" 
                                                   data-step-index="<?php echo $index; ?>"
                                                   <?php echo $cl['completed_steps'][$index] ?? false ? 'checked' : ''; ?>>
                                            <label for="step_<?php echo $cl['id'] . '_' . $index; ?>">
                                                <?php echo htmlspecialchars(trim($step)); ?>
                                            </label>
                                        </div>
                                    <?php endif; endforeach; ?>
                                </div>
                            </div>
                            <form method="post" action="index.php?route=checklists/delete" class="js-ajax-admin" style="margin-left: 10px;">
                                <input type="hidden" name="checklist_id" value="<?php echo $cl['id']; ?>">
                                <input type="hidden" name="case_id" value="<?php echo $case['id']; ?>">
                                <button type="submit" class="btn btn-small" style="background: #dc3545; color: white;" onclick="return confirm('Удалить чек-лист?')">Удалить</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <h2>Документы</h2>
    <p>Загружайте документы, необходимые для вашего кейса:</p>
    
    <form method="post" action="index.php?route=case/upload&case_id=<?php echo $case['id']; ?>" enctype="multipart/form-data" class="js-ajax" data-target="case-documents-list" data-message-target="case-upload-message">
        <label>Этап/категория
            <input type="text" name="stage" placeholder="Например: Личные документы" required>
        </label>
        
        <label>Название документа
            <input type="text" name="title" placeholder="Например: Копия паспорта" required>
        </label>
        
        <label>Файл
            <input type="file" name="file" required>
        </label>
        
        <button type="submit" class="btn btn-primary">Загрузить документ</button>
    </form>
    
    <div id="case-upload-message"></div>
    <div id="case-documents-list">
        <?php if (!empty($documents)): ?>
            <ul class="card-list">
                <?php foreach ($documents as $d): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($d['title']); ?></strong><br>
                        Этап: <?php echo htmlspecialchars($d['stage']); ?><br>
                        Статус: <span style="padding: 2px 6px; border-radius: 3px; font-size: 11px; background: <?php 
                            echo match($d['status']) {
                                'pending' => '#fff3cd',
                                'under_review' => '#cce5ff',
                                'approved' => '#d4edda',
                                'rejected' => '#f8d7da',
                                default => '#e2e3e5'
                            }; 
                        ?>; color: <?php 
                            echo match($d['status']) {
                                'pending' => '#856404',
                                'under_review' => '#004085',
                                'approved' => '#155724',
                                'rejected' => '#721c24',
                                default => '#6c757d'
                            }; 
                        ?>;"><?php echo (new CaseDocument())->getStatusTitle($d['status']); ?></span><br>
                        <a href="<?php echo htmlspecialchars($d['file_path']); ?>" target="_blank">Открыть файл</a><br>
                        <small>Загружено: <?php echo htmlspecialchars($d['uploaded_at']); ?></small>
                        
                        <?php if ($d['status'] === 'rejected' && !empty($d['admin_comment'])): ?>
                            <br><small style="color: #721c24;"><strong>Комментарий администратора:</strong> <?php echo htmlspecialchars($d['admin_comment']); ?></small>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Документов пока нет.</p>
        <?php endif; ?>
    </div>
</div>

<div style="margin-top: 20px;">
    <a href="index.php?route=case" class="btn btn-secondary">← Все кейсы</a>
    <a href="index.php?route=profile" class="btn btn-secondary">Личный кабинет</a>
</div>
