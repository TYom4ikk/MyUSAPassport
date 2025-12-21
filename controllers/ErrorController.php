<?php
class ErrorController extends Controller
{
    public function notFound()
    {
        http_response_code(404);
        $pageTitle = '404: Страница не найдена';
        $viewFile = __DIR__ . '/../views/errors/404.php';
        $this->view($viewFile, compact('pageTitle'));
    }
}
