<h1>Мой кейс и документы</h1>

<?php if (!empty($case)): ?>
    <p>Номер кейса: <?php echo htmlspecialchars($case['id']); ?>, статус: <?php echo htmlspecialchars($case['status']); ?></p>
<?php endif; ?>

<h2>Загрузка документов</h2>
<p>Файлы сохраняются в папку <code>uploads</code> внутри проекта, а путь — в базу данных.</p>

<p id="case-upload-message" style="color: green;">
    <?php echo !empty($info) ? htmlspecialchars($info) : ''; ?>
</p>

<form method="post"
      action="index.php?route=case/upload"
      enctype="multipart/form-data"
      class="js-ajax"
      data-target="case-documents-list"
      data-message-target="case-upload-message">
    <label>Этап:<br>
        <input type="text" name="stage">
    </label><br><br>
    <label>Название документа:<br>
        <input type="text" name="title">
    </label><br><br>
    <label>Файл:<br>
        <input type="file" name="file">
    </label><br><br>
    <button type="submit">Загрузить</button>
</form>

<h2>Мои документы</h2>
<div id="case-documents-list">
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
</div>

