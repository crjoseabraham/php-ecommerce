<?php
namespace App\Core;
use Philo\Blade\Blade;

class View {
    public function __construct() {
        $this->views = dirname(dirname(__DIR__)) . '\\resources\\views';
        $this->cache = dirname(dirname(__DIR__)) . '\\resources\\views\\cache';
        $this->blade = new Blade($this->views, $this->cache);
    }

    public function render($view, $params) {
        if (is_null($params))
            echo $this->blade->view()->make($view)->render();
        else
            echo $this->blade->view()->make($view)->with($params)->render();
    }
}