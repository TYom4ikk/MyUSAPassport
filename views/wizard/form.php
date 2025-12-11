<h1>Анкета по гражданству США</h1>
<p>Это упрощённый учебный опросник. Данные не отправляются в реальные службы, а просто сохраняются в базу.</p>

<?php $currentStep = isset($step) ? (int)$step : 1; ?>
<div class="card" style="margin-bottom: 12px;">
    <strong>Шаг <?php echo $currentStep; ?> из 6</strong>
    <p style="margin-top:4px; font-size: 13px;">Заполните поля и нажмите "Далее". В конце вы увидите примерный вывод: можно ли подавать заявление или лучше ещё подготовиться.</p>
</div>

<form method="post" action="index.php?route=wizard/submit">
    <input type="hidden" name="step" value="<?php echo $currentStep; ?>">

    <?php if ($currentStep === 1): ?>
        <h2>Персональная информация</h2>
        <label>Имя:
            <input type="text" name="full_name" value="<?php echo isset($data['full_name']) ? htmlspecialchars($data['full_name']) : ''; ?>">
        </label>
        <label>Возраст:
            <input type="number" name="age" value="<?php echo isset($data['age']) ? htmlspecialchars($data['age']) : ''; ?>">
        </label>
        <label>Страна гражданства сейчас:
            <input type="text" name="current_citizenship" value="<?php echo isset($data['current_citizenship']) ? htmlspecialchars($data['current_citizenship']) : ''; ?>">
        </label>

    <?php elseif ($currentStep === 2): ?>
        <h2>История проживания</h2>
        <label>Сколько лет вы живёте в США постоянно?
            <input type="number" name="years_in_usa" value="<?php echo isset($data['years_in_usa']) ? htmlspecialchars($data['years_in_usa']) : ''; ?>">
        </label>
        <label>Жили ли вы за пределами США последние 5 лет (подробности):
            <textarea name="outside_usa_details"><?php echo isset($data['outside_usa_details']) ? htmlspecialchars($data['outside_usa_details']) : ''; ?></textarea>
        </label>

    <?php elseif ($currentStep === 3): ?>
        <h2>Миграционный статус</h2>
        <label>Текущий статус в США:
            <select name="status">
                <option value="" <?php echo empty($data['status']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="greencard" <?php echo (isset($data['status']) && $data['status']==='greencard') ? 'selected' : ''; ?>>Постоянный резидент (Green Card)</option>
                <option value="visa" <?php echo (isset($data['status']) && $data['status']==='visa') ? 'selected' : ''; ?>>Виза (турист, студент, рабочая)</option>
                <option value="out_of_status" <?php echo (isset($data['status']) && $data['status']==='out_of_status') ? 'selected' : ''; ?>>Без статуса / просроченная виза</option>
            </select>
        </label>
        <label>Основание получения статуса (например, брак, работа, убежище):
            <input type="text" name="status_basis" value="<?php echo isset($data['status_basis']) ? htmlspecialchars($data['status_basis']) : ''; ?>">
        </label>

    <?php elseif ($currentStep === 4): ?>
        <h2>Работа и путешествия</h2>
        <label>Работаете ли вы в США официально?
            <select name="official_job">
                <option value="" <?php echo empty($data['official_job']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['official_job']) && $data['official_job']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['official_job']) && $data['official_job']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>
        <label>Были ли частые поездки за границу за последние годы? Куда и почему:
            <textarea name="travel_details"><?php echo isset($data['travel_details']) ? htmlspecialchars($data['travel_details']) : ''; ?></textarea>
        </label>

    <?php elseif ($currentStep === 5): ?>
        <h2>Судимости</h2>
        <label>Были ли серьёзные нарушения закона (уголовные дела и т.п.)?
            <select name="serious_crime">
                <option value="" <?php echo empty($data['serious_crime']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="no" <?php echo (isset($data['serious_crime']) && $data['serious_crime']==='no') ? 'selected' : ''; ?>>Нет</option>
                <option value="yes" <?php echo (isset($data['serious_crime']) && $data['serious_crime']==='yes') ? 'selected' : ''; ?>>Да</option>
            </select>
        </label>
        <label>Если да, кратко опишите ситуацию:
            <textarea name="crime_details"><?php echo isset($data['crime_details']) ? htmlspecialchars($data['crime_details']) : ''; ?></textarea>
        </label>

    <?php elseif ($currentStep === 6): ?>
        <h2>Налоговая история</h2>
        <label>Подаёте ли вы налоговые декларации в США?
            <select name="file_taxes">
                <option value="" <?php echo empty($data['file_taxes']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['file_taxes']) && $data['file_taxes']==='yes') ? 'selected' : ''; ?>>Да, регулярно</option>
                <option value="no" <?php echo (isset($data['file_taxes']) && $data['file_taxes']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>
        <label>Есть ли серьёзные задолженности перед налоговой?
            <select name="tax_debts">
                <option value="" <?php echo empty($data['tax_debts']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="no" <?php echo (isset($data['tax_debts']) && $data['tax_debts']==='no') ? 'selected' : ''; ?>>Нет</option>
                <option value="yes" <?php echo (isset($data['tax_debts']) && $data['tax_debts']==='yes') ? 'selected' : ''; ?>>Да</option>
            </select>
        </label>
    <?php endif; ?>

    <button type="submit" class="btn"><?php echo $currentStep < 6 ? 'Далее' : 'Показать результат'; ?></button>
</form>
