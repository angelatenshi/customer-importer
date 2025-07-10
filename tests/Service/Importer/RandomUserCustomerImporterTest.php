<?php

namespace App\Tests\Service\Importer;

use App\Service\Importer\RandomUserCustomerImporter;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RandomUserCustomerImporterTest extends TestCase
{
    public function testFetchCustomersReturnsExpectedData(): void
    {
        $mockData = [
            'results' => [
                [
                    'email' => 'test@example.com',
                    'login' => ['uuid' => '123', 'username' => 'testuser', 'password' => 'secret'],
                    'name' => ['first' => 'Test', 'last' => 'User'],
                    'gender' => 'male',
                    'location' => ['city' => 'Sydney', 'country' => 'Australia'],
                    'phone' => '123456789'
                ]
            ]
        ];

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('toArray')->willReturn($mockData);

        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->method('request')->willReturn($mockResponse);

        $mockParams = $this->createMock(ParameterBagInterface::class);
        $mockParams->method('get')->willReturnMap([
            ['IMPORT_SOURCE_URL', 'https://example.com'],
            ['IMPORT_RESULT_COUNT', 100],
            ['IMPORT_NAT', 'AU'],
        ]);

        $importer = new RandomUserCustomerImporter($mockHttpClient, $mockParams);
        $result = $importer->fetchCustomers();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('test@example.com', $result[0]['email']);
    }

    public function testFetchCustomersHandlesError(): void
    {
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->method('request')->willThrowException(new \Exception('API failure'));

        $mockParams = $this->createMock(ParameterBagInterface::class);
        $mockParams->method('get')->willReturn('irrelevant');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to fetch customers');

        $importer = new RandomUserCustomerImporter($mockHttpClient, $mockParams);
        $importer->fetchCustomers();
    }
}
