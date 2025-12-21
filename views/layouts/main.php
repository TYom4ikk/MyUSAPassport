<?php
if (!isset($pageTitle)) {
    $pageTitle = 'MyUSAPassport';
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
    <script src="<?php echo $baseUrl; ?>/assets/js/app.js" defer></script>
</head>
<body>
<header class="site-header">
    <div class="container">
        <a href="<?php echo $baseUrl; ?>/index.php" class="logo">
            <img src="/assets/images/MUPLogo.png" alt="MUPLogo.png" width="50" height="50">
            <span class="logo-text">MyUSAPassport</span>
        </a>
        <nav class="main-nav">
            <a href="<?php echo $baseUrl; ?>/index.php?route=methods">Способы</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=faq">FAQ</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=case">Документы</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=news">Новости</a>
            <a href="<?php echo $baseUrl; ?>/index.php?route=articles">Статьи</a>
            <?php if (Auth::check()): ?>
                <div class="user-menu">
                    <?php
                    $userModel = new User();
                    $currentUser = $userModel->findByIdWithAvatar(Auth::userId());
                    if ($currentUser):
                    ?>
                        <div class="user-avatar-nav">
                            <?php if (!empty($currentUser['avatar'])): ?>
                                <img src="/<?php echo htmlspecialchars($currentUser['avatar']); ?>" alt="Аватар">
                            <?php else: ?>
                                <div class="avatar-placeholder-nav">
                                    <?php echo strtoupper(substr($currentUser['name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="user-dropdown">
                            <a href="<?php echo $baseUrl; ?>/index.php?route=profile"><?php echo htmlspecialchars($currentUser['name']); ?></a>
                            <?php if (isset($currentUser['role']) && $currentUser['role'] === 'admin'): ?>
                                <a href="<?php echo $baseUrl; ?>/index.php?route=admin">Админ</a>
                                <a href="<?php echo $baseUrl; ?>/index.php?route=admin/testimonials">Отзывы</a>
                            <?php endif; ?>
                            <a href="<?php echo $baseUrl; ?>/index.php?route=logout">Выход</a>
                        </div>
                    <?php endif; ?>
                </div>
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
        <p>MyUSAPassport &copy; <?php echo date('Y'); ?>. Ваш помощник в получении гражданства США.</p>
    </div>
</footer>

<style>
.user-menu {
    position: relative;
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar-nav {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #4a90e2;
    transition: transform 0.2s;
}

.user-avatar-nav:hover {
    transform: scale(1.1);
}

.user-avatar-nav img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-nav {
    width: 100%;
    height: 100%;
    background: #4a90e2;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    min-width: 180px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
    margin-top: 10px;
}

.user-menu:hover .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.user-dropdown a {
    display: block;
    padding: 12px 16px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #eee;
    transition: background 0.2s;
}

.user-dropdown a:hover {
    background: #f8f9fa;
}

.user-dropdown a:first-child {
    border-radius: 8px 8px 0 0;
    font-weight: 500;
}

.user-dropdown a:last-child {
    border-bottom: none;
    border-radius: 0 0 8px 8px;
    color: #dc3545;
}

@media (max-width: 768px) {
    .user-dropdown {
        right: -20px;
    }
}
</style>
</body>
</html>
