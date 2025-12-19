<?php
class WizardController extends Controller
{
    private function ensureSession()
    {
        if (!isset($_SESSION['wizard'])) {
            $_SESSION['wizard'] = [];
        }
    }

    public function start()
    {
        $this->ensureSession();
        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
        if ($step < 1 || $step > 6) {
            $step = 1;
        }

        $data = $_SESSION['wizard'];
        $pageTitle = 'Анкета по гражданству (шаг ' . $step . ')';
        $viewFile = __DIR__ . '/../views/wizard/form.php';
        $this->view($viewFile, compact('pageTitle', 'step', 'data'));
    }

    public function submit()
    {
        $this->ensureSession();
        $step = isset($_POST['step']) ? (int)$_POST['step'] : 1;

        // сохраняем то, что пришло с формы, в сессию
        foreach ($_POST as $key => $value) {
            if ($key === 'step') continue;
            $_SESSION['wizard'][$key] = trim((string)$value);
        }

        if ($step < 6) {
            $next = $step + 1;
            header('Location: index.php?route=wizard&step=' . $next);
            exit;
        }

        // последний шаг: считаем результат
        $data = $_SESSION['wizard'];
        $result = $this->calculateResult($data);

        $model = new Wizard();
        $userId = Auth::userId();
        $model->saveResult($userId, $data, $result['recommendations'][0]['title'] ?? 'Нет рекомендаций');

        $pageTitle = 'Результат анкеты';
        $viewFile = __DIR__ . '/../views/wizard/result.php';
        $this->view($viewFile, compact('pageTitle', 'data', 'result'));
    }

    private function calculateResult(array $data): array
    {
        $recommendations = [];
        
        // 1. Проверяем натурализацию
        if (isset($data['has_greencard']) && $data['has_greencard'] === 'yes') {
            $recommendations[] = [
                'method' => 'naturalization',
                'title' => 'Натурализация',
                'description' => 'У вас уже есть грин-карта, вы можете подавать на гражданство',
                'priority' => 'high'
            ];
        }
        
        // 2. Проверяем брак с гражданином США
        if (isset($data['marital_status']) && $data['marital_status'] === 'married' &&
            isset($data['spouse_us_citizen']) && $data['spouse_us_citizen'] === 'yes') {
            $recommendations[] = [
                'method' => 'marriage',
                'title' => 'Брак с гражданином США',
                'description' => 'Брак с гражданином США - прямой путь к гражданству',
                'priority' => 'high'
            ];
        }
        
        // 3. Проверяем инвестиции
        if (isset($data['can_invest']) && $data['can_invest'] === 'yes') {
            $recommendations[] = [
                'method' => 'investment',
                'title' => 'Инвестиции (EB-5)',
                'description' => 'Инвестиционная программа EB-5 для получения грин-карты',
                'priority' => 'medium'
            ];
        }
        
        // 4. Проверяем военную службу
        if (isset($data['military_ready']) && $data['military_ready'] === 'yes' &&
            isset($data['age']) && in_array($data['age'], ['18-25', '26-35'])) {
            $recommendations[] = [
                'method' => 'military',
                'title' => 'Служба в армии США',
                'description' => 'Военная служба предоставляет ускоренный путь к гражданству',
                'priority' => 'medium'
            ];
        }
        
        // 5. Проверяем рабочую миграцию
        if ((isset($data['has_education']) && $data['has_education'] === 'yes') ||
            (isset($data['has_specialty']) && $data['has_specialty'] === 'yes') ||
            (isset($data['job_offer']) && $data['job_offer'] === 'yes')) {
            $recommendations[] = [
                'method' => 'employment',
                'title' => 'Рабочая миграция',
                'description' => 'Получение грин-карты через работу или востребованную специальность',
                'priority' => 'medium'
            ];
        }
        
        // 6. Проверяем лотерею Green Card (для всех, кто не подходит под другие варианты)
        if (empty($recommendations) || 
            (isset($data['current_location']) && $data['current_location'] === 'outside_usa')) {
            $recommendations[] = [
                'method' => 'greencard',
                'title' => 'Лотерея Green Card',
                'description' => 'Ежегодная лотерея грин-карт - шанс на иммиграцию',
                'priority' => 'low'
            ];
        }
        
        // Сортируем по приоритету
        usort($recommendations, function($a, $b) {
            $priority = ['high' => 3, 'medium' => 2, 'low' => 1];
            return $priority[$b['priority']] - $priority[$a['priority']];
        });
        
        return [
            'recommendations' => $recommendations,
            'total_methods' => count($recommendations)
        ];
    }
}
