<h1>Личный кабинет</h1>
<?php if (!empty($user)): ?>
    <p>Привет, <?php echo htmlspecialchars($user['name']); ?>!</p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<?php endif; ?>

<h2>Мои чек-листы</h2>
<p><a href="index.php?route=checklists">Перейти к чек-листам</a></p>
