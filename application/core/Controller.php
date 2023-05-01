<?php
namespace application\core;

use application\core\View;

abstract class Controller
{
    public $route;
    public $view;
    public function __construct($route)
    {
        $this->route = $route;
        $this->view  = new View($route);
        date_default_timezone_set('Asia/Bishkek');
        $this->model        = $this->loadModel($route['controller']);
        $this->view->layout = $route['controller'];
    }

    public function loadModel($name)
    {
        $path = 'application\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path();
        }
    }
}
