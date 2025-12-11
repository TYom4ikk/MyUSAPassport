<h1>Мой кейс и документы</h1>

<?php if (!empty($case)): ?>
    <div class="card" style="margin-bottom: 10px;">
        <h2>Статус кейса</h2>
        <p><strong>Текущий статус:</strong> <?php echo htmlspecialchars($case['status']); ?></p>
        <p><small>Этот статус можно будет менять в админ‑панели.</small></p>
    </div>
<?php endif; ?>

<?php if (!empty($info)): ?>
    <p><?php echo htmlspecialchars($info); ?></p>
<?php endif; ?>

<div class="card" style="margin-bottom: 12px;">
    <h2>Загрузка документов</h2>
    <p>Это учебный пример. Файлы сохраняются в папку <code>uploads</code> внутри проекта, а путь — в базу данных.</p>
    <form method="post" action="index.php?route=case/upload" enctype="multipart/form-data">
        <label>Этап:
            <select name="stage">
                <option value="">Выберите этап</option>
                <option value="Collecting documents">Сбор документов</option>
                <option value="Ready to file">Готово к подаче</option>
                <option value="Filed">Уже подано</option>
            </select>
        </label>
        <label>Название документа (для себя):
            <input type="text" name="title">
        </label>
        <label>Файл:
            <input type="file" name="file">
        </label>
        <button type="submit" class="btn">Загрузить</button>
    </form>
</div>

<h2>Мои загруженные документы</h2>
<?php if (!empty($documents)): ?>
    <ul class="card-list">
        <?php foreach ($documents as $d): ?>
            <li>
                <strong><?php echo htmlspecialchars($d['title']); ?></strong><br>
                Этап: <?php echo htmlspecialchars($d['stage']); ?><br>
                <a href="<?php echo htmlspecialchars($d['file_path']); ?>" target="_blank">Открыть файл</a><br>
                <small>Загружено: <?php echo htmlspecialchars($d['uploaded_at']); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Документов пока нет.</p>
<?php endif; ?>
