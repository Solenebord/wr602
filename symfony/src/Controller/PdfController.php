<?php

// src/Controller/PdfController.php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    private $gotenbergService;

    
    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    // #[Route('/convert/pdf', name: 'generate-pdf')]
    public function CreatePdf(): Response
    {
        // $htmlContent = '<html><body><h1>Hello, world!</h1></body></html>';
        $pdfContent = $this->gotenbergService->CreatePdf();

        // Affichez le contenu PDF généré en tant que réponse HTTP
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]); 

        // return new Response('PDF généré avec succès !');
    }
}
