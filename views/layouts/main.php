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
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="57" height="30" viewBox="0 0 7410 3900">
                <path d="M0,0h7410v3900H0" fill="#b31942"/>
                <path d="M0,450H7410m0,600H0m0,600H7410m0,600H0m0,600H7410m0,600H0" stroke="#FFF" stroke-width="300"/>
                <path d="M0,0h2964v2100H0" fill="#0a3161"/>
                <g fill="#FFF">
                <g id="s18">
                <g id="s9">
                    <g id="s5">
                    <g id="s4">
                    <path id="s" d="M247,90 317.534230,307.082039 132.873218,172.917961H361.126782L176.465770,307.082039z"/>
                    <use xlink:href="#s" y="420"/>
                    <use xlink:href="#s" y="840"/>
                    <use xlink:href="#s" y="1260"/>
                    </g>
                    <use xlink:href="#s" y="1680"/>
                    </g>
                    <use xlink:href="#s4" x="247" y="210"/>
                </g>
                <use xlink:href="#s9" x="494"/>
                </g>
                <use xlink:href="#s18" x="988"/>
                <use xlink:href="#s9" x="1976"/>
                <use xlink:href="#s5" x="2470"/>
                </g>
            </svg>
            USACitizenGuide
        </div>
        <nav class="main-nav">
            <a href="<?php echo $baseUrl; ?>/index.php">Главная</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=methods">Способы</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=documents">Документы</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=faq">FAQ</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=news">Новости</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=articles">Статьи</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=wizard">Анкета</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=contact">Обратная связь</a>
            <?php if (Auth::check()): ?>
                <a href="<?php echo $baseUrl; ?>/index.php?route=profile">Личный кабинет</a>
                <a href="<?php echo $baseUrl; ?>/index.php?route=logout">Выход</a>
            <?php else: ?>
                <a href="<?php echo $baseUrl; ?>/index.php?route=login">Вход</a>
                <a href="<?php echo $baseUrl; ?>/index.php?route=register">Регистрация</a>
            <?php endif; ?>
            <a href="<?php echo $baseUrl; ?>/index.php?route=admin">Админ</a>
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
