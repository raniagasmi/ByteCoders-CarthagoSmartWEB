<?php

namespace App\Service;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new Dompdf();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();

        // Return the PDF content instead of streaming it
        return $this->domPdf->output();
    }

    public function generateBinaryPDF($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();

        // Return the PDF content
        return $this->domPdf->output();
    }

}