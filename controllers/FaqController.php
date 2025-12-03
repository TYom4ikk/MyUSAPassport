<?php
class FaqController extends Controller
{
    public function index()
    {
        $model = new Faq();
        $items = $model->all();
        $pageTitle = 'FAQ по гражданству США';
        $viewFile = __DIR__ . '/../views/faq/index.php';
        $this->view($viewFile, compact('pageTitle', 'items'));
    }
}
