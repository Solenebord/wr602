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




class PdfController extends AbstractController
{

    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    // #[Route('/gotenberg', name: 'app_gotenberg')]
    public function generatePdfForm(Request $request, GotenbergService $gotenbergService, UserInterface $user, EntityManagerInterface $entityManager): Response

    {
        $form = $this->createFormBuilder()
            ->add('url', null, ['required' => true])
            ->add('title', TextType::class, ['required' => false])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $request->getPayload()->get('url');
            $title = $request->getPayload()->get('title');
            /* $url = $form->getData()['url'];
            $title = $form->getData()['title']; */

            $pdfContent = $gotenbergService->CreatePdf($url);

            $time = new \DateTimeImmutable;
            // $date = $time->format('Y-m-d H:i:s');

            $newPdf = new PDF;

            if (!empty($title)) { // Vérifiez si le champ 'title' n'est pas vide
                // Si le champ 'title' n'est pas vide, utilisez sa valeur
                $newPdf->setTitle($title);
            } else {
                // Si le champ 'title' est vide, définissez un titre par défaut
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

        return $this->render('pdf/index.html.twig', [
            'form' => $form->createView(),
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