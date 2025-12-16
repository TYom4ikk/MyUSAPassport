<h1>Мои чек-листы</h1>
<p>Здесь можно хранить свои учебные или тестовые чек-листы по подготовке к получению гражданства.</p>
<form method="post" action="index.php?route=checklists/save" class="js-ajax" data-target="checklists-list">
    <label>Название чек-листа:<br>
        <input type="text" name="title">
    </label><br><br>
    <label>Шаги (каждый с новой строки):<br>
        <textarea name="steps" rows="5" cols="40"></textarea>
    </label><br><br>
    <button type="submit">Сохранить</button>
</form>

<hr>
<div id="checklists-list">
    <?php if (!empty($checklists)): ?>
        <ul class="card-list">
            <?php foreach ($checklists as $c): ?>
                <li>
                    <strong><?php echo htmlspecialchars($c['title']); ?></strong><br>
                    <?php echo nl2br(htmlspecialchars($c['steps'])); ?><br>
                    <small><?php echo htmlspecialchars($c['created_at']); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>У вас ещё нет чек-листов.</p>
    <?php endif; ?>
</div>
