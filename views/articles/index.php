<h1>Статьи</h1>
<p>Небольшие учебные материалы, которые можно дополнять и редактировать напрямую через базу данных.</p>
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
    <p>Статей пока нет. Добавьте их в таблицу <code>articles</code> через phpMyAdmin.</p>
<?php endif; ?>
