<h1>Сброс пароля</h1>
<p>Придумайте новый пароль для своего аккаунта.</p>

<?php if (!empty($error)): ?>
    <p><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="index.php?route=reset" class="js-ajax" data-message-target="reset-error">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <label>Новый пароль:
        <input type="password" name="password">
    </label>
    <label>Повторите пароль:
        <input type="password" name="password2">
    </label>
    <button type="submit" class="btn">Сохранить</button>
</form>
