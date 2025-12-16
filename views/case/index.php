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
        <select name="stage" required>
            <option value="">-- Выберите этап --</option>
            <option value="Сбор документов">Сбор документов</option>
            <option value="Подача заявления">Подача заявления</option>
            <option value="Биометрия">Биометрия</option>
            <option value="Интервью">Интервью</option>
            <option value="Дополнительные документы">Дополнительные документы</option>
            <option value="Прочее">Прочее</option>
        </select>
    </label><br><br>
    <label>Название документа:<br>
        <input type="text" name="title" required placeholder="Например: Копия грин-карты">
    </label><br><br>
    <label>Файл:<br>
        <input type="file" name="file" required>
    </label><br><br>
    <button type="submit">Загрузить</button>
</form>

<h2>Мои документы</h2>
<div id="case-documents-list">
    <?php if (!empty($documents)): ?>
        <div class="documents-container">
            <?php foreach ($documents as $d): ?>
                <div class="document-card" data-document-id="<?php echo $d['id']; ?>">
                    <div class="document-header">
                        <h4><?php echo htmlspecialchars($d['title']); ?></h4>
                        <?php
                        $statusClass = '';
                        $statusText = '';
                        switch ($d['status']) {
                            case 'pending':
                                $statusClass = 'status-pending';
                                $statusText = 'На рассмотрении';
                                break;
                            case 'under_review':
                                $statusClass = 'status-review';
                                $statusText = 'В обработке';
                                break;
                            case 'approved':
                                $statusClass = 'status-approved';
                                $statusText = 'Одобрен';
                                break;
                            case 'rejected':
                                $statusClass = 'status-rejected';
                                $statusText = 'Отклонен';
                                break;
                        }
                        ?>
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    </div>
                    
                    <div class="document-info">
                        <p><strong>Этап:</strong> <?php echo htmlspecialchars($d['stage']); ?></p>
                        <p><strong>Загружено:</strong> <?php echo htmlspecialchars($d['uploaded_at']); ?></p>
                        <?php if (!empty($d['admin_comment'])): ?>
                            <p><strong>Комментарий администратора:</strong><br>
                                <em><?php echo htmlspecialchars($d['admin_comment']); ?></em></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="document-actions">
                        <a href="<?php echo htmlspecialchars($d['file_path']); ?>" target="_blank" class="btn btn-small">Открыть файл</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Документов пока нет.</p>
    <?php endif; ?>
</div>

<style>
.documents-container {
    display: grid;
    gap: 20px;
    margin-top: 20px;
}

.document-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.document-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.document-header h4 {
    margin: 0;
    color: #333;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-pending {
    background: #ffc107;
    color: #333;
}

.status-review {
    background: #17a2b8;
    color: white;
}

.status-approved {
    background: #28a745;
    color: white;
}

.status-rejected {
    background: #dc3545;
    color: white;
}

.document-info {
    margin-bottom: 15px;
}

.document-info p {
    margin: 5px 0;
    color: #555;
}

.document-actions {
    display: flex;
    gap: 10px;
}

.btn-small {
    padding: 6px 12px;
    font-size: 12px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
}

.btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background: #0056b3;
}
</style>

