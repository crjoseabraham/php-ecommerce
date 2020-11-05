<?php
namespace App\Controller\Helper;

use Mpdf\Mpdf;

class PDF {
    public function __construct() {
        $this->mpdf = new Mpdf();
    }
}