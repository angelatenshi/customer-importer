<?php

namespace App\Service\Importer;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RandomUserCustomerImporter implements CustomerImporterInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {}

    public function fetchCustomers(): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://randomuser.me/api/', [
                'query' => ['results' => 100, 'nat' => 'AU']
            ]);

            $data = $response->toArray();
            return $data['results'] ?? [];

        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to fetch customers: ' . $e->getMessage());
        }
    }
}
