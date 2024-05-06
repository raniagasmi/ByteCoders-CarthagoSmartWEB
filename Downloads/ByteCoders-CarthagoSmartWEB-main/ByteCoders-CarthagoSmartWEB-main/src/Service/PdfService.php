<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');

        $this->dompdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        // Return the PDF content instead of streaming it
        return $this->dompdf->output();
    }

    public function generateBinaryPDF($html)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        // Return the PDF content
        return $this->dompdf->output();
    }

    public function generatePaymentPdf(): string
    {
        $html = '<h1>Payment Receipt</h1>';
        // Add payment information to the HTML content
        $html .= '<p>Montant: $200</p>'; // Example payment amount

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Return the PDF content
        return $this->dompdf->output();
    }
}
