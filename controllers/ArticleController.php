<?php
class ArticleController extends Controller
{
    public function index()
    {
        $model = new Article();
        $items = $model->latest();
        $pageTitle = 'Статьи';
        $viewFile = __DIR__ . '/../views/articles/index.php';
        $this->view($viewFile, compact('pageTitle', 'items'));
    }
}
