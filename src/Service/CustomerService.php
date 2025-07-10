<?php

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class CustomerService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function saveOrUpdate(array $data): void
    {
        $repo = $this->em->getRepository(Customer::class);

        $existing = $repo->findOneBy(['email' => $data['email']]);

        $customer = $existing ?? new Customer();

        $customer->setUuid($data['login']['uuid']);
        $customer->setFirstName($data['name']['first']);
        $customer->setLastName($data['name']['last']);
        $customer->setEmail($data['email']);
        $customer->setUsername($data['login']['username']);
        $customer->setGender($data['gender']);
        $customer->setCountry($data['location']['country']);
        $customer->setCity($data['location']['city']);
        $customer->setPhone($data['phone']);
        $customer->setPassword(md5($data['login']['password'])); // Required re-hash

        $this->em->persist($customer);
        $this->em->flush();
    }
}
