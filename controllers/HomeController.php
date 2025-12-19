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

    public function greencard()
    {
        $pageTitle = 'Лотерея Green Card';
        $viewFile = __DIR__ . '/../views/home/greencard.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function marriage()
    {
        $pageTitle = 'Брак с гражданином США';
        $viewFile = __DIR__ . '/../views/home/marriage.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function investment()
    {
        $pageTitle = 'Инвестиции (EB-5)';
        $viewFile = __DIR__ . '/../views/home/investment.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function military()
    {
        $pageTitle = 'Служба в армии США';
        $viewFile = __DIR__ . '/../views/home/military.php';
        $this->view($viewFile, compact('pageTitle'));
    }

    public function employment()
    {
        $pageTitle = 'Рабочая миграция';
        $viewFile = __DIR__ . '/../views/home/employment.php';
        $this->view($viewFile, compact('pageTitle'));
    }
}

