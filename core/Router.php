<?php
class Router
{
    private array $routes = [];

    public function get(string $uri, string $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, string $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $uri, string $method)
    {
        $method = strtoupper($method);

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            [$controllerName, $methodName] = explode('@', $action);

            if (class_exists($controllerName)) {
                $controller = new $controllerName();

                if (method_exists($controller, $methodName)) {
                    return $controller->$methodName();
                }
            }
        }

        // 404 — если маршрут не найден
        http_response_code(404);

        if (class_exists('ErrorController')) {
            $controller = new ErrorController();
            if (method_exists($controller, 'notFound')) {
                return $controller->notFound();
            }
        }

        // Фолбэк, если вдруг ErrorController отсутствует
        require __DIR__ . '/../views/errors/404.php';
    }
}
