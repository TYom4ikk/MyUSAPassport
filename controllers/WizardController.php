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
        if ($step < 1 || $step > 10) {
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

        if ($step < 9) {
            $next = $step + 1;
            header('Location: index.php?route=wizard&step=' . $next);
            exit;
        }

        // последний шаг: считаем результат
        $data = $_SESSION['wizard'];
        $result = $this->calculateResult($data);

        $model = new Wizard();
        $userId = Auth::userId();
        $model->saveResult($userId, $data, $result['eligible'] ? 'eligible' : 'not_eligible');

        $pageTitle = 'Результат анкеты';
        $viewFile = __DIR__ . '/../views/wizard/result.php';
        $this->view($viewFile, compact('pageTitle', 'data', 'result'));
    }

    private function calculateResult(array $data): array
    {
        $score = 0;
        $maxScore = 100;
        
        // Возраст (15 баллов)
        $age = isset($data['age']) ? (int)$data['age'] : 0;
        if ($age >= 18) {
            $score += 15;
        }
        
        // Green Card (25 баллов) - самый важный фактор
        $hasGreenCard = isset($data['status']) && $data['status'] === 'greencard';
        if ($hasGreenCard) {
            $score += 25;
        }
        
        // Проживание в США (20 баллов)
        $yearsInUsa = isset($data['years_in_usa']) ? (int)$data['years_in_usa'] : 0;
        if ($yearsInUsa >= 5) {
            $score += 20;
        } elseif ($yearsInUsa >= 3) {
            $score += 15;
        } elseif ($yearsInUsa >= 1) {
            $score += 10;
        }
        
        // Отсутствие судимостей (15 баллов)
        $hasSeriousCrimes = isset($data['serious_crime']) && $data['serious_crime'] === 'yes';
        if (!$hasSeriousCrimes) {
            $score += 15;
        }
        
        // Налоги (10 баллов)
        $taxProblems = isset($data['tax_debts']) && $data['tax_debts'] === 'yes';
        $filesTaxes = isset($data['file_taxes']) && $data['file_taxes'] === 'yes';
        if (!$taxProblems && $filesTaxes) {
            $score += 10;
        } elseif (!$taxProblems) {
            $score += 5;
        }
        
        // Брак с гражданином США (бонус 10 баллов)
        $marriedToCitizen = isset($data['married_to_citizen']) && $data['married_to_citizen'] === 'yes';
        if ($marriedToCitizen && $yearsInUsa >= 3) {
            $score += 10;
        }
        
        // Английский язык (5 баллов)
        $englishLevel = isset($data['english_level']) ? $data['english_level'] : '';
        if ($englishLevel === 'fluent' || $englishLevel === 'advanced') {
            $score += 5;
        }
        
        $probability = round(($score / $maxScore) * 100);
        
        return [
            'score' => $score,
            'probability' => $probability,
            'eligible' => $probability >= 60
        ];
    }
}
