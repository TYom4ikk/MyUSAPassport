<?php

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Главная — MyUSAPassport';
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
        $pageTitle = 'Документы для получения гражданства США';
        $viewFile = __DIR__ . '/../views/home/documents.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function contact()
    {
        $pageTitle = 'Обратная связь';
        $viewFile = __DIR__ . '/../views/home/contact.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function naturalization()
    {
        $pageTitle = 'Натурализация — путь к гражданству США';
        $viewFile = __DIR__ . '/../views/home/naturalization.php';
        $this->view($viewFile, compact('pageTitle'));
    }
}

