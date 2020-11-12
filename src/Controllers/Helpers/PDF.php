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

    /**
     * Create a .pdf document
     *
     * @param string $title
     * @param string $css_path
     * @param string $template
     * @param array $params
     * @return void
     */
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

    /**
     * Print a .pdf document created previously
     *
     * @param string $filename
     * @return void
     */
    public function print(string $filename) {
        $this->mpdf->Output($filename, 'D');
    }

    /**
     * Email a .pdf document created previously
     *
     * @param string $to
     * @param string $subject
     * @param string $text
     * @param string $html
     * @param string $filename
     * @return void
     */
    public function email($to, $subject, $text, $html, $filename) {
        $pdf_string = $this->mpdf->Output('', 'S');
        Mail::send($to, $subject, $text, $html, $pdf_string, $filename);
    }
}