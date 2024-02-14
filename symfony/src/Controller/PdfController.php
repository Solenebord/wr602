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
   
    
    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

  
    public function generatePdfForm(Request $request): Response
    {
        // https://bigrat.monster/

        // Créer le formulaire
        $form = $this->createFormBuilder()
        ->add('url', null, ['required' => true])
        ->getForm();

        // Afficher le formulaire
        return $this->render('pdf/index.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }

    public function generatePdf(Request $request): Response
    {
        // Récupérer l'URL saisie à partir des données du formulaire
        $url = $request->request->get('url');

        // Faites appel à votre service pour générer le PDF
        $pdf = $this->gotenbergService->CreatePdf($url);

        // Afficher le contenu PDF généré en tant que réponse HTTP
        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }

}