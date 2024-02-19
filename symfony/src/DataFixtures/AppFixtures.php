<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\PDF;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // SUBSCRIPTIONS
        //     FREE
        $subscriptionFree = new Subscription();
        $subscriptionFree->setTitle('Free');
        $subscriptionFree->setDescription('Abonnement gratuit par défaut, 3 PDF/jour.');
        $subscriptionFree->setPdfLimit(3);
        $subscriptionFree->setPrice(0.00);
            $manager->persist($subscriptionFree);

            //PREMIUM
        $subscriptionPremium = new Subscription();
        $subscriptionPremium->setTitle('Premium');
        $subscriptionPremium->setDescription('Abonnement premium, 20 PDF/jour.');
        $subscriptionPremium->setPdfLimit(20);
        $subscriptionPremium->setPrice(9.99);
            $manager->persist($subscriptionPremium);

            //ULTRA
        $subscriptionUltra = new Subscription();
        $subscriptionUltra->setTitle('Ultra');
        $subscriptionUltra->setDescription('Abonnement Ultra, 100 PDF/jour.');
        $subscriptionUltra->setPdfLimit(100);
        $subscriptionUltra->setPrice(19.99);
            $manager->persist($subscriptionUltra);

        $manager->flush();
    }
}
