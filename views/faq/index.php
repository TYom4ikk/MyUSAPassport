<h1>FAQ по гражданству США</h1>
<p>Короткие ответы на самые частые базовые вопросы. Контент можно расширять через phpMyAdmin.</p>
<?php if (!empty($items)): ?>
    <ul class="card-list">
        <?php foreach ($items as $row): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['question']); ?></strong><br>
                <?php echo nl2br(htmlspecialchars($row['answer'])); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Пока нет вопросов в базе. Можно добавить их через phpMyAdmin в таблицу <code>faq</code>.</p>
<?php endif; ?>
