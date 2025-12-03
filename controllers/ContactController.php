<?php
class ContactController extends Controller
{
    public function send()
    {
        $message = $_POST['message'] ?? '';
        $info = '';
        if ($message) {
            $model = new Inquiry();
            $userId = Auth::userId();
            if ($model->create($userId, $message)) {
                $info = 'Сообщение отправлено (сохранено в БД).';
            } else {
                $info = 'Ошибка при отправке сообщения.';
            }
        } else {
            $info = 'Введите сообщение.';
        }

        $pageTitle = 'Форма обратной связи';
        $viewFile = __DIR__ . '/../views/home/contact.php';
        $this->view($viewFile, compact('pageTitle', 'info', 'message'));
    }
}
