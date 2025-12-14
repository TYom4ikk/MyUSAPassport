<div class="page-header">
    <div class="page-header-icon"></div>
    <div class="page-header-text">
        <h1>Личный кабинет</h1>
        <?php if (!empty($user)): ?>
            <small>Учебный личный кабинет USACitizenGuide для отслеживания прогресса и статуса кейса.</small>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($user)): ?>
    <div class="card" style="margin-bottom: 10px;">
        <p>Привет, <?php echo htmlspecialchars($user['name']); ?>!</p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    </div>
<?php endif; ?>

<div class="profile-grid">
    <div class="card">
        <h2>Мои чек-листы</h2>
        <p>Храните свои учебные чек-листы по подготовке к гражданству.</p>
        <p><a href="index.php?route=checklists" class="btn btn-secondary">Перейти к чек-листам</a></p>
    </div>

    <div class="card">
        <h2>Мой кейс</h2>
        <p>Просматривайте статус кейса и загруженные документы.</p>
        <p><a href="index.php?route=case" class="btn btn-secondary">Перейти к кейсу и документам</a></p>
    </div>

    <div class="card">
        <h2>Анкета (wizard)</h2>
        <p>Пройдите учебную анкету, чтобы оценить свои исходные данные и возможный путь к гражданству.</p>
        <p><a href="index.php?route=wizard" class="btn btn-secondary">Открыть анкету</a></p>
    </div>

    <div class="card">
        <h2>Уведомления</h2>
        <?php if (!empty($notifications)): ?>
            <ul>
                <?php foreach ($notifications as $n): ?>
                    <li>
                        <?php echo nl2br(htmlspecialchars($n['message'])); ?><br>
                        <small><?php echo htmlspecialchars($n['created_at']); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Пока нет уведомлений.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>Обратная связь</h2>
        <p>Если хотите протестировать отправку учебного запроса, перейдите к форме обратной связи.</p>
        <p><a href="index.php?route=contact" class="btn btn-secondary">Перейти к форме</a></p>
    </div>
</div>
