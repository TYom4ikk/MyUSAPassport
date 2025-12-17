<h1>Мои документы для гражданства США</h1>

<?php if (!empty($case)): ?>
    <div class="case-status-card">
        <h3>Статус вашего кейса</h3>
        <p><strong>Номер кейса:</strong> #<?php echo htmlspecialchars($case['id']); ?></p>
        <p><strong>Текущий статус:</strong> <span class="status-badge"><?php echo htmlspecialchars($case['status']); ?></span></p>
    </div>
<?php endif; ?>

<div class="documents-guide">
    <h2>Руководство по документам для получения гражданства США</h2>
    
    <div class="stage-guide">
        <h3>1. Сбор документов</h3>
        <p><strong>Необходимые документы:</strong></p>
        <ul>
            <li>Копия грин-карты (передняя и задняя сторона)</li>
            <li>Копия паспорта</li>
            <li>Свидетельство о рождении (с переводом)</li>
            <li>Справка о несудимости из страны гражданства</li>
            <li>Фотографии паспортного формата (2 шт)</li>
            <li>Квитанции об уплате налогов за последние 5 лет</li>
            <li>Доказательство проживания в США (арендный договор, счета)</li>
        </ul>
    </div>

    <div class="stage-guide">
        <h3>2. Подача заявления (N-400)</h3>
        <p><strong>Документы для подачи:</strong></p>
        <ul>
            <li>Заполненная форма N-400</li>
            <li>Квитанция об оплате пошлины ($725)</li>
            <li>Копии всех документов из этапа 1</li>
            <li>Две цветные фотографии 2x2 дюйма</li>
        </ul>
    </div>

    <div class="stage-guide">
        <h3>3. Биометрия</h3>
        <p><strong>Что происходит:</strong></p>
        <ul>
            <li>Сдача отпечатков пальцев</li>
            <li>Фотография для USCIS</li>
            <li>Подпись на документах</li>
        </ul>
        <p><em>Обычно назначается через 2-4 недели после подачи заявления</em></p>
    </div>

    <div class="stage-guide">
        <h3>4. Интервью</h3>
        <p><strong>Документы на интервью:</strong></p>
        <ul>
            <li>Оригинал грин-карты</li>
            <li>Оригинал паспорта</li>
            <li>Оригинал свидетельства о рождении</li>
            <li>Доказательства брака (если применимо)</li>
            <li>Документы о налогах за последние 5 лет</li>
            <li>Доказательства хорошего морального характера</li>
        </ul>
    </div>

    <div class="stage-guide">
        <h3>5. Дополнительные документы</h3>
        <p><strong>Могут потребоваться:</strong></p>
        <ul>
            <li>Сертификаты о смене имени</li>
            <li>Военные документы</li>
            <li>Судебные решения (если были)</li>
            <li>Документы о предыдущих браках</li>
            <li>Свидетельства о рождении детей</li>
        </ul>
    </div>
</div>

<h2>Загрузка ваших документов</h2>
<p>Загружайте документы по соответствующим этапам. Файлы сохраняются в защищенную папку и доступны только вам и администраторам.</p>

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

.case-status-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
}

.case-status-card h3 {
    margin: 0 0 15px 0;
    color: #495057;
}

.case-status-card p {
    margin: 8px 0;
    color: #6c757d;
}

.documents-guide {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 40px;
}

.documents-guide h2 {
    margin: 0 0 30px 0;
    color: #343a40;
    text-align: center;
}

.stage-guide {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 0 8px 8px 0;
}

.stage-guide h3 {
    margin: 0 0 15px 0;
    color: #007bff;
    font-size: 18px;
}

.stage-guide p {
    margin: 10px 0;
    color: #495057;
}

.stage-guide ul {
    margin: 15px 0;
    padding-left: 20px;
}

.stage-guide li {
    margin: 8px 0;
    color: #6c757d;
    line-height: 1.5;
}

.stage-guide em {
    color: #28a745;
    font-style: italic;
}
</style>

