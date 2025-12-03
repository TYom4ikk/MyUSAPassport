<?php
class UserController extends Controller
{
    public function login()
    {
        $pageTitle = 'Вход';
        $viewFile = __DIR__ . '/../views/user/login.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function loginPost()
    {
        $model = new User();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = '';

        if ($email && $password) {
            $user = $model->findByEmail($email);
            if ($user && password_verify($password, $user['password_hash'])) {
                Auth::login((int)$user['id']);
                header('Location: index.php?route=profile');
                exit;
            } else {
                $error = 'Неверный логин или пароль';
            }
        } else {
            $error = 'Заполните все поля';
        }

        $pageTitle = 'Вход';
        $viewFile = __DIR__ . '/../views/user/login.php';
        $this->view($viewFile, compact('pageTitle', 'error', 'email'));
    }

    public function register()
    {
        $pageTitle = 'Регистрация';
        $viewFile = __DIR__ . '/../views/user/register.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function registerPost()
    {
        $model = new User();
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $error = '';

        if ($name && $email && $password && $password2) {
            if ($password !== $password2) {
                $error = 'Пароли не совпадают';
            } else {
                $exists = $model->findByEmail($email);
                if ($exists) {
                    $error = 'Пользователь с таким email уже существует';
                } else {
                    if ($model->create($name, $email, $password)) {
                        header('Location: index.php?route=login');
                        exit;
                    } else {
                        $error = 'Ошибка при регистрации';
                    }
                }
            }
        } else {
            $error = 'Заполните все поля';
        }

        $pageTitle = 'Регистрация';
        $viewFile = __DIR__ . '/../views/user/register.php';
        $this->view($viewFile, compact('pageTitle', 'error', 'name', 'email'));
    }

    public function logout()
    {
        Auth::logout();
        header('Location: index.php');
        exit;
    }

    public function profile()
    {
        if (!Auth::check()) {
            header('Location: index.php?route=login');
            exit;
        }

        $userModel = new User();
        $checklistModel = new Checklist();

        $user = $userModel->findById(Auth::userId());
        $checklists = $checklistModel->userChecklists(Auth::userId());

        $pageTitle = 'Личный кабинет';
        $viewFile = __DIR__ . '/../views/user/profile.php';
        $this->view($viewFile, compact('pageTitle', 'user', 'checklists'));
    }
}
