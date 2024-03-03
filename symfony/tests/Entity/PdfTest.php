<?php
// tests/Entity/PdfTest.php
namespace App\Tests\Entity;

use App\Entity\Pdf;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $pdf = new Pdf();

        // Définition de données de test
        $title = 'Test';
        // [.. ICI VOS AUTRES SETTERS ..]

        // Utilisation des setters
        $pdf->setTitle($title);

        // Vérification des getters
        $this->assertEquals($title, $pdf->getTitle());
        // [.. ETC ..]
    }
}