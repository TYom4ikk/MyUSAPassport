<h1>Новости</h1>
<p>Здесь можно публиковать важные обновления и заметки, связанные с иммиграцией и гражданством США.</p>
<?php if (!empty($items)): ?>
    <ul class="card-list">
        <?php foreach ($items as $row): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                <small><?php echo htmlspecialchars($row['created_at']); ?></small><br>
                <?php echo nl2br(htmlspecialchars(mb_substr($row['content'], 0, 200))); ?>...
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Новостей пока нет. Добавьте записи в таблицу <code>news</code> через phpMyAdmin.</p>
<?php endif; ?>
