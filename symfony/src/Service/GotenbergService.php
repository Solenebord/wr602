<?php

// src/Service/GotenbergService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function CreatePdf() : string
    {

        $formData = [
            'url' => 'https://bigrat.monster/'
        ];

        $response = $this->client->request(
            'POST',
            'http://localhost:3000/forms/chromium/convert/url',
            [
                'headers' => [
                    'Content-Type' =>'multipart/form-data'
                ],
                'body' => $formData,
                
            ]
        );

        return $response->getContent();
    }
}
