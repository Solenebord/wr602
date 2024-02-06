<?php
// tests/Entity/SubscriptionTest.php
namespace App\Tests\Entity;

use App\Entity\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité Subscription
        $subscription = new Subscription();

        // Définition de données de test
        $title = 'Premium';
        // [.. ICI VOS AUTRES SETTERS ..]

        // Utilisation des setters
        $subscription->setTitle($title);

        // Vérification des getters
        $this->assertEquals($title, $subscription->getTitle());
        // [.. ETC ..]
    }
}