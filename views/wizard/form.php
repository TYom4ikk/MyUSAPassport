<h1>Какой способ получения гражданства США вам подходит?</h1>
<p>Ответьте на несколько простых вопросов, и мы определим наиболее подходящий для вас путь.</p>

<?php $currentStep = isset($step) ? (int)$step : 1; ?>
<div class="card" style="margin-bottom: 12px;">
    <strong>Шаг <?php echo $currentStep; ?> из 6</strong>
    <p style="margin-top:4px; font-size: 13px;">Ответьте на вопросы и получите персональную рекомендацию.</p>
</div>

<form method="post" action="index.php?route=wizard/submit">
    <input type="hidden" name="step" value="<?php echo $currentStep; ?>">

    <?php if ($currentStep === 1): ?>
        <h2>Ваш текущий статус в США</h2>
        <label>Где вы сейчас живете?
            <select name="current_location">
                <option value="" <?php echo empty($data['current_location']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="outside_usa" <?php echo (isset($data['current_location']) && $data['current_location']==='outside_usa') ? 'selected' : ''; ?>>За пределами США</option>
                <option value="in_usa" <?php echo (isset($data['current_location']) && $data['current_location']==='in_usa') ? 'selected' : ''; ?>>В США</option>
            </select>
        </label>
        <label>У вас есть грин-карта?
            <select name="has_greencard">
                <option value="" <?php echo empty($data['has_greencard']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['has_greencard']) && $data['has_greencard']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['has_greencard']) && $data['has_greencard']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>

    <?php elseif ($currentStep === 2): ?>
        <h2>Семейное положение</h2>
        <label>Состоите ли вы в браке?
            <select name="marital_status">
                <option value="" <?php echo empty($data['marital_status']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="single" <?php echo (isset($data['marital_status']) && $data['marital_status']==='single') ? 'selected' : ''; ?>>Нет</option>
                <option value="married" <?php echo (isset($data['marital_status']) && $data['marital_status']==='married') ? 'selected' : ''; ?>>Да</option>
            </select>
        </label>
        <label>Ваш супруг(а) - гражданин США?
            <select name="spouse_us_citizen">
                <option value="" <?php echo empty($data['spouse_us_citizen']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['spouse_us_citizen']) && $data['spouse_us_citizen']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['spouse_us_citizen']) && $data['spouse_us_citizen']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>

    <?php elseif ($currentStep === 3): ?>
        <h2>Работа и образование</h2>
        <label>У вас есть высшее образование?
            <select name="has_education">
                <option value="" <?php echo empty($data['has_education']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['has_education']) && $data['has_education']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['has_education']) && $data['has_education']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>
        <label>Есть ли у вас специальность, востребованная в США?
            <select name="has_specialty">
                <option value="" <?php echo empty($data['has_specialty']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['has_specialty']) && $data['has_specialty']==='yes') ? 'selected' : ''; ?>>Да (IT, медицина, инженерия и т.д.)</option>
                <option value="no" <?php echo (isset($data['has_specialty']) && $data['has_specialty']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>

    <?php elseif ($currentStep === 4): ?>
        <h2>Финансовые возможности</h2>
        <label>Готовы ли вы инвестировать $800,000+?
            <select name="can_invest">
                <option value="" <?php echo empty($data['can_invest']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['can_invest']) && $data['can_invest']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['can_invest']) && $data['can_invest']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>
        <label>Готовы ли вы служить в армии США?
            <select name="military_ready">
                <option value="" <?php echo empty($data['military_ready']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['military_ready']) && $data['military_ready']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['military_ready']) && $data['military_ready']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>

    <?php elseif ($currentStep === 5): ?>
        <h2>Возраст и опыт</h2>
        <label>Ваш возраст?
            <select name="age">
                <option value="" <?php echo empty($data['age']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="18-25" <?php echo (isset($data['age']) && $data['age']==='18-25') ? 'selected' : ''; ?>>18-25 лет</option>
                <option value="26-35" <?php echo (isset($data['age']) && $data['age']==='26-35') ? 'selected' : ''; ?>>26-35 лет</option>
                <option value="36-45" <?php echo (isset($data['age']) && $data['age']==='36-45') ? 'selected' : ''; ?>>36-45 лет</option>
                <option value="46+" <?php echo (isset($data['age']) && $data['age']==='46+') ? 'selected' : ''; ?>>Более 45 лет</option>
            </select>
        </label>
        <label>Знаете ли вы английский язык?
            <select name="english_level">
                <option value="" <?php echo empty($data['english_level']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="basic" <?php echo (isset($data['english_level']) && $data['english_level']==='basic') ? 'selected' : ''; ?>>Базовый</option>
                <option value="intermediate" <?php echo (isset($data['english_level']) && $data['english_level']==='intermediate') ? 'selected' : ''; ?>>Средний</option>
                <option value="advanced" <?php echo (isset($data['english_level']) && $data['english_level']==='advanced') ? 'selected' : ''; ?>>Продвинутый</option>
            </select>
        </label>

    <?php elseif ($currentStep === 6): ?>
        <h2>Дополнительная информация</h2>
        <label>Есть ли у вас предложения о работе от американских компаний?
            <select name="job_offer">
                <option value="" <?php echo empty($data['job_offer']) ? 'selected' : ''; ?>>Выберите</option>
                <option value="yes" <?php echo (isset($data['job_offer']) && $data['job_offer']==='yes') ? 'selected' : ''; ?>>Да</option>
                <option value="no" <?php echo (isset($data['job_offer']) && $data['job_offer']==='no') ? 'selected' : ''; ?>>Нет</option>
            </select>
        </label>
        <label>Ваш email для получения рекомендаций:
            <input type="email" name="email" value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>">
        </label>
    <?php endif; ?>

    <button type="submit" class="btn"><?php echo $currentStep < 6 ? 'Далее' : 'Получить рекомендацию'; ?></button>
</form>
