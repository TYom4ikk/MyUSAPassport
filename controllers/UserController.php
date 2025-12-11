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
        // уведомления
        $notificationModel = new Notification();
        $notifications = $notificationModel->latestForUser(Auth::userId(), 5);

        $this->view($viewFile, compact('pageTitle', 'user', 'checklists', 'notifications'));
    }

    public function forgot()
    {
        $pageTitle = 'Восстановление пароля';
        $viewFile = __DIR__ . '/../views/user/forgot.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function forgotPost()
    {
        $email = $_POST['email'] ?? '';
        $info = '';

        if ($email) {
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            if ($user) {
                $token = bin2hex(random_bytes(16));
                $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 час
                $resetModel = new PasswordReset();
                $resetModel->create((int)$user['id'], $token, $expiresAt);

                $link = 'index.php?route=reset&token=' . urlencode($token);
                $info = 'Ссылка для сброса (учебный режим): ' . $link;
            } else {
                $info = 'Пользователь с таким email не найден.';
            }
        } else {
            $info = 'Укажите email.';
        }

        $pageTitle = 'Восстановление пароля';
        $viewFile = __DIR__ . '/../views/user/forgot.php';
        $this->view($viewFile, compact('pageTitle', 'info', 'email'));
    }

    public function reset()
    {
        $token = $_GET['token'] ?? '';
        $resetModel = new PasswordReset();
        $row = $token ? $resetModel->findValid($token) : null;
        if (!$row) {
            echo 'Ссылка недействительна или устарела.';
            return;
        }

        $pageTitle = 'Сброс пароля';
        $viewFile = __DIR__ . '/../views/user/reset.php';
        $this->view($viewFile, compact('pageTitle', 'token'));
    }

    public function resetPost()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $error = '';

        $resetModel = new PasswordReset();
        $row = $token ? $resetModel->findValid($token) : null;
        if (!$row) {
            echo 'Ссылка недействительна или устарела.';
            return;
        }

        if ($password && $password2) {
            if ($password !== $password2) {
                $error = 'Пароли не совпадают.';
            } else {
                global $pdo;
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                $stmt->execute([$hash, $row['user_id']]);
                $resetModel->deleteById((int)$row['id']);
                header('Location: index.php?route=login');
                exit;
            }
        } else {
            $error = 'Заполните оба поля.';
        }

        $pageTitle = 'Сброс пароля';
        $viewFile = __DIR__ . '/../views/user/reset.php';
        $token = $token;
        $this->view($viewFile, compact('pageTitle', 'token', 'error'));
    }
}
