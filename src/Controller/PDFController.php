<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Event;

class PDFController extends AbstractController
{
    /**
     * @Route("/generate-pdf/{id}", name="generate_pdf")
     */
    public function generateEventPdf($id): Response
    {
        // Retrieve event information based on ID
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        // Create an instance of Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        // Generate HTML content for the PDF
        $html = $this->renderView('event_pdf.html.twig', [
            'event' => $event,
        ]);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Render the PDF
        $dompdf->render();

        // Send the PDF as response
        $pdfOutput = $dompdf->output();
        return new Response($pdfOutput, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="event.pdf"',
        ]);
    }
}
