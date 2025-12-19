<h1>Редактировать кейс</h1>

<div id="case-edit-message"></div>

<form method="post" action="index.php?route=case/edit&id=<?php echo $case['id']; ?>" class="js-ajax" data-target="case-edit-message">
    <div class="card">
        <h2>Основная информация</h2>
        
        <label>Название кейса *
            <input type="text" name="title" value="<?php echo htmlspecialchars($case['title']); ?>" required style="width: 100%; max-width: 400px;">
        </label>
        
        <label>Способ получения гражданства
            <select name="method" disabled style="width: 100%; max-width: 400px; background: #f8f9fa;">
                <option value="naturalization" <?php echo $case['method'] === 'naturalization' ? 'selected' : ''; ?>>Натурализация</option>
                <option value="greencard" <?php echo $case['method'] === 'greencard' ? 'selected' : ''; ?>>Лотерея Green Card</option>
                <option value="marriage" <?php echo $case['method'] === 'marriage' ? 'selected' : ''; ?>>Брак с гражданином США</option>
                <option value="investment" <?php echo $case['method'] === 'investment' ? 'selected' : ''; ?>>Инвестиции (EB-5)</option>
                <option value="military" <?php echo $case['method'] === 'military' ? 'selected' : ''; ?>>Служба в армии США</option>
                <option value="employment" <?php echo $case['method'] === 'employment' ? 'selected' : ''; ?>>Рабочая миграция</option>
            </select>
            <small>Способ нельзя изменить после создания кейса</small>
        </label>
        
        <label>Статус кейса
            <select name="status" style="width: 100%; max-width: 400px;">
                <option value="active" <?php echo $case['status'] === 'active' ? 'selected' : ''; ?>>Активен</option>
                <option value="completed" <?php echo $case['status'] === 'completed' ? 'selected' : ''; ?>>Завершен</option>
                <option value="paused" <?php echo $case['status'] === 'paused' ? 'selected' : ''; ?>>Приостановлен</option>
                <option value="cancelled" <?php echo $case['status'] === 'cancelled' ? 'selected' : ''; ?>>Отменен</option>
            </select>
        </label>
        
        <label>Описание
            <textarea name="description" placeholder="Опишите ваш случай, цели и текущий статус..." style="width: 100%; height: 120px;"><?php echo htmlspecialchars($case['description']); ?></textarea>
        </label>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="index.php?route=case/view&id=<?php echo $case['id']; ?>" class="btn btn-secondary">Отмена</a>
    </div>
</form>
