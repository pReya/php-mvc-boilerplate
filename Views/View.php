<?php

namespace Views;

class View
{
    protected $controller, $action;

    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function render()
    {
        $fileName = "Views" . DIRECTORY_SEPARATOR . $this->controller . DIRECTORY_SEPARATOR . $this->action . ".tpl.php";

        if (!file_exists($fileName))
        {
            throw new \Exception("View not found");
        }

        foreach ($this->vars as $key => $val) {
            $$key = $val;
        }

        include $fileName;
    }

    public function setVars(array $vars)
    {
        foreach ($vars as $key => $val) {
            $this->vars[$key] = $val;
        }
    }
}