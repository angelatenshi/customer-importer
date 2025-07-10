<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customers', name: 'customers_')]
class CustomerController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(CustomerRepository $customerRepository): JsonResponse
    {
        $customers = $customerRepository->findAll();

        $data = array_map(function (Customer $customer) {
            return [
                'full_name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
                'email' => $customer->getEmail(),
                'country' => $customer->getCountry(),
            ];
        }, $customers);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Customer $customer): JsonResponse
    {
        $data = [
            'full_name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ];

        return $this->json($data);
    }
}
