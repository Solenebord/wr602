<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Subscription;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Pdf;
use App\Repository\PdfRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class PdfController extends AbstractController
{

    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    public function generatePdfForm(Request $request, GotenbergService $gotenbergService, UserInterface $user, EntityManagerInterface $entityManager, PdfRepository $pdfRepository, SessionInterface $session): Response
    {
        // par défault l'utilisateur est autorisé à générer des pdf
        $isAllowed = true;

        $form = $this->createFormBuilder()
            ->add('url', null, ['required' => true])
            ->add('title', TextType::class, ['required' => false])
            ->getForm();
        $form->handleRequest($request);

        // récupérer la limite de pdf de l'abonnement
        $pdfLimit = $user->getSubscriptionId()->getPdfLimit();
        
        // Récupérer la date actuelle
        $startOfDay = new \DateTime('today midnight');
        $endOfDay = new \DateTime('tomorrow midnight');
            
        // Compter le nombre de PDF générés pour la journée actuelle
        $pdfCount = $pdfRepository->countPdfGeneratedByUserOnDate($user->getId(), $startOfDay, $endOfDay);
            
        // Vérifier si l'utilisateur a dépassé la limite de PDF
        if ($pdfCount >= $pdfLimit) {
            // si la limite pdf est atteinte
            $isAllowed = false;
        } else { 
            // si l'utilisateur n'a pas dépassé la limite -> afficher le formulaire
            if ($form->isSubmitted() && $form->isValid()) {
                $url = $request->getPayload()->get('url');
                $title = $request->getPayload()->get('title');
    
                $pdfContent = $gotenbergService->CreatePdf($url);
    
                $time = new \DateTimeImmutable;
                // $date = $time->format('Y-m-d H:i:s');
    
                $newPdf = new PDF;
    
                if (!empty($title)) { // Vérifier si le champ est remlpi
                    $newPdf->setTitle($title);
                } else {
                    $newPdf->setTitle('PDF');
                }
    
                $newPdf
                ->setUserId($user)
                // ->setTitle('PDF')
                ->setCreatedAt($time)
                ->setContent($pdfContent);
    
                $entityManager->persist($newPdf);
                $entityManager->flush();
    
                return new Response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
            ]);
            }

        }
        
        return $this->render('pdf/index.html.twig', [
            'form' => $form->createView(),
            'pdfLimit' => $pdfLimit,
            'isAllowed' => $isAllowed,
        ]);
    }


    // public function generatePdfHtml(GotenbergService $gotenbergService): Response
    // {
    //     $htmlContent = new File('../../public/uploads/html/index.html');
    //     $pdfContent = $gotenbergService->generatePdfFromHtml($htmlContent);

    //     return new Response($pdfContent, 200, [
    //         'Content-Type' => 'application/pdf',
    //     ]);
    // }

    
//     public function index(): Response
//     {
//         return $this->render('gotenberg/index.html.twig', [
//             'controller_name' => 'GotenbergController',
//             'form' => $form->createView(),
//         ]);
//     }
}