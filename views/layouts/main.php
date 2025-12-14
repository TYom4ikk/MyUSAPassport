<?php
if (!isset($pageTitle)) {
    $pageTitle = 'USACitizenGuide';
}
if (!isset($baseUrl) && isset($GLOBALS['baseUrl'])) {
    $baseUrl = $GLOBALS['baseUrl'];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="Простой справочник по получению гражданства США: способы, документы, FAQ, новости, статьи и чек-листы.">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/style.css">
    <?php
    $currentRoute = isset($_GET['route']) ? trim($_GET['route']) : '';
    if ($currentRoute === '') {
        $currentRoute = 'home';
    }
    $routeCssPath = __DIR__ . '/../../assets/css/' . $currentRoute . '.css';
    if (file_exists($routeCssPath)) {
        echo '<link rel="stylesheet" href="' . $baseUrl . '/assets/css/' . $currentRoute . '.css">';
    }
    ?>
</head>
<body>
<header class="site-header">
    <div class="container">
        <a href="<?php echo $baseUrl; ?>/index.php" class="logo">
            <img src="/assets/images/MUPLogo.png" alt="MUPLogo.png" width="140" height="70">
            <span class="logo-text">MyUSAPassport</span>
        </a>
        <nav class="main-nav">
            <a href="<?php echo $baseUrl; ?>/index.php?route=methods">Способы</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=news">Новости</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=articles">Статьи</a>
            <?php if (Auth::check()): ?>
                <a href="<?php echo $baseUrl; ?>/index.php?route=profile">Личный кабинет</a>
                <a href="<?php echo $baseUrl; ?>/index.php?route=logout">Выход</a>
                <?php
                // показать пункт Админ только пользователю с ролью admin
                $userModel = new User();
                $currentUser = $userModel->findById(Auth::userId());
                if ($currentUser && isset($currentUser['role']) && $currentUser['role'] === 'admin'): ?>
                    <a href="<?php echo $baseUrl; ?>/index.php?route=admin">Админ</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo $baseUrl; ?>/index.php?route=login">Вход</a>
                <a href="<?php echo $baseUrl; ?>/index.php?route=register">Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="site-main">
    <div class="container">
        <?php if (isset($viewFile) && file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo '<p>Шаблон не найден</p>';
        } ?>
    </div>
</main>

<footer class="site-footer">
    <div class="container">
        <p>USACitizenGuide &copy; <?php echo date('Y'); ?>. Учебный проект.</p>
    </div>
</footer>
</body>
</html>
