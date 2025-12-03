<h1>Вход</h1>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post" action="index.php?route=login">
    <label>Email:<br>
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    </label><br><br>
    <label>Пароль:<br>
        <input type="password" name="password">
    </label><br><br>
    <button type="submit">Войти</button>
</form>
<p>Нет аккаунта? <a href="index.php?route=register">Регистрация</a></p>
