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
}
