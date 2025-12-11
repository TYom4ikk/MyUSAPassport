<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Auth.php';

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

session_start();

$router = new Router();

$router->get('', 'HomeController@index');
$router->get('methods', 'HomeController@methods');
$router->get('faq', 'FaqController@index');
$router->get('news', 'NewsController@index');
$router->get('articles', 'ArticleController@index');
$router->get('documents', 'HomeController@documents');
$router->get('contact', 'HomeController@contact');
$router->post('contact', 'ContactController@send');

$router->get('login', 'UserController@login');
$router->post('login', 'UserController@loginPost');
$router->get('register', 'UserController@register');
$router->post('register', 'UserController@registerPost');
$router->get('logout', 'UserController@logout');
$router->get('profile', 'UserController@profile');

$router->get('checklists', 'ChecklistController@index');
$router->post('checklists/save', 'ChecklistController@save');

$router->get('wizard', 'WizardController@start');
$router->post('wizard/submit', 'WizardController@submit');

$router->get('case', 'CaseController@index');
$router->post('case/upload', 'CaseController@upload');

$router->get('admin', 'AdminController@index');
$router->post('admin/case/status', 'AdminController@updateCaseStatus');
$router->post('admin/user/role', 'AdminController@updateUserRole');
$router->post('admin/article/create', 'AdminController@createArticle');
$router->post('admin/news/create', 'AdminController@createNews');
$router->post('admin/faq/create', 'AdminController@createFaq');

$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($route, $method);
