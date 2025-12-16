<h1>Вход</h1>
<p id="login-error" style="color:red;">
    <?php echo !empty($error) ? htmlspecialchars($error) : ''; ?>
</p>
<form method="post" action="index.php?route=login" class="js-ajax" data-message-target="login-error">
    <label>Email:<br>
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    </label><br><br>
    <label>Пароль:<br>
        <input type="password" name="password">
    </label><br><br>
    <button type="submit">Войти</button>
</form>
<p>Нет аккаунта? <a href="index.php?route=register">Регистрация</a></p>
<p><a href="index.php?route=forgot">Забыли пароль?</a></p>
