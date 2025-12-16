<?php
class Controller
{
    protected function view(string $view, array $data = [])
    {
        extract($data);
        $viewFile = $view;
        $baseUrl = isset($GLOBALS['baseUrl']) ? $GLOBALS['baseUrl'] : '';
        include __DIR__ . '/../views/layouts/main.php';
    }
    
    protected function jsonResponse(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function show404()
    {
        header('HTTP/1.0 404 Not Found');
        $this->view('errors/404', ['pageTitle' => 'Страница не найдена']);
        exit;
    }
}
