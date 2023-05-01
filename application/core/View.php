<?php
namespace application\core;

class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path  = $route['controller'] . "/" . $route['action'];
    }
    public function render($vars = [])
    {
        extract($vars); //transform array key to variable
        $path = 'application/views/' . $this->path . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layouts/default.php';
        }
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public static function errorCode($code)
    {
        $path = 'application/views/errors/' . $code . '.php';
        http_response_code($code);
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }
}
