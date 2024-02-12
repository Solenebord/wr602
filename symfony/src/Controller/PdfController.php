<?php

// src/Controller/PdfController.php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    private $gotenbergService;
   
    #[Route('/convert/pdf', name: 'app_generate_pdf_form')]
    public function generatePdfForm(Request $request): Response
    {
        return $this->render('pdf/index.html.twig');
    }
    
    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    #[Route('/convert/pdf/generate', name: 'app_generate_pdf', methods: ['POST'])]
    public function CreatePdf(Request $request): Response
    {
        // $formData = 'https://bigrat.monster/';
        $formData = $request->request->get('formData');
        // $htmlContent = '<html><body><h1>Hello, world!</h1></body></html>';
        $pdfContent = $this->gotenbergService->CreatePdf($formData);

        // Affichez le contenu PDF généré en tant que réponse HTTP
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]
    ); 

        // return new Response('PDF généré avec succès !');
    }
}
