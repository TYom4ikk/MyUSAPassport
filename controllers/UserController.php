<?php

class UserController extends Controller
{
    public function login()
    {
        $pageTitle = 'Вход';
        $viewFile = __DIR__ . '/../views/user/login.php';
        $this->view($viewFile, ['pageTitle' => $pageTitle]);
    }

    public function loginPost()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $error = '';

        if (!$email || !$password) {
            $error = 'Введите email и пароль.';
        } else {
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
                $error = 'Неверный email или пароль.';
            } else {
                Auth::login((int)$user['id']);
            }
        }

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            if ($error) {
                echo json_encode([
                    'success' => false,
                    'message' => $error,
                ]);
            } else {
                echo json_encode([
                    'success'  => true,
                    'message'  => 'Вход выполнен.',
                    'redirect' => 'index.php?route=profile',
                ]);
            }
            exit;
        }

        if ($error) {
            $pageTitle = 'Вход';
            $viewFile = __DIR__ . '/../views/user/login.php';
            $this->view($viewFile, compact('pageTitle', 'error', 'email'));
            return;
        }

        header('Location: index.php?route=profile');
        exit;
    }

    public function register()
    {
        $pageTitle = 'Регистрация';
        $viewFile = __DIR__ . '/../views/user/register.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function registerPost()
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $error = '';

        if (!$name || !$email || !$password || !$password2) {
            $error = 'Заполните все поля.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Некорректный email.';
        } elseif (mb_strlen($password) < 8) {
            $error = 'Пароль должен содержать не менее 8 символов';
        } elseif ($password !== $password2) {
            $error = 'Пароли не совпадают.';
        } else {
            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                $error = 'Пользователь с таким email уже зарегистрирован.';
            } else {
                if ($userModel->create($name, $email, $password)) {
                    $created = $userModel->findByEmail($email);
                    if ($created) {
                        Auth::login((int)$created['id']);
                    }
                } else {
                    $error = 'Ошибка при создании пользователя.';
                }
            }
        }

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            if ($error) {
                echo json_encode([
                    'success' => false,
                    'message' => $error,
                ]);
            } else {
                echo json_encode([
                    'success'  => true,
                    'message'  => 'Регистрация выполнена.',
                    'redirect' => 'index.php?route=profile',
                ]);
            }
            exit;
        }

        if ($error) {
            $pageTitle = 'Регистрация';
            $viewFile = __DIR__ . '/../views/user/register.php';
            $this->view($viewFile, compact('pageTitle', 'error', 'name', 'email'));
            return;
        }

        header('Location: index.php?route=profile');
        exit;
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
            header('Location: /index.php?route=user/login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByIdWithAvatar(Auth::userId());

        if (!$user) {
            $this->show404();
            return;
        }

        $pageTitle = 'Мой профиль';
        $viewFile = __DIR__ . '/../views/user/profile.php';
        $this->view($viewFile, compact('pageTitle', 'user'));
    }

    public function forgot()
    {
        $pageTitle = 'Восстановление пароля';
        $viewFile = __DIR__ . '/../views/user/forgot.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function forgotPost()
    {
        $email = trim($_POST['email'] ?? '');
        $info = '';

        if (!$email) {
            $info = 'Введите email.';
        } else {
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            if (!$user) {
                $info = 'Пользователь с таким email не найден.';
            } else {
                $token = bin2hex(random_bytes(16));
                $expiresAt = date('Y-m-d H:i:s', time() + 3600);
                $reset = new PasswordReset();
                if ($reset->create((int)$user['id'], $token, $expiresAt)) {
                    $link = 'index.php?route=reset&token=' . urlencode($token);
                    $info = 'Ссылка для сброса пароля (учебный пример): ' . $link;
                } else {
                    $info = 'Не удалось создать запрос на сброс пароля.';
                }
            }
        }

        $pageTitle = 'Восстановление пароля';
        $viewFile = __DIR__ . '/../views/user/forgot.php';
        $this->view($viewFile, compact('pageTitle', 'info', 'email'));
    }

    public function reset()
    {
        $token = $_GET['token'] ?? '';
        $error = '';

        if (!$token) {
            $error = 'Токен не передан.';
        } else {
            $resetModel = new PasswordReset();
            $reset = $resetModel->findValid($token);
            if (!$reset) {
                $error = 'Ссылка для сброса пароля недействительна или устарела.';
            }
        }

        $pageTitle = 'Сброс пароля';
        $viewFile = __DIR__ . '/../views/user/reset.php';
        $this->view($viewFile, compact('pageTitle', 'token', 'error'));
    }

    public function resetPost()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $error = '';

        if (!$token) {
            $error = 'Токен не передан.';
        } elseif (!$password || !$password2) {
            $error = 'Введите новый пароль дважды.';
        } elseif ($password !== $password2) {
            $error = 'Пароли не совпадают.';
        } elseif (mb_strlen($password) < 8) {
            $error = 'Пароль должен содержать не менее 8 символов';
        } else {
            $resetModel = new PasswordReset();
            $reset = $resetModel->findValid($token);
            if (!$reset) {
                $error = 'Ссылка для сброса пароля недействительна или устарела.';
            } else {
                global $pdo;
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                if ($stmt->execute([$hash, (int)$reset['user_id']])) {
                    $resetModel->deleteById((int)$reset['id']);
                    header('Location: index.php?route=login');
                    exit;
                } else {
                    $error = 'Не удалось обновить пароль.';
                }
            }
        }

        $pageTitle = 'Сброс пароля';
        $viewFile = __DIR__ . '/../views/user/reset.php';
        $this->view($viewFile, compact('pageTitle', 'token', 'error'));
    }

    public function updateProfile() {
    if (!Auth::check()) {
        $this->jsonResponse(['success' => false, 'message' => 'Требуется авторизация']);
        return;
    }
    $userId = Auth::userId();
    $userModel = new User();
    
    // Получаем текущие данные пользователя
    $currentUser = $userModel->findByIdWithAvatar($userId);
    if (!$currentUser) {
        $this->jsonResponse(['success' => false, 'message' => 'Пользователь не найден']);
        return;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $avatar = null;
        
        // Handle file upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/avatars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileExt = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileExt, $allowedTypes)) {
                $fileName = 'avatar_' . $userId . '_' . time() . '.' . $fileExt;
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                    $avatar = 'uploads/avatars/' . $fileName;
                    
                    // Delete old avatar if exists
                    if (!empty($currentUser['avatar'])) {
                        $oldAvatarPath = __DIR__ . '/../' . $currentUser['avatar'];
                        if (file_exists($oldAvatarPath)) {
                            unlink($oldAvatarPath);
                        }
                    }
                }
            }
        }
        
        // Формируем данные для обновления, сохраняя существующие значения
        $updateData = [
            'name' => $data['name'] ?? $currentUser['name'],
            'email' => $data['email'] ?? $currentUser['email'],
        ];
        
        // Обновляем пароль только если указан новый
        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }
        
        // Обновляем аватар только если загружен новый
        if ($avatar) {
            $updateData['avatar'] = $avatar;
        }
        
        if ($userModel->updateProfile($userId, $updateData)) {
            $this->jsonResponse(['success' => true, 'message' => 'Профиль обновлен', 'avatar' => $avatar]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Ошибка при обновлении профиля']);
        }
    }
    }
}