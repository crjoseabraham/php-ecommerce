<?php
namespace App\Core;

use Philo\Blade\Blade;

class View {

    public function __construct() {
        $this->views = dirname(dirname(__DIR__)) . '/resources/views/';
        $this->cache = dirname(dirname(__DIR__)) . '/resources/views/cache';
        $this->blade = new Blade($this->views, $this->cache);
    }

    /**
     * Render a view. If the view is the homepage, get session, product, etc. value first
     *
     * @param string $view
     * @param array $params
     * @return void
     */
    public function render($view, $params = null) {
        echo $this->getTemplate($view, $params);
    }

    public function getTemplate($view, $params = null) {
        if (is_null($params))   // Load views that require no parameters
            return $this->blade->view()->make($view)->render();
        else                    // Load view with parameters
            return $this->blade->view()->make($view)->with($params)->render();
    }
}