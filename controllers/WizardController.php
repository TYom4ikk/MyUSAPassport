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
        if ($step < 1 || $step > 7) {
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
        $model->saveResult($userId, $data, $result ? 'eligible' : 'not_eligible');

        $pageTitle = 'Результат анкеты';
        $viewFile = __DIR__ . '/../views/wizard/result.php';
        $this->view($viewFile, compact('pageTitle', 'data', 'result'));
    }

    private function calculateResult(array $data): bool
    {
        // очень простой учебный пример логики
        $age = isset($data['age']) ? (int)$data['age'] : 0;
        $yearsInUsa = isset($data['years_in_usa']) ? (int)$data['years_in_usa'] : 0;
        $hasGreenCard = isset($data['status']) && $data['status'] === 'greencard';
        $hasSeriousCrimes = isset($data['serious_crime']) && $data['serious_crime'] === 'yes';
        $taxProblems = isset($data['tax_debts']) && $data['tax_debts'] === 'yes';

        if ($age < 18) {
            return false;
        }
        if ($yearsInUsa < 3) {
            return false;
        }
        if (!$hasGreenCard) {
            return false;
        }
        if ($hasSeriousCrimes) {
            return false;
        }
        if ($taxProblems) {
            return false;
        }
        return true;
    }
}
