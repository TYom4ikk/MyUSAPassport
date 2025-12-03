<?php
class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'USACitizenGuide — помощник по получению гражданства США';
        $viewFile = __DIR__ . '/../views/home/index.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function methods()
    {
        $pageTitle = 'Способы получения гражданства США';
        $viewFile = __DIR__ . '/../views/home/methods.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function documents()
    {
        $pageTitle = 'Необходимые документы';
        $viewFile = __DIR__ . '/../views/home/documents.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function contact()
    {
        $pageTitle = 'Форма обратной связи';
        $viewFile = __DIR__ . '/../views/home/contact.php';
        $this->view($viewFile, compact('pageTitle'));
    }
}
