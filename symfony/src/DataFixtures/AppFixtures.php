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
        $subscriptionFree->setDescription('Default subscription, allow you to convert a small amount of PDFs per day.');
        $subscriptionFree->setPdfLimit(2);
        $subscriptionFree->setPrice(0.00);
            $manager->persist($subscriptionFree);

            //PREMIUM
        $subscriptionPremium = new Subscription();
        $subscriptionPremium->setTitle('Premium');
        $subscriptionPremium->setDescription('Premium subscription, allow you to convert a medium amount of PDFs per day.');
        $subscriptionPremium->setPdfLimit(4);
        $subscriptionPremium->setPrice(9.99);
            $manager->persist($subscriptionPremium);

            //ULTRA
        $subscriptionUltra = new Subscription();
        $subscriptionUltra->setTitle('Ultra');
        $subscriptionUltra->setDescription('Ultra subscription, allow you to convert a HUGE amount of PDFs per day!');
        $subscriptionUltra->setPdfLimit(100);
        $subscriptionUltra->setPrice(19.99);
            $manager->persist($subscriptionUltra);

        $manager->flush();
    }
}
