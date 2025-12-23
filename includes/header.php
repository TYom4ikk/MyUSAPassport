<?php
// Защита значений по умолчанию
$page_title = $page_title ?? 'MyUSAPassport';
$page_description = $page_description ?? 'Простой справочник по получению гражданства США.';
$page_url = $page_url ?? 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$page_image = $page_image ?? '/assets/images/main-background.jpg';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($page_title) ?></title>
<meta name="description" content="<?= htmlspecialchars($page_description) ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
<meta property="og:url" content="<?= htmlspecialchars($page_url) ?>">
<meta property="og:image" content="<?= htmlspecialchars($page_image) ?>">
<meta property="og:site_name" content="MyUSAPassport">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($page_description) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($page_image) ?>">

<link rel="stylesheet" href="/assets/css/style.css">
<script src="/assets/js/app.js" defer></script>
</head>