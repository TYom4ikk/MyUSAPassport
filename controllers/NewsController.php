<?php
class NewsController extends Controller
{
    public function index()
    {
        $model = new News();
        $items = $model->latest();
        $pageTitle = 'Новости';
        $viewFile = __DIR__ . '/../views/news/index.php';
        $this->view($viewFile, compact('pageTitle', 'items'));
    }
}
