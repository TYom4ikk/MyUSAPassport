<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Auth.php';
require_once __DIR__ . '/core/Router.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$router = new Router();

// публичные страницы
$router->get('', 'HomeController@index');
$router->get('home', 'HomeController@index');
$router->get('methods', 'HomeController@methods');
$router->get('methods/naturalization', 'HomeController@naturalization');
$router->get('documents', 'HomeController@documents');
$router->get('contact', 'HomeController@contact');
$router->post('contact', 'ContactController@send');

// статьи, новости, FAQ
$router->get('articles', 'ArticleController@index');
$router->get('news', 'NewsController@index');
$router->get('faq', 'FaqController@index');

// пользователь / аутентификация
$router->get('login', 'UserController@login');
$router->post('login', 'UserController@loginPost');
$router->get('register', 'UserController@register');
$router->post('register', 'UserController@registerPost');
$router->get('logout', 'UserController@logout');
$router->get('profile', 'UserController@profile');
$router->post('user/updateProfile', 'UserController@updateProfile');
$router->get('forgot', 'UserController@forgot');
$router->post('forgot', 'UserController@forgotPost');
$router->get('reset', 'UserController@reset');
$router->post('reset', 'UserController@resetPost');

// кейс пользователя (документы)
$router->get('case', 'CaseController@index');
$router->post('case/upload', 'CaseController@upload');

// чек-листы
$router->get('checklists', 'ChecklistController@index');
$router->post('checklists/save', 'ChecklistController@save');
$router->post('checklists/updateStep', 'ChecklistController@updateStep');
$router->post('checklists/assignCase', 'ChecklistController@assignCase');

// админ-панель
$router->get('admin', 'AdminController@index');
$router->post('admin/case/status', 'AdminController@updateCaseStatus');
$router->post('admin/user/role', 'AdminController@updateUserRole');
$router->post('admin/article/create', 'AdminController@createArticle');
$router->post('admin/news/create', 'AdminController@createNews');
$router->post('admin/faq/create', 'AdminController@createFaq');
$router->post('admin/article/delete', 'AdminController@deleteArticle');
$router->post('admin/news/delete', 'AdminController@deleteNews');
$router->post('admin/faq/delete', 'AdminController@deleteFaq');

// админ-панель отзывов
$router->get('admin/testimonials', 'AdminTestimonialController@index');
$router->post('admin/testimonials/approve', 'AdminTestimonialController@approve');
$router->post('admin/testimonials/reject', 'AdminTestimonialController@reject');

// мастер-анкетa (wizard)
$router->get('wizard', 'WizardController@start');
$router->post('wizard/submit', 'WizardController@submit');

$route = isset($_GET['route']) ? trim((string)$_GET['route'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$router->dispatch($route, $method);

