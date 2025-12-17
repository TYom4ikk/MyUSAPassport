<h1>Анкета по гражданству США</h1>
<p>Это упрощённый учебный опросник. Данные не отправляются в реальные службы, а просто сохраняются в базу.</p>

<?php $currentStep = isset($step) ? (int)$step : 1; ?>
<div class="card" style="margin-bottom: 12px;">
    <strong>Шаг <?php echo $currentStep; ?> из 10</strong>
    <p style="margin-top:4px; font-size: 13px;">Заполните поля и нажмите "Далее". В конце вы увидите детальный анализ вашей ситуации и рекомендации.</p>
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

    <?php elseif ($currentStep === 7): ?>
        <h2>Семейное положение</h2>
        <label>Ваше семейное положение:
            <select name="marital_status">
                <option value="" <?php echo empty($data['marital_status']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="single" <?php echo (isset($data['marital_status']) && $data['marital_status']==='single') ? 'selected' : ''; ?>>Холост/не замужем</option>
                <option value="married" <?php echo (isset($data['marital_status']) && $data['marital_status']==='married') ? 'selected' : ''; ?>>В браке</option>
                <option value="divorced" <?php echo (isset($data['marital_status']) && $data['marital_status']==='divorced') ? 'selected' : ''; ?>>Разведен(а)</option>
                <option value="widowed" <?php echo (isset($data['marital_status']) && $data['marital_status']==='widowed') ? 'selected' : ''; ?>>Вдовец/вдова</option>
            </select>
        </label>
        <label>Состоите ли вы в браке с гражданином США?
            <select name="married_to_citizen">
                <option value="" <?php echo empty($data['married_to_citizen']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="no" <?php echo (isset($data['married_to_citizen']) && $data['married_to_citizen']==='no') ? 'selected' : ''; ?>>Нет</option>
                <option value="yes" <?php echo (isset($data['married_to_citizen']) && $data['married_to_citizen']==='yes') ? 'selected' : ''; ?>>Да</option>
            </select>
        </label>

    <?php elseif ($currentStep === 8): ?>
        <h2>Знание английского языка</h2>
        <label>Оцените свой уровень английского:
            <select name="english_level">
                <option value="" <?php echo empty($data['english_level']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="beginner" <?php echo (isset($data['english_level']) && $data['english_level']==='beginner') ? 'selected' : ''; ?>>Начальный</option>
                <option value="intermediate" <?php echo (isset($data['english_level']) && $data['english_level']==='intermediate') ? 'selected' : ''; ?>>Средний</option>
                <option value="advanced" <?php echo (isset($data['english_level']) && $data['english_level']==='advanced') ? 'selected' : ''; ?>>Продвинутый</option>
                <option value="fluent" <?php echo (isset($data['english_level']) && $data['english_level']==='fluent') ? 'selected' : ''; ?>>Свободный</option>
            </select>
        </label>
        <label>Готовы ли вы проходить тест на английском языке?
            <select name="ready_for_english_test">
                <option value="" <?php echo empty($data['ready_for_english_test']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['ready_for_english_test']) && $data['ready_for_english_test']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['ready_for_english_test']) && $data['ready_for_english_test']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>

    <?php elseif ($currentStep === 9): ?>
        <h2>История поездок</h2>
        <label>Были ли длительные поездки за пределы США (более 6 месяцев) за последние 5 лет?
            <select name="long_trips">
                <option value="" <?php echo empty($data['long_trips']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="no" <?php echo (isset($data['long_trips']) && $data['long_trips']==='no') ? 'selected' : ''; ?>>Нет</option>
                <option value="yes" <?php echo (isset($data['long_trips']) && $data['long_trips']==='yes') ? 'selected' : ''; ?>>Да</option>
            </select>
        </label>
        <label>Общее время отсутствия в США за последние 5 лет:
            <select name="total_time_outside">
                <option value="" <?php echo empty($data['total_time_outside']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="less_than_6_months" <?php echo (isset($data['total_time_outside']) && $data['total_time_outside']==='less_than_6_months') ? 'selected' : ''; ?>>Менее 6 месяцев</option>
                <option value="6_to_12_months" <?php echo (isset($data['total_time_outside']) && $data['total_time_outside']==='6_to_12_months') ? 'selected' : ''; ?>>6-12 месяцев</option>
                <option value="more_than_12_months" <?php echo (isset($data['total_time_outside']) && $data['total_time_outside']==='more_than_12_months') ? 'selected' : ''; ?>>Более 12 месяцев</option>
            </select>
        </label>

    <?php elseif ($currentStep === 10): ?>
        <h2>Дополнительная информация</h2>
        <label>Были ли проблемы с иммиграционной службой (нарушение статуса, депортация)?
            <select name="immigration_problems">
                <option value="" <?php echo empty($data['immigration_problems']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="no" <?php echo (isset($data['immigration_problems']) && $data['immigration_problems']==='no') ? 'selected' : ''; ?>>Нет</option>
                <option value="yes" <?php echo (isset($data['immigration_problems']) && $data['immigration_problems']==='yes') ? 'selected' : ''; ?>>Да</option>
            </select>
        </label>
        <label>Прохождение военной службы в США:
            <select name="military_service">
                <option value="" <?php echo empty($data['military_service']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="no" <?php echo (isset($data['military_service']) && $data['military_service']==='no') ? 'selected' : ''; ?>>Не служил(а)</option>
                <option value="yes" <?php echo (isset($data['military_service']) && $data['military_service']==='yes') ? 'selected' : ''; ?>>Да, служил(а) в вооруженных силах США</option>
            </select>
        </label>
        <label>Дополнительные комментарии:
            <textarea name="additional_comments"><?php echo isset($data['additional_comments']) ? htmlspecialchars($data['additional_comments']) : ''; ?></textarea>
        </label>
    <?php endif; ?>

    <button type="submit" class="btn"><?php echo $currentStep < 10 ? 'Далее' : 'Показать результат'; ?></button>
</form>
