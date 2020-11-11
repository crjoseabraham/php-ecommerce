<?php
namespace App\Controller\Helper;

use App\Core\View;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class PDF {

    public function __construct() {
        $this->mpdf = new Mpdf([
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 52,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);
        $this->view = new View;
    }

    public function create($title, $css_path = null, $template, $params = null) {
        $this->mpdf->SetTitle($title);

        $html = $this->view->getTemplate($template, $params);
        $css = file_get_contents($css_path);

        $this->mpdf->SetWatermarkText("Paid");
        $this->mpdf->showWatermarkText = true;
        $this->mpdf->watermark_font = 'DejaVuSansCondensed';
        $this->mpdf->watermarkTextAlpha = 0.1;
        $this->mpdf->WriteHTML($css, HTMLParserMode::HEADER_CSS);
        $this->mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
    }

    public function print(string $filename) {
        $this->mpdf->Output($filename, 'I');
    }

    public function email() {}
}