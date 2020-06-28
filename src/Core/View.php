<?php
namespace App\Core;

use Philo\Blade\Blade;
use App\Controller\Products as Products;

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
    public function render($view, $params) {
        if ($view === "layouts/home")
            echo $this->blade->view()->make($view)->with($this->getHomeParams())->render();
        elseif (is_null($params))
            echo $this->blade->view()->make($view)->render();
        else
            echo $this->blade->view()->make($view)->with($params)->render();
    }

    /**
     * Get the needed parameters to load the homepage properly: product list, session info, etc.
     *
     * @return array
     */
    private function getHomeParams() {
        return [
            "sessions" => "Sessions array goes here",
            "products" => (new Products())->getProducts(),
            // Just to show something different
            "products2" => (new Products())->getNotSoRandomProducts()
        ];
    }
}