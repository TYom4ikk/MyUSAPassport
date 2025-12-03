<h1>Форма обратной связи</h1>
<?php if (!empty($info)): ?>
    <p><?php echo htmlspecialchars($info); ?></p>
<?php endif; ?>
<form method="post" action="index.php?route=contact">
    <label>Ваше сообщение:<br>
        <textarea name="message" rows="4" cols="40"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
    </label><br>
    <button type="submit">Отправить</button>
    <p><small>Сообщения сохраняются в таблицу <code>inquiries</code> в базе данных.</small></p>
</form>
