<h1>Восстановление пароля</h1>
<p>Учебный пример: здесь можно запросить ссылку на сброс пароля по email.</p>

<?php if (!empty($info)): ?>
    <p><?php echo htmlspecialchars($info); ?></p>
<?php endif; ?>

<form method="post" action="index.php?route=forgot" class="js-ajax" data-message-target="forgot-error">
    <label>Email:
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    </label>
    <button type="submit" class="btn">Отправить ссылку</button>
</form>
