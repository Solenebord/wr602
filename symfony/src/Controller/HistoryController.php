<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pdf;
use App\Entity\User;
use App\Repository\PdfRepository;
use Doctrine\ORM\EntityManagerInterface;

class HistoryController extends AbstractController
{
    // #[Route('/history', name: 'app_history')]
    public function index(PdfRepository $pdfRepository, Security $security, EntityManagerInterface $entityManager): Response
    {

        $user = $security->getUser();

        $userId = $user->getId();


        $pdfs = $entityManager->getRepository(Pdf::class)
        ->findBy(['userId' => $userId]);

        return $this->render('history/index.html.twig', [
            'controller_name' => 'HistoryController',
            'pdfs' => $pdfs,
        ]);
    }
}
