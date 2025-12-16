<h1>Новости</h1>
<p>Здесь можно публиковать важные обновления и заметки, связанные с иммиграцией и гражданством США.</p>
<?php if (!empty($items)): ?>
    <ul class="card-list card-list-single">
        <?php foreach ($items as $row): ?>
            <li class="card">
                <?php if (!empty($row['image_url'])): ?>
                    <div style="margin-bottom:6px;">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="max-width:100%; border-radius:8px;">
                    </div>
                <?php endif; ?>
                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                <small><?php echo htmlspecialchars($row['created_at']); ?></small><br>
                <?php echo nl2br(htmlspecialchars(mb_substr($row['content'], 0, 200))); ?>...
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Новостей пока нет. Добавьте записи в таблицу <code>news</code> через phpMyAdmin.</p>
<?php endif; ?>
