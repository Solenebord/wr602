<?php 

// tests/Service/GotenberTest.php

namespace App\Tests\Service;

use App\Service\GotenbergService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GotenbergTest extends TestCase
{
    public function TestCreatePdf(): void
    {
        // Mock HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        // Configure the mock
        $httpClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'http://localhost:3000/forms/chromium/convert/url',
                [
                    'headers' => [
                        'Content-Type' =>'multipart/form-data'
                    ],
                    'body' => [
                        'url' => 'https://bigrat.monster/'
                    ],
                ]
            )
            ->willReturn($this->createMock(ResponseInterface::class));

        // Mock ResponseInterface
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getContent')
            ->willReturn('PDF Content');

        // Create GotenbergService instance
        $gotenbergService = new GotenbergService($httpClient);

        // Call the method to be tested
        $pdfContent = $gotenbergService->CreatePdf();

        // Assert that the method returns the expected PDF content
        $this->assertEquals('PDF Content', $pdfContent);
    }
}
