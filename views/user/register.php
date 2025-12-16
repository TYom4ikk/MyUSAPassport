<h1>Регистрация</h1>
<p id="register-error" style="color:red;">
    <?php echo !empty($error) ? htmlspecialchars($error) : ''; ?>
</p>
<form method="post" action="index.php?route=register" class="js-ajax" data-message-target="register-error">
    <label>Имя:<br>
        <input type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
    </label><br><br>
    <label>Email:<br>
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    </label><br><br>
    <label>Пароль:<br>
        <input type="password" name="password" minlength="8">
    </label><br><br>
    <label>Повторите пароль:<br>
        <input type="password" name="password2" minlength="8">
    </label><br><br>
    <button type="submit">Зарегистрироваться</button>
</form>
<p>Уже есть аккаунт? <a href="index.php?route=login">Войти</a></p>

