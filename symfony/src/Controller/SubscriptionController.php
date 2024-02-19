<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Subscription;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SubscriptionRepository;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionController extends AbstractController
{
    // #[Route('/subscription', name: 'app_subscription')]
    public function index(SubscriptionRepository $subscriptionRepository, Security $security): Response
    {
        $user = $security->getUser();
        
        $subscriptions = $subscriptionRepository->findAll();

        $currentSubscription = $user->getSubscriptionId()->getTitle();
        

        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'subscriptions' => $subscriptions,
            'currentSubscription' => $currentSubscription
        ]);
    }

    public function validation(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {

        $title = $request->request->get('title');

        $subscription = $entityManager->getRepository(Subscription::class)
                                    ->findBy(['title' => $title]);
        
        $user = $security->getUser();

        $user->setSubscriptionId($subscription[0]);
        
        // $user = $security->getUser();

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('subscription/validation.html.twig', [
        'controller_name' => 'SubscriptionController',
        'title' => $title,
        ]);
    }
    

}
