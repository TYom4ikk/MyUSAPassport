<h1>Регистрация</h1>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post" action="index.php?route=register">
    <label>Имя:<br>
        <input type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
    </label><br><br>
    <label>Email:<br>
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    </label><br><br>
    <label>Пароль:<br>
        <input type="password" name="password">
    </label><br><br>
    <label>Повторите пароль:<br>
        <input type="password" name="password2">
    </label><br><br>
    <button type="submit">Зарегистрироваться</button>
</form>
